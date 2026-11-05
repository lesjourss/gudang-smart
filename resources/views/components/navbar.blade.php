<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top border-bottom border-secondary shadow-sm py-2 px-3">
    <div class="container-fluid">
        <!-- Brand / Logo -->
        <a class="navbar-brand d-flex align-items-center fw-bold fs-5 text-white" href="{{ route('admin.dashboard') }}">
            <span class="badge bg-primary me-2 p-2 rounded-3 shadow-sm">
                <i class="bi bi-boxes fs-5"></i>
            </span>
            <span>Gudang<span class="text-primary">Smart</span></span>
        </a>

        <!-- Toggle Button for Mobile View -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#topNavbar" aria-controls="topNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="topNavbar">
            <!-- Left Side / Status Koneksi Sistem (Instruksi Soal 2.2) -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center">
                <li class="nav-item">
                    <div class="d-inline-flex align-items-center px-3 py-1 bg-secondary bg-opacity-25 rounded-pill border border-secondary border-opacity-50 text-light small my-1">
                        <span class="spinner-grow spinner-grow-sm text-success me-2" style="width: 0.65rem; height: 0.65rem;" role="status"></span>
                        <span class="fw-semibold text-white-50">Status Sistem:</span>
                        <span class="ms-1 fw-bold text-success">Online (MariaDB Terhubung)</span>
                    </div>
                </li>
            </ul>

            <!-- Right Side / Info Pengguna Aktif & Logout (Instruksi Soal 2.2) -->
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                @auth
                    <!-- User Info & Role Badge -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center text-white px-2 py-1 rounded hover-bg" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 34px; height: 34px; font-size: 0.9rem;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="text-start me-1">
                                <div class="fw-bold lh-sm text-white small">{{ Auth::user()->name }}</div>
                                <span class="badge {{ Auth::user()->role === 'manager' ? 'bg-danger' : 'bg-info text-dark' }} px-2 py-0 text-uppercase" style="font-size: 0.7rem;">
                                    {{ Auth::user()->role }}
                                </span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li class="dropdown-header">Detail Akun</li>
                            <li><span class="dropdown-item-text small text-muted"><i class="bi bi-envelope me-2"></i>{{ Auth::user()->email }}</span></li>
                            <li><span class="dropdown-item-text small text-muted"><i class="bi bi-shield-check me-2"></i>Role: {{ ucfirst(Auth::user()->role) }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                                        <i class="bi bi-box-arrow-right me-2"></i>Keluar (Logout)
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-sm btn-primary px-3 rounded-pill" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

