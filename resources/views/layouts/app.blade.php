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

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'] },
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d4d4d8; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #a1a1aa; }
    </style>
    @stack('styles')
</head>
<body class="bg-zinc-50/80 text-zinc-700 min-h-screen flex flex-col antialiased">

    <!-- 1. Header & Top Navigation Bar (Reusable Component) -->
    <header class="sticky top-0 z-50">
        <x-navbar />
    </header>

    <!-- 2. Main Wrapper: Sidebar Navigation & Content Area -->
    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar Navigation (Reusable Component) -->
        <aside class="hidden lg:block flex-shrink-0">
            <x-sidebar />
        </aside>

        <!-- 3. Content Area (Directives: @yield('content')) -->
        <main class="flex-1 overflow-y-auto p-6 lg:p-8">
            <div class="max-w-7xl mx-auto">
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

    <!-- 4. Footer Area -->
    <footer class="border-t border-zinc-200/60 bg-white py-4 text-center text-zinc-400 text-xs">
        <span>&copy; {{ date('Y') }} <strong class="text-zinc-600">GudangSmart</strong> &mdash; Sistem Manufaktur & Inventory Berbasis Laravel Framework. Dibuat untuk Evaluasi Praktik PWTM.</span>
    </footer>

    @stack('scripts')
</body>
</html>
