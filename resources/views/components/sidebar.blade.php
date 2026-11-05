<div class="d-flex flex-column flex-shrink-0 p-3 bg-white border-end shadow-sm" style="min-height: calc(100vh - 60px); width: 260px;">
    <!-- Profile Mini Summary -->
    <div class="p-3 mb-3 bg-light rounded-3 border">
        <div class="small text-muted text-uppercase fw-semibold mb-1">Akses Pengguna</div>
        <div class="fw-bold text-dark text-truncate">{{ Auth::user()->name ?? 'Tamu' }}</div>
        <div class="d-flex align-items-center mt-1">
            <span class="badge {{ (Auth::user()->role ?? '') === 'manager' ? 'bg-danger' : 'bg-primary' }} text-uppercase">
                <i class="bi {{ (Auth::user()->role ?? '') === 'manager' ? 'bi-shield-shaded' : 'bi-person-badge' }} me-1"></i>
                {{ Auth::user()->role ?? 'Guest' }}
            </span>
        </div>
    </div>

    <!-- Navigation Menu Items (Instruksi Soal 2.2) -->
    <ul class="nav nav-pills flex-column mb-auto gap-1">
        <!-- 1. Menu Dashboard -->
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link d-flex align-items-center py-2 px-3 {{ request()->routeIs('admin.dashboard') ? 'active bg-primary text-white shadow-sm' : 'text-secondary hover-link' }}">
                <i class="bi bi-speedometer2 me-2 fs-5"></i>
                <span class="fw-medium">Dashboard</span>
            </a>
        </li>

        <li class="my-2 border-top"></li>
        <div class="text-uppercase text-muted fw-bold px-3 py-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">Master Data</div>

        <!-- 2. Menu Supplier -->
        <li class="nav-item">
            <a href="{{ route('admin.suppliers.index') }}" class="nav-link d-flex align-items-center justify-content-between py-2 px-3 {{ request()->routeIs('admin.suppliers.*') ? 'active bg-primary text-white shadow-sm' : 'text-secondary hover-link' }}">
                <div class="d-flex align-items-center">
                    <i class="bi bi-truck me-2 fs-5"></i>
                    <span class="fw-medium">Supplier</span>
                </div>
                @if(Auth::user()?->role === 'manager')
                    <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.65rem;">Kelola</span>
                @else
                    <span class="badge bg-secondary-subtle text-secondary" style="font-size: 0.65rem;">Lihat</span>
                @endif
            </a>
        </li>

        <!-- 3. Menu Katalog Barang -->
        <li class="nav-item">
            <a href="{{ route('admin.barang.index') }}" class="nav-link d-flex align-items-center py-2 px-3 {{ request()->routeIs('admin.barang.index') || request()->routeIs('admin.barang.create') || request()->routeIs('admin.barang.edit') || request()->routeIs('admin.barang.show') ? 'active bg-primary text-white shadow-sm' : 'text-secondary hover-link' }}">
                <i class="bi bi-box-seam me-2 fs-5"></i>
                <span class="fw-medium">Katalog Barang</span>
            </a>
        </li>

        <!-- 4. Menu Kategori Barang (Sesuai Soal 2.2) -->
        <li class="nav-item">
            <a href="{{ route('admin.kategori.index') }}" class="nav-link d-flex align-items-center py-2 px-3 {{ request()->routeIs('admin.kategori.*') ? 'active bg-primary text-white shadow-sm' : 'text-secondary hover-link' }}">
                <i class="bi bi-tags me-2 fs-5"></i>
                <span class="fw-medium">Kategori Barang</span>
            </a>
        </li>

        <!-- 5. Menu Mutasi Stok (Sesuai Soal 2.2) -->
        <li class="nav-item">
            <a href="{{ route('admin.mutasi.index') }}" class="nav-link d-flex align-items-center py-2 px-3 {{ request()->routeIs('admin.mutasi.*') ? 'active bg-primary text-white shadow-sm' : 'text-secondary hover-link' }}">
                <i class="bi bi-arrow-left-right me-2 fs-5"></i>
                <span class="fw-medium">Mutasi Stok</span>
                <span class="badge {{ request()->routeIs('admin.mutasi.*') ? 'bg-light text-primary' : 'bg-warning text-dark' }} ms-auto" style="font-size: 0.65rem;">Masuk/Keluar</span>
            </a>
        </li>

        @if(Auth::user()?->role === 'manager')
            <li class="my-2 border-top"></li>
            <div class="text-uppercase text-danger fw-bold px-3 py-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">Area Khusus Manager</div>

            <!-- Menu Trash / Soft Delete -->
            <li class="nav-item">
                <a href="{{ route('admin.barang.trash') }}" class="nav-link d-flex align-items-center py-2 px-3 {{ request()->routeIs('admin.barang.trash') ? 'active bg-danger text-white shadow-sm' : 'text-danger hover-link' }}">
                    <i class="bi bi-trash3 me-2 fs-5"></i>
                    <span class="fw-medium">Data Sampah (Trash)</span>
                </a>
            </li>
        @endif
    </ul>

    <!-- Quick System Help/Documentation -->
    <div class="mt-auto pt-3 border-top text-center text-muted small">
        <div><i class="bi bi-shield-check text-primary me-1"></i> <strong>GudangSmart v1.0</strong></div>
        <div style="font-size: 0.75rem;">Arsitektur MVC Laravel</div>
    </div>
</div>

<style>
    .hover-link:hover {
        background-color: #f8f9fa;
        color: #0d6efd !important;
    }
</style>

