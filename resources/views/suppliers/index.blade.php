@extends('layouts.app')

@section('title', 'Data Supplier')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Manajemen Supplier</h1>
        <p class="text-zinc-500 text-sm mt-1">Daftar mitra pemasok bahan baku dan komponen manufaktur.</p>
    </div>
    @if(Auth::user()?->role === 'manager')
        <a href="{{ route('admin.suppliers.create') }}" class="inline-flex items-center gap-2 bg-zinc-900 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-zinc-800 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Supplier
        </a>
    @endif
</div>

<!-- Search -->
<div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm p-4 mb-6">
    <form action="{{ route('admin.suppliers.index') }}" method="GET" class="flex gap-3">
        <input type="text" name="search" class="flex-1 rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition" placeholder="Cari nama perusahaan, kode, atau email..." value="{{ request('search') }}">
        <button type="submit" class="inline-flex items-center gap-2 bg-zinc-900 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-zinc-800 transition">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.suppliers.index') }}" class="inline-flex items-center px-3 py-2.5 rounded-xl border border-zinc-200 text-zinc-500 hover:bg-zinc-50 transition text-sm">Reset</a>
        @endif
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between">
        <p class="text-sm text-zinc-500">{{ $suppliers->total() }} supplier terdaftar</p>
        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-zinc-100 text-zinc-600">Hal. {{ $suppliers->currentPage() }}/{{ $suppliers->lastPage() }}</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-zinc-100">
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider w-12">No</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Kode</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Nama Perusahaan</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Kontak</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Alamat</th>
                    <th class="text-center px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Barang</th>
                    <th class="text-center px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider w-36">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-50">
                @forelse($suppliers as $index => $sup)
                    <tr class="hover:bg-zinc-50/50 transition">
                        <td class="px-6 py-3 text-zinc-400 text-xs">{{ $suppliers->firstItem() + $index }}</td>
                        <td class="px-6 py-3"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-mono bg-zinc-100 text-zinc-600">{{ $sup->kode_supplier }}</span></td>
                        <td class="px-6 py-3">
                            <div class="font-medium text-zinc-900">{{ $sup->nama_pt }}</div>
                            <div class="text-xs text-zinc-400 mt-0.5">Sejak {{ $sup->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-3">
                            <div class="text-zinc-600">{{ $sup->email }}</div>
                            <div class="text-xs text-zinc-400">{{ $sup->telepon }}</div>
                        </td>
                        <td class="px-6 py-3 text-zinc-500 max-w-[200px] truncate" title="{{ $sup->alamat }}">{{ $sup->alamat }}</td>
                        <td class="px-6 py-3 text-center">
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium bg-blue-50 text-blue-600">{{ $sup->barang_count }} SKU</span>
                        </td>
                        <td class="px-6 py-3 text-center">
                            <div class="inline-flex items-center gap-1">
                                <a href="{{ route('admin.suppliers.show', $sup) }}" class="p-2 rounded-lg text-zinc-400 hover:text-zinc-700 hover:bg-zinc-100 transition" title="Detail">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                @if(Auth::user()?->role === 'manager')
                                    <a href="{{ route('admin.suppliers.edit', $sup) }}" class="p-2 rounded-lg text-zinc-400 hover:text-blue-600 hover:bg-blue-50 transition" title="Ubah">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.suppliers.destroy', $sup) }}" method="POST" class="inline" onsubmit="return confirm('Hapus supplier {{ $sup->nama_pt }}?');">
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
                        <td colspan="7" class="px-6 py-16 text-center">
                            <svg class="w-12 h-12 text-zinc-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <p class="text-zinc-400 text-sm">Tidak ada supplier ditemukan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($suppliers->hasPages())
        <div class="px-6 py-4 border-t border-zinc-100">
            {{ $suppliers->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection
