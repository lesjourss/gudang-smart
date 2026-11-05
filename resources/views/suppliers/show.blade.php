@extends('layouts.app')

@section('title', 'Detail Supplier: ' . $supplier->nama_pt)

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-zinc-500 mb-2">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-zinc-900 transition">Dashboard</a>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.suppliers.index') }}" class="hover:text-zinc-900 transition">Supplier</a>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-zinc-900 font-medium">Detail</span>
    </div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">{{ $supplier->nama_pt }}</h1>
            <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-mono bg-zinc-100 text-zinc-600">{{ $supplier->kode_supplier }}</span>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.suppliers.index') }}" class="inline-flex items-center gap-2 border border-zinc-200 text-zinc-600 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-zinc-50 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            @if(Auth::user()?->role === 'manager')
                <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="inline-flex items-center gap-2 bg-zinc-900 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-zinc-800 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Ubah Profil
                </a>
            @endif
        </div>
    </div>
</div>

<div class="flex flex-col md:flex-row gap-6">
    <!-- Profile Card -->
    <div class="md:w-5/12">
        <div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm">
            <div class="px-6 py-4 border-b border-zinc-100">
                <h2 class="font-semibold text-zinc-900 text-sm">Profil Perusahaan</h2>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-xs text-zinc-400 uppercase tracking-wider font-medium">Nama Perusahaan</p>
                    <p class="text-lg font-bold text-zinc-900 mt-1">{{ $supplier->nama_pt }}</p>
                </div>
                <div>
                    <p class="text-xs text-zinc-400 uppercase tracking-wider font-medium">Kode Vendor</p>
                    <p class="font-bold font-mono text-zinc-900 mt-1">{{ $supplier->kode_supplier }}</p>
                </div>
                <div class="flex items-center gap-2 text-sm text-zinc-600">
                    <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ $supplier->email }}
                </div>
                <div class="flex items-center gap-2 text-sm text-zinc-600">
                    <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ $supplier->telepon }}
                </div>
                <div class="flex items-start gap-2 text-sm text-zinc-600">
                    <svg class="w-4 h-4 text-zinc-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $supplier->alamat }}
                </div>
            </div>
        </div>
    </div>

    <!-- Stats + Items -->
    <div class="md:w-7/12 space-y-6">
        <div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm p-6">
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center p-4 bg-zinc-50 rounded-xl">
                    <p class="text-xs text-zinc-400 uppercase tracking-wider font-medium">Varian Barang</p>
                    <h2 class="text-3xl font-bold text-blue-600 mt-1">{{ $supplier->barang->count() }}</h2>
                    <p class="text-xs text-zinc-400">SKU Aktif</p>
                </div>
                <div class="text-center p-4 bg-zinc-50 rounded-xl">
                    <p class="text-xs text-zinc-400 uppercase tracking-wider font-medium">Total Stok</p>
                    <h2 class="text-3xl font-bold text-emerald-600 mt-1">{{ number_format($supplier->barang->sum('stok')) }}</h2>
                    <p class="text-xs text-zinc-400">Unit Fisik</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-100">
                <h3 class="font-semibold text-zinc-900 text-sm">Barang Pasokan Supplier</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100">
                            <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Kode</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Nama</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Kategori</th>
                            <th class="text-right px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Stok</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50">
                        @forelse($supplier->barang as $item)
                            <tr class="hover:bg-zinc-50/50 transition">
                                <td class="px-6 py-3"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-mono bg-zinc-100 text-zinc-600">{{ $item->kode_barang }}</span></td>
                                <td class="px-6 py-3 font-medium text-zinc-900">{{ $item->nama_barang }}</td>
                                <td class="px-6 py-3"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium bg-zinc-100 text-zinc-600">{{ $item->kategori->nama_kategori ?? '-' }}</span></td>
                                <td class="px-6 py-3 text-right font-semibold {{ $item->stok < 20 ? 'text-red-500' : 'text-emerald-600' }}">{{ $item->stok }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-8 text-center text-zinc-400">Belum ada barang dari supplier ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
