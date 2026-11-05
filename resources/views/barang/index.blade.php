@extends('layouts.app')

@section('title', 'Katalog Barang')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h2 class="h3 fw-bold text-dark mb-1">Katalog Barang & Inventaris</h2>
        <p class="text-muted mb-0">Kelola master katalog barang, pantau stok, dan klasifikasi manufaktur.</p>
    </div>
    <div class="d-flex gap-2">
        @if(Auth::user()?->role === 'manager')
            <a href="{{ route('admin.barang.trash') }}" class="btn btn-outline-danger shadow-sm d-flex align-items-center">
                <i class="bi bi-trash3 me-2"></i> Kotak Sampah (Trash)
            </a>
        @endif
        <a href="{{ route('admin.barang.create') }}" class="btn btn-primary shadow-sm d-flex align-items-center">
            <i class="bi bi-plus-lg me-2"></i> Tambah Barang
        </a>
    </div>
</div>

<!-- SEARCH & FILTER FORM (Instruksi Soal 4.3) -->
<div class="card border-0 shadow-sm mb-4 bg-white">
    <div class="card-body p-3">
        <form action="{{ route('admin.barang.index') }}" method="GET" class="row g-2 align-items-center">
            <!-- Search by Name or Code -->
            <div class="col-12 col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Cari nama barang atau kode barang..." value="{{ request('search') }}">
                </div>
            </div>

            <!-- Filter by Kategori -->
            <div class="col-12 col-md-4">
                <select name="kategori_id" class="form-select">
                    <option value="">-- Semua Kategori Barang --</option>
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }} ({{ $kat->kode_kategori }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Actions: Submit & Reset -->
            <div class="col-12 col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="bi bi-funnel me-1"></i> Terapkan Filter
                </button>
                @if(request()->hasAny(['search', 'kategori_id']))
                    <a href="{{ route('admin.barang.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- DATA TABLE (Eager Loading & Pagination Demo) -->
<div class="card border-0 shadow-sm bg-white">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <div class="fw-semibold text-dark">
            <i class="bi bi-table text-primary me-2"></i>
            Menampilkan {{ $barang->firstItem() ?? 0 }} - {{ $barang->lastItem() ?? 0 }} dari total {{ $barang->total() }} barang
        </div>
        <span class="badge bg-secondary-subtle text-secondary">Halaman {{ $barang->currentPage() }} dari {{ $barang->lastPage() }}</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-secondary small text-uppercase">
                <tr>
                    <th class="ps-4">No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Supplier Mitra</th>
                    <th class="text-end">Stok</th>
                    <th class="text-end">Harga Satuan</th>
                    <th class="text-center pe-4" style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barang as $index => $item)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $barang->firstItem() + $index }}</td>
                        <td>
                            <span class="badge bg-dark bg-opacity-75 font-monospace px-2 py-1">{{ $item->kode_barang }}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $item->nama_barang }}</div>
                            <span class="text-muted small">Update: {{ $item->updated_at->diffForHumans() }}</span>
                        </td>
                        <td>
                            <!-- Data Kategori diambil via Eager Loading ($item->kategori) -->
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                <i class="bi bi-tag me-1"></i>{{ $item->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                            </span>
                        </td>
                        <td>
                            <!-- Data Supplier diambil via Eager Loading ($item->supplier) -->
                            <div class="d-flex align-items-center">
                                <i class="bi bi-building text-muted me-2"></i>
                                <span class="fw-medium text-dark">{{ $item->supplier->nama_pt ?? 'Tanpa Supplier' }}</span>
                            </div>
                        </td>
                        <td class="text-end">
                            <span class="badge {{ $item->stok < 20 ? 'bg-danger' : ($item->stok < 50 ? 'bg-warning text-dark' : 'bg-success') }} px-2 py-1 fs-6">
                                {{ number_format($item->stok) }}
                            </span>
                        </td>
                        <td class="text-end fw-bold text-dark">
                            Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                        </td>
                        <td class="text-center pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.barang.show', $item) }}" class="btn btn-outline-secondary" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.barang.edit', $item) }}" class="btn btn-outline-primary" title="Ubah">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <!-- Soft Delete Button (Khusus Manager sesuai RBAC) -->
                                @if(Auth::user()?->role === 'manager')
                                    <form action="{{ route('admin.barang.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan barang {{ $item->nama_barang }} ke tempat sampah?');">
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
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                            Tidak ada data barang yang ditemukan untuk kriteria pencarian ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION LINKS (10 Data Per Halaman) -->
    <div class="card-footer bg-white py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="small text-muted">
            Menampilkan 10 data per halaman secara otomatis.
        </div>
        <div>
            {{ $barang->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection

