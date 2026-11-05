@extends('layouts.app')

@section('title', 'Kategori Barang')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h2 class="h3 fw-bold text-dark mb-1">Klasifikasi Kategori Barang</h2>
        <p class="text-muted mb-0">Kelompok klasifikasi dan segmentasi inventaris manufaktur GudangSmart.</p>
    </div>
</div>

<!-- Search Bar -->
<div class="card border-0 shadow-sm mb-4 bg-white">
    <div class="card-body p-3">
        <form action="{{ route('admin.kategori.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-12 col-md-9">
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Cari kode kategori atau nama kategori..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-12 col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">Cari</button>
                @if(request('search'))
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Kategori Table -->
<div class="card border-0 shadow-sm bg-white">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <div class="fw-semibold text-dark">
            <i class="bi bi-tags text-primary me-2"></i>
            Daftar Kategori Inventaris ({{ $kategori->total() }} Kategori)
        </div>
        <span class="badge bg-secondary-subtle text-secondary">Halaman {{ $kategori->currentPage() }} dari {{ $kategori->lastPage() }}</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-secondary small text-uppercase">
                <tr>
                    <th class="ps-4">No</th>
                    <th>Kode Kategori</th>
                    <th>Nama Klasifikasi Kategori</th>
                    <th class="text-center">Jumlah Barang Terdaftar</th>
                    <th class="text-center pe-4" style="width: 140px;">Katalog</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategori as $index => $kat)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $kategori->firstItem() + $index }}</td>
                        <td>
                            <span class="badge bg-secondary font-monospace px-2 py-1">{{ $kat->kode_kategori }}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $kat->nama_kategori }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary-subtle text-primary border px-3 py-1 fs-6">
                                {{ $kat->barang_count }} Produk
                            </span>
                        </td>
                        <td class="text-center pe-4">
                            <a href="{{ route('admin.barang.index', ['kategori_id' => $kat->id]) }}" class="btn btn-sm btn-outline-primary" title="Filter Barang Kategori Ini">
                                <i class="bi bi-filter me-1"></i> Lihat Barang
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-tags fs-1 d-block mb-2 text-secondary"></i>
                            Tidak ada kategori yang sesuai dengan pencarian.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($kategori->hasPages())
        <div class="card-footer bg-white py-3 border-top">
            {{ $kategori->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection

