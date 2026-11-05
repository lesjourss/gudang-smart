@extends('layouts.app')

@section('title', 'Mutasi Stok')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h2 class="h3 fw-bold text-dark mb-1">Transaksi Mutasi Stok Barang</h2>
        <p class="text-muted mb-0">Catatan riwayat penerimaan barang masuk dan pengeluaran barang produksi/distribusi.</p>
    </div>
    <div>
        <a href="{{ route('admin.mutasi.create') }}" class="btn btn-primary shadow-sm d-flex align-items-center">
            <i class="bi bi-plus-circle me-2"></i> Catat Transaksi Mutasi
        </a>
    </div>
</div>

<!-- Filter Bar -->
<div class="card border-0 shadow-sm mb-4 bg-white">
    <div class="card-body p-3">
        <form action="{{ route('admin.mutasi.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-12 col-md-5">
                <select name="barang_id" class="form-select">
                    <option value="">-- Semua Barang --</option>
                    @foreach($barangList as $b)
                        <option value="{{ $b->id }}" {{ request('barang_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->nama_barang }} ({{ $b->kode_barang }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-4">
                <select name="jenis_mutasi" class="form-select">
                    <option value="">-- Semua Jenis Mutasi --</option>
                    <option value="masuk" {{ request('jenis_mutasi') == 'masuk' ? 'selected' : '' }}>Barang Masuk (Penerimaan)</option>
                    <option value="keluar" {{ request('jenis_mutasi') == 'keluar' ? 'selected' : '' }}>Barang Keluar (Pengeluaran)</option>
                </select>
            </div>
            <div class="col-12 col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">Filter</button>
                @if(request()->hasAny(['barang_id', 'jenis_mutasi']))
                    <a href="{{ route('admin.mutasi.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Mutasi Table -->
<div class="card border-0 shadow-sm bg-white">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <div class="fw-semibold text-dark">
            <i class="bi bi-clock-history text-primary me-2"></i>
            Log Transaksi Mutasi ({{ $mutasi->total() }} Catatan)
        </div>
        <span class="badge bg-secondary-subtle text-secondary">Halaman {{ $mutasi->currentPage() }} dari {{ $mutasi->lastPage() }}</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-secondary small text-uppercase">
                <tr>
                    <th class="ps-4">No</th>
                    <th>Waktu & Tanggal</th>
                    <th>Kode & Nama Barang</th>
                    <th>Jenis Mutasi</th>
                    <th class="text-end">Jumlah</th>
                    <th>Petugas PIC</th>
                    <th class="pe-4">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mutasi as $index => $m)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $mutasi->firstItem() + $index }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $m->created_at->format('d M Y') }}</div>
                            <span class="small text-muted">{{ $m->created_at->format('H:i') }} WIB</span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $m->barang->nama_barang ?? 'Barang Terhapus' }}</div>
                            <span class="badge bg-secondary-subtle text-secondary font-monospace">{{ $m->barang->kode_barang ?? '-' }}</span>
                        </td>
                        <td>
                            @if($m->jenis_mutasi === 'masuk')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                    <i class="bi bi-arrow-down-left-circle me-1"></i> Masuk (Penerimaan)
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                    <i class="bi bi-arrow-up-right-circle me-1"></i> Keluar (Pengeluaran)
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
                            <span class="fw-bold fs-6 {{ $m->jenis_mutasi === 'masuk' ? 'text-success' : 'text-danger' }}">
                                {{ $m->jenis_mutasi === 'masuk' ? '+' : '-' }}{{ number_format($m->jumlah) }} unit
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-circle text-muted me-2"></i>
                                <div>
                                    <div class="fw-semibold small text-dark">{{ $m->user->name ?? 'Sistem' }}</div>
                                    <span class="badge {{ ($m->user->role ?? '') === 'manager' ? 'bg-danger' : 'bg-primary' }} text-uppercase" style="font-size: 0.65rem;">
                                        {{ $m->user->role ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="pe-4 text-muted small">
                            {{ $m->keterangan ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-journal-x fs-1 d-block mb-2 text-secondary"></i>
                            Belum ada catatan transaksi mutasi stok.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($mutasi->hasPages())
        <div class="card-footer bg-white py-3 border-top">
            {{ $mutasi->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection

