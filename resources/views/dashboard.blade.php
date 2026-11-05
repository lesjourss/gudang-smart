@extends('layouts.app')

@section('title', 'Dashboard Inventory')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Dashboard Inventory</h1>
            <p class="text-zinc-500 text-sm mt-1">Pantauan ringkasan stok, katalog barang, dan mitra supplier terkini.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.barang.create') }}" class="inline-flex items-center gap-2 bg-zinc-900 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-zinc-800 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Tambah Barang
            </a>
            @if(Auth::user()?->role === 'manager')
                <a href="{{ route('admin.suppliers.create') }}" class="inline-flex items-center gap-2 border border-zinc-200 text-zinc-700 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-zinc-50 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Tambah Supplier
                </a>
            @endif
        </div>
    </div>
</div>

<!-- 3 Metric Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <!-- Card 1: Total Supplier -->
    <div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Total Supplier</p>
                <h2 class="text-3xl font-bold text-zinc-900 mt-2">{{ number_format($totalSupplier) }}</h2>
                <p class="text-zinc-500 text-sm mt-1">Mitra Pemasok Aktif</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-zinc-100">
            <a href="{{ route('admin.suppliers.index') }}" class="text-sm font-medium text-zinc-900 hover:underline inline-flex items-center gap-1">
                Lihat Supplier
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    <!-- Card 2: Total Jenis Barang -->
    <div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Total Jenis Barang</p>
                <h2 class="text-3xl font-bold text-zinc-900 mt-2">{{ number_format($totalJenisBarang) }}</h2>
                <p class="text-zinc-500 text-sm mt-1">SKU Katalog Inventaris</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-zinc-100">
            <a href="{{ route('admin.barang.index') }}" class="text-sm font-medium text-zinc-900 hover:underline inline-flex items-center gap-1">
                Buka Katalog
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    <!-- Card 3: Total Stok Fisik Gudang -->
    <div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Total Stok Fisik Gudang</p>
                <h2 class="text-3xl font-bold text-zinc-900 mt-2">{{ number_format($totalStokFisik) }}</h2>
                <p class="text-zinc-500 text-sm mt-1">Akumulasi Seluruh Unit</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-zinc-100">
            <span class="text-sm text-zinc-500">Tersebar di {{ $totalKategori }} Kategori</span>
        </div>
    </div>
</div>

<!-- User Access Info -->
<div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm p-6 mb-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl {{ Auth::user()->role === 'manager' ? 'bg-red-50 text-red-500' : 'bg-blue-50 text-blue-500' }} flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div>
                <h3 class="font-semibold text-zinc-900">
                    {{ Auth::user()->name }}
                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase ml-2 {{ Auth::user()->role === 'manager' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }}">
                        {{ Auth::user()->role }}
                    </span>
                </h3>
                <p class="text-sm text-zinc-500 mt-0.5">
                    @if(Auth::user()->role === 'manager')
                        Wewenang penuh: kelola Supplier, edit/hapus barang, akses Trash (Restore & Force Delete).
                    @else
                        Akses terbatas: lihat katalog, tambah barang, catat stok. Penghapusan & modifikasi supplier dinonaktifkan.
                    @endif
                </p>
            </div>
        </div>
        <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 bg-zinc-50 border border-zinc-200/60 text-xs text-zinc-500 flex-shrink-0">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ date('d M Y, H:i') }}
        </span>
    </div>
</div>

<!-- Recent Items Table -->
<div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between">
        <h3 class="font-semibold text-zinc-900 text-sm">Barang Baru Ditambahkan</h3>
        <a href="{{ route('admin.barang.index') }}" class="text-xs font-medium text-zinc-500 hover:text-zinc-900 transition inline-flex items-center gap-1">
            Lihat Semua
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-zinc-100">
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Kode</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Nama Barang</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Kategori</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Supplier</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Stok</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Harga Satuan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-50">
                @forelse($barangTerbaru as $item)
                    <tr class="hover:bg-zinc-50/50 transition">
                        <td class="px-6 py-3"><span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-mono bg-zinc-100 text-zinc-600">{{ $item->kode_barang }}</span></td>
                        <td class="px-6 py-3 font-medium text-zinc-900">{{ $item->nama_barang }}</td>
                        <td class="px-6 py-3"><span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-blue-50 text-blue-600">{{ $item->kategori->nama_kategori ?? '-' }}</span></td>
                        <td class="px-6 py-3 text-zinc-600">{{ $item->supplier->nama_pt ?? '-' }}</td>
                        <td class="px-6 py-3 text-right font-semibold {{ $item->stok < 50 ? 'text-red-500' : 'text-emerald-600' }}">{{ number_format($item->stok) }}</td>
                        <td class="px-6 py-3 text-right font-semibold text-zinc-900">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-zinc-400">Belum ada data barang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
