@extends('layouts.app')

@section('title', 'Kategori Barang')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Kategori Barang</h1>
    <p class="text-zinc-500 text-sm mt-1">Klasifikasi dan segmentasi inventaris manufaktur.</p>
</div>

<!-- Search -->
<div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm p-4 mb-6">
    <form action="{{ route('admin.kategori.index') }}" method="GET" class="flex gap-3">
        <input type="text" name="search" class="flex-1 rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition" placeholder="Cari kode atau nama kategori..." value="{{ request('search') }}">
        <button type="submit" class="inline-flex items-center gap-2 bg-zinc-900 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-zinc-800 transition">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.kategori.index') }}" class="inline-flex items-center px-3 py-2.5 rounded-xl border border-zinc-200 text-zinc-500 hover:bg-zinc-50 transition text-sm">Reset</a>
        @endif
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between">
        <p class="text-sm text-zinc-500">{{ $kategori->total() }} kategori terdaftar</p>
        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-zinc-100 text-zinc-600">Hal. {{ $kategori->currentPage() }}/{{ $kategori->lastPage() }}</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-zinc-100">
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider w-12">No</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Kode</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Nama Kategori</th>
                    <th class="text-center px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Jumlah Barang</th>
                    <th class="text-center px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider w-36">Katalog</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-50">
                @forelse($kategori as $index => $kat)
                    <tr class="hover:bg-zinc-50/50 transition">
                        <td class="px-6 py-3 text-zinc-400 text-xs">{{ $kategori->firstItem() + $index }}</td>
                        <td class="px-6 py-3"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-mono bg-zinc-100 text-zinc-600">{{ $kat->kode_kategori }}</span></td>
                        <td class="px-6 py-3 font-medium text-zinc-900">{{ $kat->nama_kategori }}</td>
                        <td class="px-6 py-3 text-center">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold bg-blue-50 text-blue-600">{{ $kat->barang_count }} Produk</span>
                        </td>
                        <td class="px-6 py-3 text-center">
                            <a href="{{ route('admin.barang.index', ['kategori_id' => $kat->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-zinc-200 text-zinc-600 text-xs font-medium hover:bg-zinc-50 transition">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                                Lihat Barang
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <svg class="w-12 h-12 text-zinc-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                            <p class="text-zinc-400 text-sm">Tidak ada kategori ditemukan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($kategori->hasPages())
        <div class="px-6 py-4 border-t border-zinc-100">
            {{ $kategori->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection
