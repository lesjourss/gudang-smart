<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman utama Dashboard Inventory GudangSmart.
     */
    public function index()
    {
        // 3 Buah Card Ringkasan sesuai instruksi Soal 2.3
        $totalSupplier = Supplier::count();
        $totalJenisBarang = Barang::count();
        $totalStokFisik = Barang::sum('stok');

        // Data tambahan untuk grafik / tabel ringkas
        $totalKategori = KategoriBarang::count();
        $barangTerbaru = Barang::with(['supplier', 'kategori'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalSupplier',
            'totalJenisBarang',
            'totalStokFisik',
            'totalKategori',
            'barangTerbaru'
        ));
    }
}

