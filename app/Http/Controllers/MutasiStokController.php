<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\MutasiStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MutasiStokController extends Controller
{
    /**
     * Tampilkan riwayat transaksi mutasi penerimaan dan pengeluaran barang.
     */
    public function index(Request $request)
    {
        $query = MutasiStok::with(['barang.kategori', 'user'])->latest();

        if ($request->filled('jenis_mutasi')) {
            $query->where('jenis_mutasi', $request->jenis_mutasi);
        }

        if ($request->filled('barang_id')) {
            $query->where('barang_id', $request->barang_id);
        }

        $mutasi = $query->paginate(10)->withQueryString();
        $barangList = Barang::orderBy('nama_barang')->get();

        return view('mutasi.index', compact('mutasi', 'barangList'));
    }

    /**
     * Tampilkan formulir pencatatan transaksi mutasi (Dapat diakses oleh Manager dan Staff).
     */
    public function create()
    {
        $barangList = Barang::orderBy('nama_barang')->get();

        return view('mutasi.create', compact('barangList'));
    }

    /**
     * Simpan transaksi mutasi dan sesuaikan kuantitas stok barang di gudang secara otomatis.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => ['required', 'exists:barang,id'],
            'jenis_mutasi' => ['required', 'in:masuk,keluar'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ], [
            'barang_id.required' => 'Barang wajib dipilih.',
            'barang_id.exists' => 'Barang yang dipilih tidak valid.',
            'jenis_mutasi.required' => 'Jenis mutasi wajib dipilih.',
            'jenis_mutasi.in' => 'Jenis mutasi harus berupa barang masuk atau barang keluar.',
            'jumlah.required' => 'Jumlah barang wajib diisi.',
            'jumlah.min' => 'Jumlah mutasi minimal 1 unit.',
        ]);

        $barang = Barang::findOrFail($validated['barang_id']);

        // Validasi ketersediaan stok fisik jika transaksi adalah barang keluar
        if ($validated['jenis_mutasi'] === 'keluar' && $barang->stok < $validated['jumlah']) {
            return back()->withErrors([
                'jumlah' => "Stok gudang tidak mencukupi! Stok saat ini: {$barang->stok} unit, tetapi diminta keluar {$validated['jumlah']} unit."
            ])->withInput();
        }

        // Jalankan transaksi database (ACID) untuk memastikan integritas stok
        DB::transaction(function () use ($validated, $barang) {
            MutasiStok::create([
                'barang_id' => $barang->id,
                'user_id' => Auth::id(),
                'jenis_mutasi' => $validated['jenis_mutasi'],
                'jumlah' => $validated['jumlah'],
                'keterangan' => $validated['keterangan'] ?? ($validated['jenis_mutasi'] === 'masuk' ? 'Penerimaan barang dari supplier' : 'Pengeluaran barang produksi'),
            ]);

            // Sesuaikan kuantitas stok fisik pada tabel barang
            if ($validated['jenis_mutasi'] === 'masuk') {
                $barang->increment('stok', $validated['jumlah']);
            } else {
                $barang->decrement('stok', $validated['jumlah']);
            }
        });

        $tipeTeks = $validated['jenis_mutasi'] === 'masuk' ? 'penerimaan' : 'pengeluaran';
        return redirect()->route('admin.mutasi.index')
            ->with('success', "Transaksi {$tipeTeks} sebanyak {$validated['jumlah']} unit untuk '{$barang->nama_barang}' berhasil dicatat dan stok gudang telah diperbarui!");
    }
}

