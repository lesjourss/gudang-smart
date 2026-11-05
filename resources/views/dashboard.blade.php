@extends('layouts.app')

@section('title', 'Dashboard Inventory')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2 class="h3 fw-bold text-dark mb-1">Dashboard Inventory GudangSmart</h2>
            <p class="text-muted mb-0">Pantauan ringkasan stok, katalog barang, dan mitra supplier manufaktur terkini.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.barang.create') }}" class="btn btn-primary shadow-sm d-flex align-items-center">
                <i class="bi bi-plus-circle me-2"></i> Tambah Barang Baru
            </a>
            @if(Auth::user()?->role === 'manager')
                <a href="{{ route('admin.suppliers.create') }}" class="btn btn-outline-secondary shadow-sm d-flex align-items-center">
                    <i class="bi bi-truck me-2"></i> Tambah Supplier
                </a>
            @endif
        </div>
    </div>
</div>

<!-- 3 BUAH CARD RINGKASAN SESUAI SOAL UTS NOMOR 2.3 -->
<div class="row g-4 mb-4">
    <!-- Card 1: Total Supplier -->
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm h-100 bg-white" style="border-left: 5px solid #0d6efd !important;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold small" style="letter-spacing: 0.5px;">Total Supplier</span>
                        <h2 class="display-6 fw-bold text-dark mb-0 mt-2">{{ number_format($totalSupplier) }}</h2>
                        <span class="text-muted small mt-1 d-block"><i class="bi bi-building-check text-primary me-1"></i>Mitra Pemasok Aktif</span>
                    </div>
                    <div class="rounded-4 bg-primary bg-opacity-10 p-3 text-primary">
                        <i class="bi bi-truck fs-1"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top">
                    <a href="{{ route('admin.suppliers.index') }}" class="text-decoration-none small fw-semibold text-primary d-flex align-items-center">
                        Lihat Seluruh Supplier <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Jenis Barang -->
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm h-100 bg-white" style="border-left: 5px solid #198754 !important;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold small" style="letter-spacing: 0.5px;">Total Jenis Barang</span>
                        <h2 class="display-6 fw-bold text-dark mb-0 mt-2">{{ number_format($totalJenisBarang) }}</h2>
                        <span class="text-muted small mt-1 d-block"><i class="bi bi-boxes text-success me-1"></i>SKU Katalog Inventaris</span>
                    </div>
                    <div class="rounded-4 bg-success bg-opacity-10 p-3 text-success">
                        <i class="bi bi-box-seam fs-1"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top">
                    <a href="{{ route('admin.barang.index') }}" class="text-decoration-none small fw-semibold text-success d-flex align-items-center">
                        Buka Katalog Barang <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Total Stok Fisik Gudang -->
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm h-100 bg-white" style="border-left: 5px solid #fd7e14 !important;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold small" style="letter-spacing: 0.5px;">Total Stok Fisik Gudang</span>
                        <h2 class="display-6 fw-bold text-dark mb-0 mt-2">{{ number_format($totalStokFisik) }}</h2>
                        <span class="text-muted small mt-1 d-block"><i class="bi bi-layers text-warning me-1"></i>Akumulasi Seluruh Unit</span>
                    </div>
                    <div class="rounded-4 bg-warning bg-opacity-10 p-3 text-warning">
                        <i class="bi bi-archive fs-1"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-top">
                    <span class="text-muted small fw-medium">
                        Tersebar di {{ $totalKategori }} Kategori Produk
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Informasi Hak Akses & Status User -->
<div class="card border-0 shadow-sm mb-4 bg-white">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle p-3 {{ Auth::user()->role === 'manager' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary' }} me-3">
                        <i class="bi {{ Auth::user()->role === 'manager' ? 'bi-shield-check' : 'bi-person-badge' }} fs-3"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">
                            Akses Pengguna Aktif: {{ Auth::user()->name }} 
                            <span class="badge {{ Auth::user()->role === 'manager' ? 'bg-danger' : 'bg-primary' }} text-uppercase ms-2">
                                {{ Auth::user()->role }}
                            </span>
                        </h5>
                        <p class="text-muted mb-0 small">
                            @if(Auth::user()->role === 'manager')
                                <strong>Tingkat Akses Manager:</strong> Anda memiliki wewenang penuh untuk mengelola Master Data Supplier, mengedit/menghapus barang, serta mengakses Data Sampah (Restore & Force Delete).
                            @else
                                <strong>Tingkat Akses Staff Gudang:</strong> Anda memiliki hak akses untuk melihat katalog barang, menambahkan barang baru, serta mencatat stok. Fitur penghapusan barang dan modifikasi supplier dinonaktifkan sesuai RBAC.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <span class="badge bg-light text-secondary border px-3 py-2">
                    <i class="bi bi-clock me-1"></i> Waktu Sistem: {{ date('d M Y, H:i') }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Sampel Barang Terbaru (Eager Loading Demo) -->
<div class="card border-0 shadow-sm bg-white">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="card-title fw-bold text-dark mb-0 d-flex align-items-center">
            <i class="bi bi-clock-history text-primary me-2"></i>
            Barang Baru Ditambahkan (Eager Loaded)
        </h5>
        <a href="{{ route('admin.barang.index') }}" class="btn btn-sm btn-outline-primary">
            Lihat Semua <i class="bi bi-chevron-right ms-1"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Supplier</th>
                    <th class="text-end">Stok</th>
                    <th class="text-end pe-4">Harga Satuan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangTerbaru as $item)
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-secondary-subtle text-secondary font-monospace">{{ $item->kode_barang }}</span>
                        </td>
                        <td class="fw-semibold text-dark">{{ $item->nama_barang }}</td>
                        <td>
                            <span class="badge bg-info-subtle text-info-emphasis">{{ $item->kategori->nama_kategori ?? '-' }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-building text-muted me-2 small"></i>
                                <span>{{ $item->supplier->nama_pt ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="text-end">
                            <span class="fw-bold {{ $item->stok < 50 ? 'text-danger' : 'text-success' }}">
                                {{ number_format($item->stok) }} unit
                            </span>
                        </td>
                        <td class="text-end pe-4 fw-bold text-dark">
                            Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data barang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

