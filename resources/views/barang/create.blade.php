@extends('layouts.app')

@section('title', 'Tambah Barang Baru')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1 small">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.barang.index') }}" class="text-decoration-none">Katalog Barang</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Barang</li>
        </ol>
    </nav>
    <h2 class="h3 fw-bold text-dark mb-1">Tambah Barang ke Katalog</h2>
    <p class="text-muted mb-0">Lengkapi formulir di bawah ini dengan validasi data yang ketat.</p>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="card-title fw-bold text-dark mb-0 d-flex align-items-center">
                    <i class="bi bi-plus-square text-primary me-2"></i> Formulir Spesifikasi Barang
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.barang.store') }}" method="POST">
                    @csrf

                    <!-- Kode Barang & Nama Barang -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="kode_barang" class="form-label fw-semibold text-secondary small">
                                Kode Barang <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kode_barang" id="kode_barang" class="form-control font-monospace @error('kode_barang') is-invalid @enderror" value="{{ old('kode_barang', 'BRG' . rand(1000000, 9999999)) }}" maxlength="10" placeholder="Maks 10 char" required>
                            <div class="form-text small">Wajib unik, maksimal 10 karakter.</div>
                            @error('kode_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-8">
                            <label for="nama_barang" class="form-label fw-semibold text-secondary small">
                                Nama Barang <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_barang" id="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" value="{{ old('nama_barang') }}" placeholder="Contoh: Bearing Baja Mesin Presisi" required minlength="3">
                            <div class="form-text small">Minimal 3 karakter.</div>
                            @error('nama_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kategori & Supplier -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="kategori_id" class="form-label fw-semibold text-secondary small">
                                Kategori Barang <span class="text-danger">*</span>
                            </label>
                            <select name="kategori_id" id="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoriList as $kat)
                                    <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }} ({{ $kat->kode_kategori }})
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="supplier_id" class="form-label fw-semibold text-secondary small">
                                Supplier Pemasok <span class="text-danger">*</span>
                            </label>
                            <select name="supplier_id" id="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($supplierList as $sup)
                                    <option value="{{ $sup->id }}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>
                                        {{ $sup->nama_pt }} ({{ $sup->kode_supplier }})
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Stok & Harga Satuan -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="stok" class="form-label fw-semibold text-secondary small">
                                Jumlah Stok Awal <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', 0) }}" min="0" required>
                                <span class="input-group-text bg-light text-muted">Unit</span>
                            </div>
                            <div class="form-text small">Wajib numerik dan nilai tidak boleh negatif (min: 0).</div>
                            @error('stok')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="harga_satuan" class="form-label fw-semibold text-secondary small">
                                Harga Satuan (Rp) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted">Rp</span>
                                <input type="number" step="1000" name="harga_satuan" id="harga_satuan" class="form-control @error('harga_satuan') is-invalid @enderror" value="{{ old('harga_satuan') }}" min="0" placeholder="Contoh: 150000" required>
                            </div>
                            <div class="form-text small">Wajib numerik.</div>
                            @error('harga_satuan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('admin.barang.index') }}" class="btn btn-outline-secondary px-4">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">
                            <i class="bi bi-save me-1"></i> Simpan Barang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

