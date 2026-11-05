@extends('layouts.app')

@section('title', 'Tambah Barang Baru')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-zinc-500 mb-2">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-zinc-900 transition">Dashboard</a>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.barang.index') }}" class="hover:text-zinc-900 transition">Katalog Barang</a>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-zinc-900 font-medium">Tambah</span>
    </div>
    <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Tambah Barang Baru</h1>
    <p class="text-zinc-500 text-sm mt-1">Lengkapi formulir spesifikasi barang dengan data yang valid.</p>
</div>

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm">
        <div class="px-6 py-4 border-b border-zinc-100">
            <h2 class="font-semibold text-zinc-900 text-sm">Formulir Spesifikasi Barang</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.barang.store') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="kode_barang" class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Kode Barang <span class="text-red-400">*</span></label>
                        <input type="text" name="kode_barang" id="kode_barang" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition @error('kode_barang') border-red-300 @enderror" value="{{ old('kode_barang', 'BRG' . rand(1000000, 9999999)) }}" maxlength="10" required>
                        <p class="text-zinc-400 text-xs mt-1">Maks 10 karakter, unik.</p>
                        @error('kode_barang')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="nama_barang" class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Nama Barang <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_barang" id="nama_barang" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition @error('nama_barang') border-red-300 @enderror" value="{{ old('nama_barang') }}" placeholder="Contoh: Bearing Baja Presisi" required minlength="3">
                        @error('nama_barang')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="kategori_id" class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Kategori <span class="text-red-400">*</span></label>
                        <select name="kategori_id" id="kategori_id" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition appearance-none @error('kategori_id') border-red-300 @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }} ({{ $kat->kode_kategori }})</option>
                            @endforeach
                        </select>
                        @error('kategori_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="supplier_id" class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Supplier <span class="text-red-400">*</span></label>
                        <select name="supplier_id" id="supplier_id" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition appearance-none @error('supplier_id') border-red-300 @enderror" required>
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($supplierList as $sup)
                                <option value="{{ $sup->id }}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>{{ $sup->nama_pt }} ({{ $sup->kode_supplier }})</option>
                            @endforeach
                        </select>
                        @error('supplier_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="stok" class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Jumlah Stok <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <input type="number" name="stok" id="stok" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 pr-16 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition @error('stok') border-red-300 @enderror" value="{{ old('stok', 0) }}" min="0" required>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-zinc-400">Unit</span>
                        </div>
                        @error('stok')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="harga_satuan" class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Harga Satuan <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs text-zinc-400">Rp</span>
                            <input type="number" step="1000" name="harga_satuan" id="harga_satuan" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition @error('harga_satuan') border-red-300 @enderror" value="{{ old('harga_satuan') }}" min="0" placeholder="150000" required>
                        </div>
                        @error('harga_satuan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 pt-5 border-t border-zinc-100">
                    <a href="{{ route('admin.barang.index') }}" class="px-5 py-2.5 rounded-xl border border-zinc-200 text-sm font-medium text-zinc-600 hover:bg-zinc-50 transition">Batal</a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-zinc-900 text-white text-sm font-medium hover:bg-zinc-800 transition shadow-sm">Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
