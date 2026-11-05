<nav class="bg-white/80 backdrop-blur-xl border-b border-zinc-200/60 px-4 lg:px-6 py-3">
    <div class="flex items-center justify-between">
        <!-- Brand / Logo -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
            <div class="w-8 h-8 bg-zinc-900 rounded-lg flex items-center justify-center">
                <svg class="w-4.5 h-4.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <span class="text-lg font-bold text-zinc-900 tracking-tight">Gudang<span class="text-zinc-500">Smart</span></span>
        </a>

        <!-- Center: System Status -->
        <div class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-zinc-50 rounded-full border border-zinc-200/60 text-xs text-zinc-500">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span>Sistem <strong class="text-emerald-600">Online</strong></span>
        </div>

        <!-- Right: User Info -->
        <div class="flex items-center gap-3">
            @auth
                <div class="relative" id="userDropdown">
                    <button onclick="document.getElementById('dropdownMenu').classList.toggle('hidden')" class="flex items-center gap-3 px-2 py-1.5 rounded-xl hover:bg-zinc-50 transition-colors">
                        <div class="w-8 h-8 rounded-full bg-zinc-900 text-white flex items-center justify-center text-sm font-semibold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="hidden sm:block text-left">
                            <div class="text-sm font-semibold text-zinc-900 leading-tight">{{ Auth::user()->name }}</div>
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-medium uppercase tracking-wide {{ Auth::user()->role === 'manager' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }}">
                                {{ Auth::user()->role }}
                            </span>
                        </div>
                        <svg class="w-4 h-4 text-zinc-400 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-xl border border-zinc-200/60 shadow-lg shadow-zinc-200/50 py-2 z-50">
                        <div class="px-4 py-2 border-b border-zinc-100">
                            <p class="text-xs text-zinc-400">Detail Akun</p>
                            <p class="text-sm text-zinc-600 mt-1 flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                {{ Auth::user()->email }}
                            </p>
                            <p class="text-sm text-zinc-600 mt-1 flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Role: {{ ucfirst(Auth::user()->role) }}
                            </p>
                        </div>
                        <div class="px-2 py-1.5">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Keluar (Logout)
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-zinc-900 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-zinc-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Masuk
                </a>
            @endauth
        </div>
    </div>
</nav>

<!-- Close dropdown when clicking outside -->
<script>
document.addEventListener('click', function(e) {
    const dd = document.getElementById('userDropdown');
    const menu = document.getElementById('dropdownMenu');
    if (dd && menu && !dd.contains(e.target)) {
        menu.classList.add('hidden');
    }
});
</script>
