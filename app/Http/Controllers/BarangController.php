<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    /**
     * Tampilkan daftar katalog barang dengan Eager Loading, Search & Filter, serta Pagination.
     */
    public function index(Request $request)
    {
        // 1. Eager Loading relasi supplier dan kategori untuk mencegah N+1 Query Problem
        $query = Barang::with(['supplier', 'kategori']);

        // 2. Fitur Pencarian Dinamis (berdasarkan nama_barang atau kode_barang)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%");
            });
        }

        // 3. Fitur Penyaringan (Filtering) berdasarkan kategori_id
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // 4. Pagination: Batasan 10 data per halaman dengan menjaga query parameter
        $barang = $query->latest()->paginate(10)->withQueryString();

        // Data pendukung filter kategori di view
        $kategoriList = KategoriBarang::orderBy('nama_kategori')->get();

        return view('barang.index', compact('barang', 'kategoriList'));
    }

    /**
     * Tampilkan formulir tambah barang baru.
     */
    public function create()
    {
        $kategoriList = KategoriBarang::orderBy('nama_kategori')->get();
        $supplierList = Supplier::orderBy('nama_pt')->get();

        return view('barang.create', compact('kategoriList', 'supplierList'));
    }

    /**
     * Simpan data barang baru dengan Form Request Validation.
     */
    public function store(StoreBarangRequest $request)
    {
        Barang::create($request->validated());

        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang baru berhasil ditambahkan ke katalog inventaris!');
    }

    /**
     * Tampilkan detail barang beserta relasi supplier dan kategori.
     */
    public function show(Barang $barang)
    {
        $barang->load(['supplier', 'kategori']);

        return view('barang.show', compact('barang'));
    }

    /**
     * Tampilkan formulir ubah data barang.
     */
    public function edit(Barang $barang)
    {
        $kategoriList = KategoriBarang::orderBy('nama_kategori')->get();
        $supplierList = Supplier::orderBy('nama_pt')->get();

        return view('barang.edit', compact('barang', 'kategoriList', 'supplierList'));
    }

    /**
     * Perbarui data barang dengan Form Request Validation.
     */
    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        $barang->update($request->validated());

        return redirect()->route('admin.barang.index')
            ->with('success', 'Data barang berhasil diperbarui!');
    }

    /**
     * Hapus barang secara sementara (Soft Delete).
     * Sesuai Soal 5: Hanya Manager yang dapat menghapus barang.
     */
    public function destroy(Barang $barang)
    {
        $this->authorizeManager('menghapus barang');

        $barang->delete();

        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang berhasil dipindahkan ke tempat sampah (Soft Delete).');
    }

    /**
     * Tampilkan daftar barang yang terhapus sementara (Trash).
     */
    public function trash()
    {
        $this->authorizeManager('melihat data sampah/trash');

        // Mengambil hanya data yang terhapus sementara (Soft Deleted) dengan Eager Loading
        $barangTrashed = Barang::onlyTrashed()
            ->with(['supplier', 'kategori'])
            ->latest('deleted_at')
            ->paginate(10);

        return view('barang.trash', compact('barangTrashed'));
    }

    /**
     * Pulihkan data barang yang terhapus sementara (Restore).
     */
    public function restore(string|int $id)
    {
        $this->authorizeManager('memulihkan data barang');

        $barang = Barang::onlyTrashed()->findOrFail($id);
        $barang->restore();

        return redirect()->route('admin.barang.trash')
            ->with('success', "Barang '{$barang->nama_barang}' berhasil dipulihkan kembali ke katalog!");
    }

    /**
     * Hapus barang secara permanen dari basis data (Force Delete).
     */
    public function forceDelete(string|int $id)
    {
        $this->authorizeManager('menghapus barang secara permanen');

        $barang = Barang::onlyTrashed()->findOrFail($id);
        $namaBarang = $barang->nama_barang;
        $barang->forceDelete();

        return redirect()->route('admin.barang.trash')
            ->with('success', "Barang '{$namaBarang}' telah dihapus secara permanen dari basis data.");
    }

    /**
     * Otorisasi khusus pengguna dengan peran Manager.
     */
    protected function authorizeManager(string $action): void
    {
        if (Auth::user()?->role !== 'manager') {
            abort(403, "Akses Ditolak: Peran akun Anda tidak memiliki hak akses untuk {$action}.");
        }
    }
}

