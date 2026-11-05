@extends('layouts.app')

@section('title', 'Dashboard Inventory')

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 mb-6">
    <div>
        <h1 class="text-xl font-bold text-zinc-900 tracking-tight">Dashboard</h1>
        <p class="text-zinc-400 text-[13px] mt-0.5">Ringkasan data inventaris gudang Anda.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.barang.create') }}" class="inline-flex items-center gap-1.5 bg-zinc-900 text-white px-3.5 py-2 rounded-xl text-[13px] font-medium hover:bg-zinc-800 transition shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Barang
        </a>
        @if(Auth::user()?->role === 'manager')
            <a href="{{ route('admin.suppliers.create') }}" class="inline-flex items-center gap-1.5 border border-zinc-200 text-zinc-600 px-3.5 py-2 rounded-xl text-[13px] font-medium hover:bg-zinc-50 transition">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Supplier
            </a>
        @endif
    </div>
</div>

<!-- Metric Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <!-- Total Supplier -->
    <div class="bg-white rounded-2xl border border-zinc-200/60 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                <svg class="w-[18px] h-[18px] text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <a href="{{ route('admin.suppliers.index') }}" class="text-[11px] font-medium text-zinc-400 hover:text-zinc-600 transition">
                Lihat →
            </a>
        </div>
        <p class="text-2xl font-bold text-zinc-900">{{ number_format($totalSupplier) }}</p>
        <p class="text-[12px] text-zinc-400 mt-0.5">Total Supplier</p>
    </div>

    <!-- Total Jenis Barang -->
    <div class="bg-white rounded-2xl border border-zinc-200/60 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                <svg class="w-[18px] h-[18px] text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <a href="{{ route('admin.barang.index') }}" class="text-[11px] font-medium text-zinc-400 hover:text-zinc-600 transition">
                Lihat →
            </a>
        </div>
        <p class="text-2xl font-bold text-zinc-900">{{ number_format($totalJenisBarang) }}</p>
        <p class="text-[12px] text-zinc-400 mt-0.5">Total Jenis Barang</p>
    </div>

    <!-- Total Stok Fisik Gudang -->
    <div class="bg-white rounded-2xl border border-zinc-200/60 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
                <svg class="w-[18px] h-[18px] text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
            </div>
            <span class="text-[11px] text-zinc-400">{{ $totalKategori }} kategori</span>
        </div>
        <p class="text-2xl font-bold text-zinc-900">{{ number_format($totalStokFisik) }}</p>
        <p class="text-[12px] text-zinc-400 mt-0.5">Total Stok Fisik Gudang</p>
    </div>
</div>

<!-- Quick Access + Recent Items (2-column on desktop) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <!-- Quick Access Cards -->
    <div class="space-y-3">
        <!-- User Role Card -->
        <div class="bg-white rounded-2xl border border-zinc-200/60 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl {{ Auth::user()->role === 'manager' ? 'bg-red-50' : 'bg-blue-50' }} flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 {{ Auth::user()->role === 'manager' ? 'text-red-500' : 'text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[13px] font-semibold text-zinc-900 truncate">{{ Auth::user()->name }}</p>
                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase {{ Auth::user()->role === 'manager' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }}">
                        {{ Auth::user()->role }}
                    </span>
                </div>
            </div>
            <p class="text-[12px] text-zinc-400 mt-3 leading-relaxed">
                @if(Auth::user()->role === 'manager')
                    Akses penuh: kelola supplier, barang, & sampah.
                @else
                    Akses terbatas: lihat katalog, tambah barang, catat stok.
                @endif
            </p>
        </div>

        <!-- Quick Nav -->
        <div class="bg-white rounded-2xl border border-zinc-200/60 p-4">
            <p class="text-[11px] uppercase tracking-wider text-zinc-400 font-semibold mb-3">Pintasan</p>
            <div class="space-y-1.5">
                <a href="{{ route('admin.mutasi.create') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] text-zinc-600 hover:bg-zinc-50 transition group">
                    <svg class="w-4 h-4 text-zinc-400 group-hover:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    Catat Mutasi Stok
                </a>
                <a href="{{ route('admin.kategori.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] text-zinc-600 hover:bg-zinc-50 transition group">
                    <svg class="w-4 h-4 text-zinc-400 group-hover:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                    Kelola Kategori
                </a>
                @if(Auth::user()?->role === 'manager')
                <a href="{{ route('admin.barang.trash') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] text-red-500 hover:bg-red-50 transition group">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Data Sampah
                </a>
                @endif
            </div>
        </div>

        <!-- Timestamp -->
        <div class="text-center py-2">
            <span class="text-[11px] text-zinc-400">
                {{ date('d M Y, H:i') }} WIB
            </span>
        </div>
    </div>

    <!-- Recent Items Table -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-zinc-200/60 overflow-hidden">
        <div class="px-5 py-3.5 border-b border-zinc-100 flex items-center justify-between">
            <h3 class="font-semibold text-zinc-900 text-[13px]">Barang Terbaru</h3>
            <a href="{{ route('admin.barang.index') }}" class="text-[11px] font-medium text-zinc-400 hover:text-zinc-600 transition">
                Lihat Semua →
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-[13px]">
                <thead>
                    <tr class="border-b border-zinc-100">
                        <th class="text-left px-5 py-2.5 text-[11px] font-medium text-zinc-400 uppercase tracking-wider">Kode</th>
                        <th class="text-left px-5 py-2.5 text-[11px] font-medium text-zinc-400 uppercase tracking-wider">Nama Barang</th>
                        <th class="text-left px-5 py-2.5 text-[11px] font-medium text-zinc-400 uppercase tracking-wider hidden sm:table-cell">Kategori</th>
                        <th class="text-right px-5 py-2.5 text-[11px] font-medium text-zinc-400 uppercase tracking-wider">Stok</th>
                        <th class="text-right px-5 py-2.5 text-[11px] font-medium text-zinc-400 uppercase tracking-wider hidden md:table-cell">Harga</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-50">
                    @forelse($barangTerbaru as $item)
                        <tr class="hover:bg-zinc-50/50 transition">
                            <td class="px-5 py-2.5">
                                <span class="inline-flex items-center rounded-lg px-2 py-0.5 text-[11px] font-mono bg-zinc-100 text-zinc-500">{{ $item->kode_barang }}</span>
                            </td>
                            <td class="px-5 py-2.5 font-medium text-zinc-900">{{ $item->nama_barang }}</td>
                            <td class="px-5 py-2.5 hidden sm:table-cell">
                                <span class="inline-flex items-center rounded-lg px-2 py-0.5 text-[11px] font-medium bg-blue-50 text-blue-600">{{ $item->kategori->nama_kategori ?? '-' }}</span>
                            </td>
                            <td class="px-5 py-2.5 text-right font-semibold {{ $item->stok < 50 ? 'text-red-500' : 'text-emerald-600' }}">{{ number_format($item->stok) }}</td>
                            <td class="px-5 py-2.5 text-right text-zinc-600 hidden md:table-cell">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-zinc-400 text-[13px]">Belum ada data barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
