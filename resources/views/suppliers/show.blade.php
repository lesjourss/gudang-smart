@extends('layouts.app')

@section('title', 'Detail Supplier: ' . $supplier->nama_pt)

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1 small">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.suppliers.index') }}" class="text-decoration-none">Supplier</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2 class="h3 fw-bold text-dark mb-1">{{ $supplier->nama_pt }}</h2>
            <span class="badge bg-secondary font-monospace">{{ $supplier->kode_supplier }}</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            @if(Auth::user()?->role === 'manager')
                <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i> Ubah Profil
                </a>
            @endif
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Supplier Profile Card -->
    <div class="col-12 col-md-5">
        <div class="card border-0 shadow-sm bg-white h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="card-title fw-bold text-dark mb-0 d-flex align-items-center">
                    <i class="bi bi-building text-primary me-2"></i> Profil Perusahaan
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <div class="text-muted small">Nama PT / Vendor</div>
                    <div class="fw-bold fs-5 text-dark">{{ $supplier->nama_pt }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-muted small">Kode Registrasi Vendor</div>
                    <div class="fw-bold font-monospace text-dark">{{ $supplier->kode_supplier }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-muted small">Email Korespondensi</div>
                    <div class="fw-medium text-dark"><i class="bi bi-envelope text-muted me-1"></i>{{ $supplier->email }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-muted small">Telepon Kantor / PIC</div>
                    <div class="fw-medium text-dark"><i class="bi bi-telephone text-muted me-1"></i>{{ $supplier->telepon }}</div>
                </div>
                <div>
                    <div class="text-muted small">Alamat Lengkap / Gudang</div>
                    <div class="text-dark"><i class="bi bi-geo-alt text-muted me-1"></i>{{ $supplier->alamat }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Card -->
    <div class="col-12 col-md-7">
        <div class="card border-0 shadow-sm bg-white mb-4">
            <div class="card-body p-4">
                <div class="row g-3 text-center">
                    <div class="col-6 p-3 bg-light rounded-3">
                        <div class="text-muted small">Total Varian Barang Disuplai</div>
                        <h2 class="display-6 fw-bold text-primary mb-0 mt-1">{{ $supplier->barang->count() }}</h2>
                        <span class="small text-muted">SKU Aktif</span>
                    </div>
                    <div class="col-6 p-3 bg-light rounded-3">
                        <div class="text-muted small">Total Unit Stok di Gudang</div>
                        <h2 class="display-6 fw-bold text-success mb-0 mt-1">{{ number_format($supplier->barang->sum('stok')) }}</h2>
                        <span class="small text-muted">Unit Fisik</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Barang dari Supplier ini (Relasi hasMany) -->
        <div class="card border-0 shadow-sm bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="card-title fw-bold text-dark mb-0 d-flex align-items-center">
                    <i class="bi bi-boxes text-success me-2"></i> Katalog Barang Pasokan Supplier Ini
                </h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small text-uppercase">
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th class="text-end">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($supplier->barang as $item)
                            <tr>
                                <td><span class="badge bg-secondary font-monospace">{{ $item->kode_barang }}</span></td>
                                <td class="fw-medium text-dark">{{ $item->nama_barang }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $item->kategori->nama_kategori ?? '-' }}</span></td>
                                <td class="text-end fw-bold {{ $item->stok < 20 ? 'text-danger' : 'text-success' }}">{{ $item->stok }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada barang yang didaftarkan untuk supplier ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

