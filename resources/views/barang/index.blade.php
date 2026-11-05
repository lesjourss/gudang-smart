@extends('layouts.app')

@section('title', 'Katalog Barang')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Katalog Barang</h1>
        <p class="text-zinc-500 text-sm mt-1">Kelola master katalog barang, pantau stok, dan klasifikasi manufaktur.</p>
    </div>
    <div class="flex items-center gap-2">
        @if(Auth::user()?->role === 'manager')
            <a href="{{ route('admin.barang.trash') }}" class="inline-flex items-center gap-2 border border-red-200 text-red-600 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-red-50 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Trash
            </a>
        @endif
        <a href="{{ route('admin.barang.create') }}" class="inline-flex items-center gap-2 bg-zinc-900 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-zinc-800 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Barang
        </a>
    </div>
</div>

<!-- Search & Filter -->
<div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm p-4 mb-6">
    <form action="{{ route('admin.barang.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
        <div class="flex-1">
            <input type="text" name="search" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition" placeholder="Cari nama atau kode barang..." value="{{ request('search') }}">
        </div>
        <div class="md:w-64">
            <select name="kategori_id" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm text-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition appearance-none">
                <option value="">Semua Kategori</option>
                @foreach($kategoriList as $kat)
                    <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="inline-flex items-center gap-2 bg-zinc-900 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-zinc-800 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Filter
            </button>
            @if(request()->hasAny(['search', 'kategori_id']))
                <a href="{{ route('admin.barang.index') }}" class="inline-flex items-center px-3 py-2.5 rounded-xl border border-zinc-200 text-zinc-500 hover:bg-zinc-50 transition text-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Data Table -->
<div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between">
        <p class="text-sm text-zinc-500">Menampilkan {{ $barang->firstItem() ?? 0 }}–{{ $barang->lastItem() ?? 0 }} dari {{ $barang->total() }} barang</p>
        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-zinc-100 text-zinc-600">Hal. {{ $barang->currentPage() }}/{{ $barang->lastPage() }}</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-zinc-100">
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider w-12">No</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Kode</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Nama Barang</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Kategori</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Supplier</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Stok</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Harga</th>
                    <th class="text-center px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider w-36">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-50">
                @forelse($barang as $index => $item)
                    <tr class="hover:bg-zinc-50/50 transition">
                        <td class="px-6 py-3 text-zinc-400 text-xs">{{ $barang->firstItem() + $index }}</td>
                        <td class="px-6 py-3"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-mono bg-zinc-100 text-zinc-600">{{ $item->kode_barang }}</span></td>
                        <td class="px-6 py-3">
                            <div class="font-medium text-zinc-900">{{ $item->nama_barang }}</div>
                            <div class="text-xs text-zinc-400 mt-0.5">{{ $item->updated_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-3"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium bg-blue-50 text-blue-600">{{ $item->kategori->nama_kategori ?? '-' }}</span></td>
                        <td class="px-6 py-3 text-zinc-600">{{ $item->supplier->nama_pt ?? '-' }}</td>
                        <td class="px-6 py-3 text-right">
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $item->stok < 20 ? 'bg-red-50 text-red-600' : ($item->stok < 50 ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600') }}">{{ number_format($item->stok) }}</span>
                        </td>
                        <td class="px-6 py-3 text-right font-semibold text-zinc-900">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td class="px-6 py-3 text-center">
                            <div class="inline-flex items-center gap-1">
                                <a href="{{ route('admin.barang.show', $item) }}" class="p-2 rounded-lg text-zinc-400 hover:text-zinc-700 hover:bg-zinc-100 transition" title="Detail">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('admin.barang.edit', $item) }}" class="p-2 rounded-lg text-zinc-400 hover:text-blue-600 hover:bg-blue-50 transition" title="Ubah">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                @if(Auth::user()?->role === 'manager')
                                    <form action="{{ route('admin.barang.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Pindahkan barang {{ $item->nama_barang }} ke trash?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-zinc-400 hover:text-red-600 hover:bg-red-50 transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <svg class="w-12 h-12 text-zinc-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <p class="text-zinc-400 text-sm">Tidak ada data barang ditemukan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-zinc-100">
        {{ $barang->links('pagination::tailwind') }}
    </div>
</div>
@endsection
