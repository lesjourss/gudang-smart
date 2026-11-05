@extends('layouts.app')

@section('title', 'Data Supplier')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h2 class="h3 fw-bold text-dark mb-1">Manajemen Mitra Supplier</h2>
        <p class="text-muted mb-0">Daftar mitra pemasok bahan baku dan komponen manufaktur GudangSmart.</p>
    </div>
    @if(Auth::user()?->role === 'manager')
        <div>
            <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary shadow-sm d-flex align-items-center">
                <i class="bi bi-plus-lg me-2"></i> Tambah Supplier Baru
            </a>
        </div>
    @endif
</div>

<!-- Search Bar -->
<div class="card border-0 shadow-sm mb-4 bg-white">
    <div class="card-body p-3">
        <form action="{{ route('admin.suppliers.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-12 col-md-9">
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Cari nama perusahaan, kode supplier, atau email..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-12 col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">Cari</button>
                @if(request('search'))
                    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Supplier Data Table -->
<div class="card border-0 shadow-sm bg-white">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <div class="fw-semibold text-dark">
            <i class="bi bi-truck text-primary me-2"></i>
            Daftar Mitra Supplier ({{ $suppliers->total() }} Perusahaan)
        </div>
        <span class="badge bg-secondary-subtle text-secondary">Halaman {{ $suppliers->currentPage() }} dari {{ $suppliers->lastPage() }}</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-secondary small text-uppercase">
                <tr>
                    <th class="ps-4">No</th>
                    <th>Kode Supplier</th>
                    <th>Nama Perusahaan (PT)</th>
                    <th>Kontak & Email</th>
                    <th>Alamat</th>
                    <th class="text-center">Barang Dipasok</th>
                    <th class="text-center pe-4" style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $index => $sup)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $suppliers->firstItem() + $index }}</td>
                        <td>
                            <span class="badge bg-secondary font-monospace">{{ $sup->kode_supplier }}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $sup->nama_pt }}</div>
                            <span class="text-muted small">Terdaftar: {{ $sup->created_at->format('d M Y') }}</span>
                        </td>
                        <td>
                            <div><i class="bi bi-envelope text-muted me-1 small"></i>{{ $sup->email }}</div>
                            <div class="small text-muted"><i class="bi bi-telephone text-muted me-1 small"></i>{{ $sup->telepon }}</div>
                        </td>
                        <td>
                            <span class="text-truncate d-inline-block" style="max-width: 250px;" title="{{ $sup->alamat }}">
                                {{ $sup->alamat }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary-subtle text-primary border px-2 py-1">
                                {{ $sup->barang_count }} SKU
                            </span>
                        </td>
                        <td class="text-center pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.suppliers.show', $sup) }}" class="btn btn-outline-secondary" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if(Auth::user()?->role === 'manager')
                                    <a href="{{ route('admin.suppliers.edit', $sup) }}" class="btn btn-outline-primary" title="Ubah">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.suppliers.destroy', $sup) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus supplier {{ $sup->nama_pt }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus (Soft Delete)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-truck fs-1 d-block mb-2 text-secondary"></i>
                            Tidak ada supplier yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($suppliers->hasPages())
        <div class="card-footer bg-white py-3 border-top">
            {{ $suppliers->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection

