@extends('layouts.app')

@section('title', 'Tambah Supplier Baru')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1 small">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.suppliers.index') }}" class="text-decoration-none">Supplier</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Supplier</li>
        </ol>
    </nav>
    <h2 class="h3 fw-bold text-dark mb-1">Tambah Supplier Baru</h2>
    <p class="text-muted mb-0">Registrasi mitra vendor dan pemasok barang manufaktur.</p>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="card-title fw-bold text-dark mb-0 d-flex align-items-center">
                    <i class="bi bi-truck text-primary me-2"></i> Formulir Mitra Supplier
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.suppliers.store') }}" method="POST">
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="kode_supplier" class="form-label fw-semibold text-secondary small">
                                Kode Supplier <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kode_supplier" id="kode_supplier" class="form-control font-monospace @error('kode_supplier') is-invalid @enderror" value="{{ old('kode_supplier', 'SUP' . rand(1000000, 9999999)) }}" maxlength="10" required>
                            <div class="form-text small">Tepat 10 karakter & unik.</div>
                            @error('kode_supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-8">
                            <label for="nama_pt" class="form-label fw-semibold text-secondary small">
                                Nama Perusahaan (PT / CV) <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_pt" id="nama_pt" class="form-control @error('nama_pt') is-invalid @enderror" value="{{ old('nama_pt') }}" placeholder="Contoh: PT Jaya Logam Sejahtera" required>
                            @error('nama_pt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold text-secondary small">
                                Alamat Email Vendor <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="sales@perusahaan.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="telepon" class="form-label fw-semibold text-secondary small">
                                Nomor Telepon / HP <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="telepon" id="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon') }}" placeholder="0812xxxxxxxx" required>
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="form-label fw-semibold text-secondary small">
                            Alamat Kantor / Pabrik <span class="text-danger">*</span>
                        </label>
                        <textarea name="alamat" id="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror" placeholder="Kawasan Industri / Alamat Lengkap" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">
                            <i class="bi bi-save me-1"></i> Simpan Supplier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

