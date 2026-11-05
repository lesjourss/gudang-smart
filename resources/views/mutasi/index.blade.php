@extends('layouts.app')

@section('title', 'Mutasi Stok')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Transaksi Mutasi Stok</h1>
        <p class="text-zinc-500 text-sm mt-1">Riwayat penerimaan barang masuk dan pengeluaran produksi/distribusi.</p>
    </div>
    <a href="{{ route('admin.mutasi.create') }}" class="inline-flex items-center gap-2 bg-zinc-900 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-zinc-800 transition shadow-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Catat Transaksi
    </a>
</div>

<!-- Filter -->
<div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm p-4 mb-6">
    <form action="{{ route('admin.mutasi.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
        <div class="flex-1">
            <select name="barang_id" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm text-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition appearance-none">
                <option value="">Semua Barang</option>
                @foreach($barangList as $b)
                    <option value="{{ $b->id }}" {{ request('barang_id') == $b->id ? 'selected' : '' }}>{{ $b->nama_barang }} ({{ $b->kode_barang }})</option>
                @endforeach
            </select>
        </div>
        <div class="md:w-56">
            <select name="jenis_mutasi" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm text-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition appearance-none">
                <option value="">Semua Jenis</option>
                <option value="masuk" {{ request('jenis_mutasi') == 'masuk' ? 'selected' : '' }}>Barang Masuk</option>
                <option value="keluar" {{ request('jenis_mutasi') == 'keluar' ? 'selected' : '' }}>Barang Keluar</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="inline-flex items-center gap-2 bg-zinc-900 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-zinc-800 transition">Filter</button>
            @if(request()->hasAny(['barang_id', 'jenis_mutasi']))
                <a href="{{ route('admin.mutasi.index') }}" class="inline-flex items-center px-3 py-2.5 rounded-xl border border-zinc-200 text-zinc-500 hover:bg-zinc-50 transition text-sm">Reset</a>
            @endif
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between">
        <p class="text-sm text-zinc-500">{{ $mutasi->total() }} transaksi tercatat</p>
        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-zinc-100 text-zinc-600">Hal. {{ $mutasi->currentPage() }}/{{ $mutasi->lastPage() }}</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-zinc-100">
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider w-12">No</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Waktu</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Barang</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Jenis</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Jumlah</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Petugas</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-zinc-400 uppercase tracking-wider">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-50">
                @forelse($mutasi as $index => $m)
                    <tr class="hover:bg-zinc-50/50 transition">
                        <td class="px-6 py-3 text-zinc-400 text-xs">{{ $mutasi->firstItem() + $index }}</td>
                        <td class="px-6 py-3">
                            <div class="font-medium text-zinc-900">{{ $m->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-zinc-400">{{ $m->created_at->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-6 py-3">
                            <div class="font-medium text-zinc-900">{{ $m->barang->nama_barang ?? 'Terhapus' }}</div>
                            <span class="inline-flex rounded-full px-2 py-0.5 text-[10px] font-mono bg-zinc-100 text-zinc-500">{{ $m->barang->kode_barang ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-3">
                            @if($m->jenis_mutasi === 'masuk')
                                <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium bg-emerald-50 text-emerald-600">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                                    Masuk
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium bg-red-50 text-red-600">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                    Keluar
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-right font-semibold {{ $m->jenis_mutasi === 'masuk' ? 'text-emerald-600' : 'text-red-500' }}">
                            {{ $m->jenis_mutasi === 'masuk' ? '+' : '-' }}{{ number_format($m->jumlah) }}
                        </td>
                        <td class="px-6 py-3">
                            <div class="text-sm font-medium text-zinc-900">{{ $m->user->name ?? 'Sistem' }}</div>
                            <span class="inline-flex rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase {{ ($m->user->role ?? '') === 'manager' ? 'bg-red-50 text-red-500' : 'bg-blue-50 text-blue-500' }}">{{ $m->user->role ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-3 text-zinc-400 text-sm max-w-[180px] truncate">{{ $m->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <svg class="w-12 h-12 text-zinc-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            <p class="text-zinc-400 text-sm">Belum ada catatan transaksi mutasi.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($mutasi->hasPages())
        <div class="px-6 py-4 border-t border-zinc-100">
            {{ $mutasi->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection
