<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard') - GudangSmart Inventory</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f4f6f9;
            color: #334155;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .main-wrapper {
            display: flex;
            flex: 1;
        }
        .content-area {
            flex: 1;
            padding: 1.75rem 2rem;
            background-color: #f8fafc;
            overflow-y: auto;
        }
        .card {
            border-radius: 0.75rem;
        }
        footer {
            margin-top: auto;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- 1. Header & Top Navigation Bar (Reusable Component) -->
    <header>
        <x-navbar />
    </header>

    <!-- 2. Main Wrapper: Sidebar Navigation & Content Area -->
    <div class="main-wrapper">
        <!-- Sidebar Navigation (Reusable Component) -->
        <aside>
            <x-sidebar />
        </aside>

        <!-- 3. Content Area (Directives: @yield('content')) -->
        <main class="content-area">
            <div class="container-fluid p-0">
                <!-- Flash Message Alerts -->
                @if(session('success'))
                    <x-alert type="success" :message="session('success')" />
                @endif

                @if(session('error'))
                    <x-alert type="danger" :message="session('error')" />
                @endif

                @if(session('warning'))
                    <x-alert type="warning" :message="session('warning')" />
                @endif

                @if(session('info'))
                    <x-alert type="info" :message="session('info')" />
                @endif

                <!-- Dynamic Content Injected Here -->
                @yield('content')
            </div>
        </main>
    </div>

    <!-- 4. Footer Area Baku -->
    <footer class="bg-white border-top py-3 text-center text-muted small">
        <div class="container-fluid">
            <span>&copy; {{ date('Y') }} <strong>GudangSmart</strong> &mdash; Sistem Manufaktur & Inventory Berbasis Laravel Framework. Dibuat untuk Evaluasi Praktik PWTM.</span>
        </div>
    </footer>

    <!-- Bootstrap 5.3 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>

