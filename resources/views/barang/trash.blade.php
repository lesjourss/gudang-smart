@extends('layouts.app')

@section('title', 'Kotak Sampah (Trash) - Barang Terhapus')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1 small">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.barang.index') }}" class="text-decoration-none">Katalog Barang</a></li>
                <li class="breadcrumb-item active" aria-current="page">Trash</li>
            </ol>
        </nav>
        <h2 class="h3 fw-bold text-danger mb-1 d-flex align-items-center">
            <i class="bi bi-trash3-fill me-2"></i> Kotak Sampah Barang (Soft Deleted)
        </h2>
        <p class="text-muted mb-0">Daftar barang yang dihapus sementara dari sistem. Anda dapat memulihkan (Restore) atau menghapus permanen.</p>
    </div>
    <div>
        <a href="{{ route('admin.barang.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm bg-white">
    <div class="card-header bg-danger bg-opacity-10 py-3 border-bottom border-danger-subtle d-flex justify-content-between align-items-center">
        <span class="fw-semibold text-danger">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            Terdapat {{ $barangTrashed->total() }} barang di dalam kotak sampah
        </span>
        <span class="badge bg-danger">Khusus Manager</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-secondary small text-uppercase">
                <tr>
                    <th class="ps-4">No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Supplier</th>
                    <th>Waktu Dihapus</th>
                    <th class="text-center pe-4" style="width: 220px;">Aksi Pemulihan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangTrashed as $index => $item)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $barangTrashed->firstItem() + $index }}</td>
                        <td>
                            <span class="badge bg-secondary font-monospace">{{ $item->kode_barang }}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark text-decoration-line-through">{{ $item->nama_barang }}</div>
                            <span class="small text-muted">Stok terakhir: {{ $item->stok }} unit</span>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $item->kategori->nama_kategori ?? '-' }}</span>
                        </td>
                        <td>{{ $item->supplier->nama_pt ?? '-' }}</td>
                        <td>
                            <span class="badge bg-danger-subtle text-danger">
                                <i class="bi bi-clock me-1"></i>{{ $item->deleted_at->format('d M Y H:i') }}
                            </span>
                        </td>
                        <td class="text-center pe-4">
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Tombol Restore -->
                                <form action="{{ route('admin.barang.restore', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Pulihkan barang ini kembali ke katalog aktif?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success d-flex align-items-center shadow-sm">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Pulihkan
                                    </button>
                                </form>

                                <!-- Tombol Force Delete -->
                                <form action="{{ route('admin.barang.force-delete', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('PERINGATAN: Barang ini akan dihapus permanen dan tidak dapat dipulihkan lagi! Lanjutkan?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center">
                                        <i class="bi bi-x-circle me-1"></i> Hapus Permanen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-check-circle fs-1 text-success d-block mb-2"></i>
                            Kotak sampah bersih. Tidak ada data barang yang terhapus sementara.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($barangTrashed->hasPages())
        <div class="card-footer bg-white py-3 border-top">
            {{ $barangTrashed->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection

