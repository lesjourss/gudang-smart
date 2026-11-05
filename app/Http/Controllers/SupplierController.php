<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Tampilkan daftar supplier dengan pencarian dan paginasi.
     */
    public function index(Request $request)
    {
        $query = Supplier::withCount('barang');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pt', 'like', "%{$search}%")
                  ->orWhere('kode_supplier', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->latest()->paginate(10)->withQueryString();

        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Tampilkan formulir tambah supplier (Hanya Manager).
     */
    public function create()
    {
        $this->authorizeManager();

        return view('suppliers.create');
    }

    /**
     * Simpan supplier baru ke basis data (Hanya Manager).
     */
    public function store(Request $request)
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'kode_supplier' => ['required', 'string', 'size:10', 'unique:suppliers,kode_supplier'],
            'nama_pt' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
        ], [
            'kode_supplier.required' => 'Kode supplier wajib diisi.',
            'kode_supplier.size' => 'Kode supplier harus tepat 10 karakter.',
            'kode_supplier.unique' => 'Kode supplier sudah terdaftar.',
            'nama_pt.required' => 'Nama PT / Perusahaan wajib diisi.',
            'email.required' => 'Email supplier wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'alamat.required' => 'Alamat supplier wajib diisi.',
        ]);

        Supplier::create($validated);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Data supplier berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail supplier beserta daftar barang yang dipasok.
     */
    public function show(Supplier $supplier)
    {
        $supplier->load(['barang.kategori']);

        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Tampilkan formulir edit supplier (Hanya Manager).
     */
    public function edit(Supplier $supplier)
    {
        $this->authorizeManager();

        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Perbarui data supplier (Hanya Manager).
     */
    public function update(Request $request, Supplier $supplier)
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'kode_supplier' => [
                'required',
                'string',
                'size:10',
                Rule::unique('suppliers', 'kode_supplier')->ignore($supplier->id)
            ],
            'nama_pt' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
        ]);

        $supplier->update($validated);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Data supplier berhasil diperbarui!');
    }

    /**
     * Hapus supplier (Soft Delete, Hanya Manager).
     */
    public function destroy(Supplier $supplier)
    {
        $this->authorizeManager();

        $supplier->delete();

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Data supplier berhasil dipindahkan ke tempat sampah (Soft Delete).');
    }

    /**
     * Helper untuk memvalidasi peran Manager.
     */
    protected function authorizeManager(): void
    {
        if (Auth::user()?->role !== 'manager') {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk mengelola data supplier.');
        }
    }
}

