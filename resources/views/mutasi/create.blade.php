@extends('layouts.app')

@section('title', 'Catat Mutasi Stok')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-zinc-500 mb-2">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-zinc-900 transition">Dashboard</a>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.mutasi.index') }}" class="hover:text-zinc-900 transition">Mutasi Stok</a>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-zinc-900 font-medium">Catat</span>
    </div>
    <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Catat Transaksi Mutasi</h1>
    <p class="text-zinc-500 text-sm mt-1">Input penerimaan dari pemasok atau pengeluaran operasional.</p>
</div>

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm">
        <div class="px-6 py-4 border-b border-zinc-100">
            <h2 class="font-semibold text-zinc-900 text-sm">Formulir Pergerakan Stok</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.mutasi.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Pilih Barang -->
                <div>
                    <label for="barang_id" class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Pilih Barang <span class="text-red-400">*</span></label>
                    <select name="barang_id" id="barang_id" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition appearance-none @error('barang_id') border-red-300 @enderror" required onchange="updateStokInfo(this)">
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangList as $b)
                            <option value="{{ $b->id }}" data-stok="{{ $b->stok }}" {{ old('barang_id', request('barang_id')) == $b->id ? 'selected' : '' }}>
                                {{ $b->nama_barang }} ({{ $b->kode_barang }}) — Stok: {{ $b->stok }}
                            </option>
                        @endforeach
                    </select>
                    <div id="stokInfoBadge" class="mt-2"></div>
                    @error('barang_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Jenis Mutasi -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-2">Jenis Mutasi <span class="text-red-400">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="jenis_mutasi" id="jenis_masuk" value="masuk" class="peer sr-only" {{ old('jenis_mutasi', 'masuk') === 'masuk' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl border-2 border-zinc-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 transition">
                                <div class="flex items-center gap-2 font-semibold text-sm text-emerald-700">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                                    Barang Masuk
                                </div>
                                <p class="text-xs text-zinc-500 mt-1">Menambah stok gudang</p>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="jenis_mutasi" id="jenis_keluar" value="keluar" class="peer sr-only" {{ old('jenis_mutasi') === 'keluar' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl border-2 border-zinc-200 peer-checked:border-red-500 peer-checked:bg-red-50/50 transition">
                                <div class="flex items-center gap-2 font-semibold text-sm text-red-700">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                    Barang Keluar
                                </div>
                                <p class="text-xs text-zinc-500 mt-1">Mengurangi stok gudang</p>
                            </div>
                        </label>
                    </div>
                    @error('jenis_mutasi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Jumlah -->
                <div>
                    <label for="jumlah" class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Jumlah Unit <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <input type="number" name="jumlah" id="jumlah" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 pr-16 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition @error('jumlah') border-red-300 @enderror" value="{{ old('jumlah', 1) }}" min="1" required>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-zinc-400">Unit</span>
                    </div>
                    <p class="text-zinc-400 text-xs mt-1">Min 1 unit. Keluar tidak boleh melebihi sisa stok.</p>
                    @error('jumlah')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Keterangan -->
                <div>
                    <label for="keterangan" class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Keterangan / Catatan</label>
                    <textarea name="keterangan" id="keterangan" rows="3" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition resize-none @error('keterangan') border-red-300 @enderror" placeholder="Contoh: Penerimaan PO-2026-0045 dari Supplier">{{ old('keterangan') }}</textarea>
                    @error('keterangan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-5 border-t border-zinc-100">
                    <a href="{{ route('admin.mutasi.index') }}" class="px-5 py-2.5 rounded-xl border border-zinc-200 text-sm font-medium text-zinc-600 hover:bg-zinc-50 transition">Batal</a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-zinc-900 text-white text-sm font-medium hover:bg-zinc-800 transition shadow-sm">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateStokInfo(selectElement) {
        const selected = selectElement.options[selectElement.selectedIndex];
        const stok = selected.getAttribute('data-stok');
        const badge = document.getElementById('stokInfoBadge');
        if (stok !== null && stok !== undefined && selectElement.value) {
            badge.innerHTML = '<span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium bg-zinc-100 text-zinc-600"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>Sisa Stok: <strong>' + stok + ' unit</strong></span>';
        } else {
            badge.innerHTML = '';
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('barang_id');
        if (select.value) updateStokInfo(select);
    });
</script>
@endpush
@endsection
