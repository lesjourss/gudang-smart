@extends('layouts.app')

@section('title', 'Detail Barang: ' . $barang->nama_barang)

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1 small">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.barang.index') }}" class="text-decoration-none">Katalog Barang</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2 class="h3 fw-bold text-dark mb-1">{{ $barang->nama_barang }}</h2>
            <span class="badge bg-secondary font-monospace">{{ $barang->kode_barang }}</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.barang.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <a href="{{ route('admin.barang.edit', $barang) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Ubah Data
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12 col-md-8">
        <div class="card border-0 shadow-sm bg-white mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="card-title fw-bold text-dark mb-0 d-flex align-items-center">
                    <i class="bi bi-info-circle text-primary me-2"></i> Informasi Spesifikasi Produk
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="text-muted small">Kode Inventaris</div>
                        <div class="fw-bold font-monospace fs-5 text-dark">{{ $barang->kode_barang }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small">Nama Barang</div>
                        <div class="fw-bold fs-5 text-dark">{{ $barang->nama_barang }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small">Kategori Produk</div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-6 mt-1">
                            {{ $barang->kategori->nama_kategori ?? '-' }} ({{ $barang->kategori->kode_kategori ?? '' }})
                        </span>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small">Mitra Supplier</div>
                        <div class="fw-bold text-dark mt-1">
                            <i class="bi bi-building me-1 text-primary"></i> {{ $barang->supplier->nama_pt ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Finansial & Stok -->
        <div class="card border-0 shadow-sm bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="card-title fw-bold text-dark mb-0 d-flex align-items-center">
                    <i class="bi bi-cash-stack text-success me-2"></i> Valuasi & Ketersediaan Stok
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-sm-4 text-center p-3 bg-light rounded-3">
                        <div class="text-muted small">Stok Gudang</div>
                        <h3 class="fw-bold text-dark mt-1 mb-0">{{ number_format($barang->stok) }}</h3>
                        <span class="small text-muted">Unit Fisik</span>
                    </div>
                    <div class="col-sm-4 text-center p-3 bg-light rounded-3">
                        <div class="text-muted small">Harga Satuan</div>
                        <h3 class="fw-bold text-success mt-1 mb-0">Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}</h3>
                        <span class="small text-muted">Per Unit</span>
                    </div>
                    <div class="col-sm-4 text-center p-3 bg-light rounded-3">
                        <div class="text-muted small">Total Valuasi Aset</div>
                        <h3 class="fw-bold text-primary mt-1 mb-0">Rp {{ number_format($barang->stok * $barang->harga_satuan, 0, ',', '.') }}</h3>
                        <span class="small text-muted">Nilai Stok</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Detail Supplier Info -->
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="card-title fw-bold text-dark mb-0">Detail Pemasok</h6>
            </div>
            <div class="card-body p-4">
                <div class="fw-bold text-dark fs-6 mb-2">{{ $barang->supplier->nama_pt }}</div>
                <div class="small text-muted mb-2"><i class="bi bi-envelope me-2"></i>{{ $barang->supplier->email }}</div>
                <div class="small text-muted mb-2"><i class="bi bi-telephone me-2"></i>{{ $barang->supplier->telepon }}</div>
                <div class="small text-muted mb-3"><i class="bi bi-geo-alt me-2"></i>{{ $barang->supplier->alamat }}</div>
                <a href="{{ route('admin.suppliers.show', $barang->supplier) }}" class="btn btn-sm btn-outline-primary w-100">
                    Lihat Profil Supplier
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

