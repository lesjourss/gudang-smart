@extends('layouts.app')

@section('title', 'Kotak Sampah (Trash) - Barang Terhapus')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 text-sm text-zinc-500 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-zinc-900 transition">Dashboard</a>
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.barang.index') }}" class="hover:text-zinc-900 transition">Katalog Barang</a>
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-zinc-900 font-medium">Trash</span>
        </div>
        <h1 class="text-2xl font-bold text-red-600 tracking-tight flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            Kotak Sampah
        </h1>
        <p class="text-zinc-500 text-sm mt-1">Barang yang dihapus sementara. Pulihkan atau hapus permanen.</p>
    </div>
    <a href="{{ route('admin.barang.index') }}" class="inline-flex items-center gap-2 border border-zinc-200 text-zinc-600 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-zinc-50 transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Katalog
    </a>
</div>

<div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-zinc-100 bg-red-50/50 flex items-center justify-between">
        <span class="text-sm font-medium text-red-600 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            {{ $barangTrashed->total() }} barang di kotak sampah
        </span>
        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-semibold bg-red-100 text-red-600 uppercase">Khusus Manager</span>
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
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Dihapus</th>
                    <th class="text-center px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider w-52">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-50">
                @forelse($barangTrashed as $index => $item)
                    <tr class="hover:bg-zinc-50/50 transition">
                        <td class="px-6 py-3 text-zinc-400 text-xs">{{ $barangTrashed->firstItem() + $index }}</td>
                        <td class="px-6 py-3"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-mono bg-zinc-100 text-zinc-500">{{ $item->kode_barang }}</span></td>
                        <td class="px-6 py-3">
                            <div class="font-medium text-zinc-400 line-through">{{ $item->nama_barang }}</div>
                            <div class="text-xs text-zinc-400 mt-0.5">Stok: {{ $item->stok }} unit</div>
                        </td>
                        <td class="px-6 py-3"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium bg-zinc-100 text-zinc-500">{{ $item->kategori->nama_kategori ?? '-' }}</span></td>
                        <td class="px-6 py-3 text-zinc-500">{{ $item->supplier->nama_pt ?? '-' }}</td>
                        <td class="px-6 py-3"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium bg-red-50 text-red-500">{{ $item->deleted_at->format('d M Y H:i') }}</span></td>
                        <td class="px-6 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('admin.barang.restore', $item->id) }}" method="POST" onsubmit="return confirm('Pulihkan barang ini?');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-600 text-xs font-medium hover:bg-emerald-100 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        Pulihkan
                                    </button>
                                </form>
                                <form action="{{ route('admin.barang.force-delete', $item->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Barang dihapus permanen! Lanjutkan?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-red-200 text-red-500 text-xs font-medium hover:bg-red-50 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Hapus Permanen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <svg class="w-12 h-12 text-emerald-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-zinc-400 text-sm">Kotak sampah bersih. Tidak ada data terhapus.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($barangTrashed->hasPages())
        <div class="px-6 py-4 border-t border-zinc-100">
            {{ $barangTrashed->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection
