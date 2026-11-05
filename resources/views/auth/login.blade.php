<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - GudangSmart Inventory</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border-radius: 1rem;
            max-width: 440px;
            width: 100%;
        }
    </style>
</head>
<body class="p-3">

    <div class="login-card bg-white p-4 p-md-5 shadow-lg">
        <div class="text-center mb-4">
            <div class="d-inline-flex p-3 bg-primary bg-opacity-10 text-primary rounded-4 mb-2">
                <i class="bi bi-boxes fs-1"></i>
            </div>
            <h3 class="fw-bold text-dark mb-1">Gudang<span class="text-primary">Smart</span></h3>
            <p class="text-muted small">Sistem Manufaktur & Inventory Gudang</p>
        </div>

        @if(session('info'))
            <div class="alert alert-info py-2 px-3 small rounded-3 mb-3 d-flex align-items-center">
                <i class="bi bi-info-circle me-2"></i> {{ session('info') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3 d-flex align-items-center">
                <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.authenticate') }}" method="POST">
            @csrf
            
            <!-- Input Email -->
            <div class="mb-3">
                <label for="email" class="form-label small fw-semibold text-secondary">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', 'manager@gudangsmart.com') }}" required autofocus placeholder="nama@gudangsmart.com">
                </div>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Password -->
            <div class="mb-3">
                <label for="password" class="form-label small fw-semibold text-secondary">Kata Sandi (Password)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="password" required placeholder="Masukkan kata sandi">
                </div>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                <label class="form-check-label small text-muted" for="remember">
                    Ingat sesi login di perangkat ini
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-3 shadow-sm">
                <i class="bi bi-box-arrow-in-right me-2"></i> Masuk ke GudangSmart
            </button>
        </form>

        <!-- Testing Credentials Helper -->
        <div class="mt-4 pt-3 border-top">
            <span class="d-block small text-muted fw-semibold mb-2">Akun Uji Coba Role-Based Access:</span>
            <div class="d-grid gap-1 small">
                <button type="button" class="btn btn-sm btn-light border text-start d-flex justify-content-between align-items-center" onclick="setLogin('manager@gudangsmart.com')">
                    <span><i class="bi bi-shield-lock text-danger me-1"></i> Manager: manager@gudangsmart.com</span>
                    <span class="badge bg-danger">Akses Penuh</span>
                </button>
                <button type="button" class="btn btn-sm btn-light border text-start d-flex justify-content-between align-items-center" onclick="setLogin('staff@gudangsmart.com')">
                    <span><i class="bi bi-person text-primary me-1"></i> Staff: staff@gudangsmart.com</span>
                    <span class="badge bg-primary">Akses Terbatas</span>
                </button>
            </div>
            <div class="text-muted text-center mt-2" style="font-size: 0.72rem;">Password default: <code>password</code></div>
        </div>
    </div>

    <script>
        function setLogin(email) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password';
        }
    </script>
</body>
</html>

