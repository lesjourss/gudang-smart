<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
    /**
     * Tampilkan daftar klasifikasi kategori barang inventaris.
     */
    public function index(Request $request)
    {
        $query = KategoriBarang::withCount('barang');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_kategori', 'like', "%{$search}%")
                  ->orWhere('kode_kategori', 'like', "%{$search}%");
            });
        }

        $kategori = $query->orderBy('nama_kategori')->paginate(10)->withQueryString();

        return view('kategori.index', compact('kategori'));
    }
}

