<nav class="bg-white/80 backdrop-blur-xl border-b border-zinc-200/60 h-[49px] flex items-center px-4 lg:px-5">
    <div class="flex items-center justify-between w-full">
        <!-- Brand -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
            <div class="w-7 h-7 bg-zinc-900 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <span class="text-[15px] font-bold text-zinc-900 tracking-tight">Gudang<span class="text-zinc-400">Smart</span></span>
        </a>

        <!-- Right: User -->
        <div class="flex items-center gap-2">
            @auth
                <!-- Status pill -->
                <div class="hidden sm:flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-[11px] text-emerald-600 font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Online
                </div>

                <div class="relative" id="userDropdown">
                    <button onclick="document.getElementById('dropdownMenu').classList.toggle('hidden')" class="flex items-center gap-2 pl-2 pr-1.5 py-1 rounded-xl hover:bg-zinc-100/80 transition-colors">
                        <div class="w-7 h-7 rounded-full bg-zinc-900 text-white flex items-center justify-center text-xs font-semibold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <!-- Dropdown -->
                    <div id="dropdownMenu" class="hidden absolute right-0 mt-1.5 w-56 bg-white rounded-xl border border-zinc-200/60 shadow-lg shadow-zinc-200/40 py-1 z-50">
                        <div class="px-3 py-2.5 border-b border-zinc-100">
                            <p class="text-[13px] font-semibold text-zinc-900">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-zinc-400 mt-0.5">{{ Auth::user()->email }}</p>
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide mt-1.5 {{ Auth::user()->role === 'manager' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }}">
                                {{ Auth::user()->role }}
                            </span>
                        </div>
                        <div class="px-1.5 py-1">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-2.5 py-1.5 text-[13px] text-red-600 hover:bg-red-50 rounded-lg transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-zinc-900 text-white px-4 py-1.5 rounded-xl text-[13px] font-medium hover:bg-zinc-800 transition-colors">
                    Masuk
                </a>
            @endauth
        </div>
    </div>
</nav>

<script>
document.addEventListener('click', function(e) {
    const dd = document.getElementById('userDropdown');
    const menu = document.getElementById('dropdownMenu');
    if (dd && menu && !dd.contains(e.target)) {
        menu.classList.add('hidden');
    }
});
</script>
