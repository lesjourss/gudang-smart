@extends('layouts.app')

@section('title', 'Ubah Data Supplier')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-zinc-500 mb-2">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-zinc-900 transition">Dashboard</a>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.suppliers.index') }}" class="hover:text-zinc-900 transition">Supplier</a>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-zinc-900 font-medium">Ubah</span>
    </div>
    <div class="flex items-center gap-3">
        <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Ubah Data Supplier</h1>
        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-mono bg-zinc-100 text-zinc-600">{{ $supplier->kode_supplier }}</span>
    </div>
    <p class="text-zinc-500 text-sm mt-1">Perbarui profil dan kontak mitra pemasok.</p>
</div>

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm">
        <div class="px-6 py-4 border-b border-zinc-100">
            <h2 class="font-semibold text-zinc-900 text-sm">Edit: {{ $supplier->nama_pt }}</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.suppliers.update', $supplier) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="kode_supplier" class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Kode Supplier <span class="text-red-400">*</span></label>
                        <input type="text" name="kode_supplier" id="kode_supplier" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition @error('kode_supplier') border-red-300 @enderror" value="{{ old('kode_supplier', $supplier->kode_supplier) }}" maxlength="10" required>
                        @error('kode_supplier')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="nama_pt" class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Nama Perusahaan <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_pt" id="nama_pt" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition @error('nama_pt') border-red-300 @enderror" value="{{ old('nama_pt', $supplier->nama_pt) }}" required>
                        @error('nama_pt')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Email <span class="text-red-400">*</span></label>
                        <input type="email" name="email" id="email" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition @error('email') border-red-300 @enderror" value="{{ old('email', $supplier->email) }}" required>
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="telepon" class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Telepon <span class="text-red-400">*</span></label>
                        <input type="text" name="telepon" id="telepon" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition @error('telepon') border-red-300 @enderror" value="{{ old('telepon', $supplier->telepon) }}" required>
                        @error('telepon')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label for="alamat" class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Alamat <span class="text-red-400">*</span></label>
                    <textarea name="alamat" id="alamat" rows="3" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition resize-none @error('alamat') border-red-300 @enderror" required>{{ old('alamat', $supplier->alamat) }}</textarea>
                    @error('alamat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center justify-end gap-3 pt-5 border-t border-zinc-100">
                    <a href="{{ route('admin.suppliers.index') }}" class="px-5 py-2.5 rounded-xl border border-zinc-200 text-sm font-medium text-zinc-600 hover:bg-zinc-50 transition">Batal</a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-zinc-900 text-white text-sm font-medium hover:bg-zinc-800 transition shadow-sm">Perbarui Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
