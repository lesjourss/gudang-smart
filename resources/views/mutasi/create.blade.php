@extends('layouts.app')

@section('title', 'Catat Mutasi Stok')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1 small">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.mutasi.index') }}" class="text-decoration-none">Mutasi Stok</a></li>
            <li class="breadcrumb-item active" aria-current="page">Catat Mutasi</li>
        </ol>
    </nav>
    <h2 class="h3 fw-bold text-dark mb-1">Catat Transaksi Mutasi Stok</h2>
    <p class="text-muted mb-0">Inputkan penerimaan barang dari pemasok atau pengeluaran barang untuk kebutuhan operasional.</p>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="card-title fw-bold text-dark mb-0 d-flex align-items-center">
                    <i class="bi bi-arrow-left-right text-primary me-2"></i> Formulir Pergerakan Stok
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.mutasi.store') }}" method="POST">
                    @csrf

                    <!-- Pilih Barang -->
                    <div class="mb-3">
                        <label for="barang_id" class="form-label fw-semibold text-secondary small">
                            Pilih Barang Inventaris <span class="text-danger">*</span>
                        </label>
                        <select name="barang_id" id="barang_id" class="form-select @error('barang_id') is-invalid @enderror" required onchange="updateStokInfo(this)">
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barangList as $b)
                                <option value="{{ $b->id }}" data-stok="{{ $b->stok }}" {{ old('barang_id', request('barang_id')) == $b->id ? 'selected' : '' }}>
                                    {{ $b->nama_barang }} ({{ $b->kode_barang }}) — Sisa Stok: {{ $b->stok }} unit
                                </option>
                            @endforeach
                        </select>
                        <div id="stokInfoBadge" class="mt-2 small text-muted"></div>
                        @error('barang_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jenis Mutasi (Masuk / Keluar) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">
                            Jenis Mutasi Transaksi <span class="text-danger">*</span>
                        </label>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="form-check p-3 border rounded-3 bg-light">
                                    <input class="form-check-input ms-0 me-2" type="radio" name="jenis_mutasi" id="jenis_masuk" value="masuk" {{ old('jenis_mutasi', 'masuk') === 'masuk' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-success" for="jenis_masuk">
                                        <i class="bi bi-box-arrow-in-down me-1"></i> Barang Masuk (Penerimaan)
                                    </label>
                                    <div class="small text-muted mt-1 ps-4">Menambah kuantitas stok fisik di gudang.</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check p-3 border rounded-3 bg-light">
                                    <input class="form-check-input ms-0 me-2" type="radio" name="jenis_mutasi" id="jenis_keluar" value="keluar" {{ old('jenis_mutasi') === 'keluar' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-danger" for="jenis_keluar">
                                        <i class="bi bi-box-arrow-up me-1"></i> Barang Keluar (Pengeluaran)
                                    </label>
                                    <div class="small text-muted mt-1 ps-4">Mengurangi kuantitas stok fisik di gudang.</div>
                                </div>
                            </div>
                        </div>
                        @error('jenis_mutasi')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jumlah Mutasi -->
                    <div class="mb-3">
                        <label for="jumlah" class="form-label fw-semibold text-secondary small">
                            Jumlah Unit Mutasi <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', 1) }}" min="1" required>
                            <span class="input-group-text bg-light text-muted">Unit</span>
                        </div>
                        <div class="form-text small">Minimal 1 unit. Pada barang keluar, jumlah tidak boleh melebihi sisa stok fisik.</div>
                        @error('jumlah')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keterangan / Referensi Dokumen -->
                    <div class="mb-4">
                        <label for="keterangan" class="form-label fw-semibold text-secondary small">
                            Keterangan / No. Surat Jalan / Catatan Transaksi
                        </label>
                        <textarea name="keterangan" id="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Contoh: Penerimaan PO-2026-0045 dari Supplier atau Permintaan Departemen Produksi">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('admin.mutasi.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">
                            <i class="bi bi-check-circle me-1"></i> Simpan Transaksi Mutasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateStokInfo(selectElement) {
        const selected = selectElement.options[selectElement.selectedIndex];
        const stok = selected.getAttribute('data-stok');
        const badge = document.getElementById('stokInfoBadge');
        if (stok !== null && stok !== undefined) {
            badge.innerHTML = `<span class="badge bg-secondary-subtle text-secondary"><i class="bi bi-layers me-1"></i>Sisa Stok Terkini: <strong>${stok} unit</strong></span>`;
        } else {
            badge.innerHTML = '';
        }
    }
    // Inisialisasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('barang_id');
        if (select.value) updateStokInfo(select);
    });
</script>
@endpush
@endsection

