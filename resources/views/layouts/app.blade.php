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
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d4d4d8; border-radius: 9px; }
        ::-webkit-scrollbar-thumb:hover { background: #a1a1aa; }
    </style>
    @stack('styles')
</head>
<body class="bg-zinc-50 text-zinc-700 antialiased">

    <!-- Full-height wrapper -->
    <div class="min-h-screen flex flex-col">

        <!-- 1. Top Navigation Bar -->
        <header class="sticky top-0 z-50">
            <x-navbar />
        </header>

        <!-- 2. Sidebar + Content -->
        <div class="flex flex-1">
            <!-- Sidebar -->
            <aside class="hidden lg:flex flex-shrink-0">
                <x-sidebar />
            </aside>

            <!-- 3. Main Content -->
            <main class="flex-1 min-w-0 overflow-y-auto">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
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

                    <!-- Dynamic Content -->
                    @yield('content')
                </div>

                <!-- Footer inside scrollable area -->
                <footer class="border-t border-zinc-200/60 bg-white/60 backdrop-blur-sm mt-auto py-4 px-6 text-center text-zinc-400 text-xs">
                    <span>&copy; {{ date('Y') }} <strong class="text-zinc-500">GudangSmart</strong> &mdash; Sistem Manufaktur & Inventory Berbasis Laravel. UTS Praktik PWTM.</span>
                </footer>
            </main>
        </div>

    </div>

    @stack('scripts')
</body>
</html>
