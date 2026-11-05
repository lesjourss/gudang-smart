@extends('layouts.app')

@section('title', 'Detail Barang: ' . $barang->nama_barang)

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-zinc-500 mb-2">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-zinc-900 transition">Dashboard</a>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.barang.index') }}" class="hover:text-zinc-900 transition">Katalog Barang</a>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-zinc-900 font-medium">Detail</span>
    </div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">{{ $barang->nama_barang }}</h1>
            <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-mono bg-zinc-100 text-zinc-600">{{ $barang->kode_barang }}</span>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.barang.index') }}" class="inline-flex items-center gap-2 border border-zinc-200 text-zinc-600 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-zinc-50 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.barang.edit', $barang) }}" class="inline-flex items-center gap-2 bg-zinc-900 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-zinc-800 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Ubah Data
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Left: Product Info -->
    <div class="md:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm">
            <div class="px-6 py-4 border-b border-zinc-100">
                <h2 class="font-semibold text-zinc-900 text-sm">Informasi Produk</h2>
            </div>
            <div class="p-6 grid grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-zinc-400 uppercase tracking-wider font-medium">Kode Inventaris</p>
                    <p class="text-lg font-bold font-mono text-zinc-900 mt-1">{{ $barang->kode_barang }}</p>
                </div>
                <div>
                    <p class="text-xs text-zinc-400 uppercase tracking-wider font-medium">Nama Barang</p>
                    <p class="text-lg font-bold text-zinc-900 mt-1">{{ $barang->nama_barang }}</p>
                </div>
                <div>
                    <p class="text-xs text-zinc-400 uppercase tracking-wider font-medium">Kategori</p>
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-blue-50 text-blue-600 mt-1">{{ $barang->kategori->nama_kategori ?? '-' }} ({{ $barang->kategori->kode_kategori ?? '' }})</span>
                </div>
                <div>
                    <p class="text-xs text-zinc-400 uppercase tracking-wider font-medium">Supplier</p>
                    <p class="font-semibold text-zinc-900 mt-1">{{ $barang->supplier->nama_pt ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Financial -->
        <div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm">
            <div class="px-6 py-4 border-b border-zinc-100">
                <h2 class="font-semibold text-zinc-900 text-sm">Valuasi & Stok</h2>
            </div>
            <div class="p-6 grid grid-cols-3 gap-4">
                <div class="text-center p-4 bg-zinc-50 rounded-xl">
                    <p class="text-xs text-zinc-400 uppercase tracking-wider font-medium">Stok Gudang</p>
                    <h3 class="text-2xl font-bold text-zinc-900 mt-1">{{ number_format($barang->stok) }}</h3>
                    <p class="text-xs text-zinc-400 mt-0.5">Unit</p>
                </div>
                <div class="text-center p-4 bg-zinc-50 rounded-xl">
                    <p class="text-xs text-zinc-400 uppercase tracking-wider font-medium">Harga Satuan</p>
                    <h3 class="text-2xl font-bold text-emerald-600 mt-1">Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}</h3>
                    <p class="text-xs text-zinc-400 mt-0.5">Per Unit</p>
                </div>
                <div class="text-center p-4 bg-zinc-50 rounded-xl">
                    <p class="text-xs text-zinc-400 uppercase tracking-wider font-medium">Total Valuasi</p>
                    <h3 class="text-2xl font-bold text-blue-600 mt-1">Rp {{ number_format($barang->stok * $barang->harga_satuan, 0, ',', '.') }}</h3>
                    <p class="text-xs text-zinc-400 mt-0.5">Nilai Aset</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Supplier Card -->
    <div>
        <div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm">
            <div class="px-6 py-4 border-b border-zinc-100">
                <h2 class="font-semibold text-zinc-900 text-sm">Detail Pemasok</h2>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="font-bold text-zinc-900">{{ $barang->supplier->nama_pt }}</p>
                </div>
                <div class="flex items-center gap-2 text-sm text-zinc-500">
                    <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ $barang->supplier->email }}
                </div>
                <div class="flex items-center gap-2 text-sm text-zinc-500">
                    <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ $barang->supplier->telepon }}
                </div>
                <div class="flex items-start gap-2 text-sm text-zinc-500">
                    <svg class="w-4 h-4 text-zinc-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $barang->supplier->alamat }}
                </div>
                <a href="{{ route('admin.suppliers.show', $barang->supplier) }}" class="block w-full text-center px-4 py-2.5 rounded-xl border border-zinc-200 text-sm font-medium text-zinc-700 hover:bg-zinc-50 transition mt-4">
                    Lihat Profil Supplier
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
