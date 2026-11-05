<div class="flex flex-col w-64 bg-white border-r border-zinc-200/60 h-[calc(100vh-57px)] overflow-y-auto">
    <!-- Profile Mini Summary -->
    <div class="p-4 m-4 mb-2 bg-zinc-50 rounded-xl border border-zinc-200/60">
        <div class="text-[10px] uppercase tracking-wider text-zinc-400 font-semibold mb-1.5">Akses Pengguna</div>
        <div class="font-semibold text-zinc-900 text-sm truncate">{{ Auth::user()->name ?? 'Tamu' }}</div>
        <div class="mt-1.5">
            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide {{ (Auth::user()->role ?? '') === 'manager' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }}">
                {{ Auth::user()->role ?? 'Guest' }}
            </span>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-3 py-2 space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-900 text-white shadow-sm' : 'text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900' }}">
            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zm0 7a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1h-4a1 1 0 01-1-1v-5zM4 13a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1v-2z"/></svg>
            Dashboard
        </a>

        <div class="pt-4 pb-1.5 px-3">
            <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-semibold">Master Data</span>
        </div>

        <!-- Supplier -->
        <a href="{{ route('admin.suppliers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.suppliers.*') ? 'bg-zinc-900 text-white shadow-sm' : 'text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900' }}">
            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Supplier
        </a>

        <!-- Katalog Barang -->
        <a href="{{ route('admin.barang.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.barang.index') || request()->routeIs('admin.barang.create') || request()->routeIs('admin.barang.edit') || request()->routeIs('admin.barang.show') ? 'bg-zinc-900 text-white shadow-sm' : 'text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900' }}">
            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            Katalog Barang
        </a>

        <!-- Kategori Barang -->
        <a href="{{ route('admin.kategori.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.kategori.*') ? 'bg-zinc-900 text-white shadow-sm' : 'text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900' }}">
            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
            Kategori Barang
        </a>

        <!-- Mutasi Stok -->
        <a href="{{ route('admin.mutasi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.mutasi.*') ? 'bg-zinc-900 text-white shadow-sm' : 'text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900' }}">
            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            Mutasi Stok
        </a>

        @if(Auth::user()?->role === 'manager')
            <div class="pt-4 pb-1.5 px-3">
                <span class="text-[10px] uppercase tracking-wider text-red-400 font-semibold">Area Manager</span>
            </div>

            <!-- Trash -->
            <a href="{{ route('admin.barang.trash') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.barang.trash') ? 'bg-red-500 text-white shadow-sm' : 'text-red-500 hover:bg-red-50' }}">
                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Data Sampah (Trash)
            </a>
        @endif
    </nav>

    <!-- Footer -->
    <div class="p-4 border-t border-zinc-100 text-center">
        <div class="text-xs font-semibold text-zinc-500">GudangSmart v1.0</div>
        <div class="text-[10px] text-zinc-400 mt-0.5">Arsitektur MVC Laravel</div>
    </div>
</div>
