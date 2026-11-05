<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - GudangSmart Inventory</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Inter', system-ui, sans-serif; }</style>
</head>
<body class="bg-zinc-50 min-h-screen flex items-center justify-center p-4 antialiased">

    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl border border-zinc-200/60 shadow-sm p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-14 h-14 bg-zinc-900 rounded-2xl mb-4">
                    <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Gudang<span class="text-zinc-400">Smart</span></h1>
                <p class="text-zinc-500 text-sm mt-1">Sistem Manufaktur & Inventory Gudang</p>
            </div>

            @if(session('info'))
                <div class="flex items-center gap-2 px-4 py-3 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 text-sm mb-4">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('info') }}
                </div>
            @endif

            @if(session('error'))
                <div class="flex items-center gap-2 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm mb-4">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login.authenticate') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Alamat Email</label>
                    <input type="email" name="email" id="email" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition @error('email') border-red-300 ring-2 ring-red-100 @enderror" value="{{ old('email', 'manager@gudangsmart.com') }}" required autofocus placeholder="nama@gudangsmart.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                    <input type="password" name="password" id="password" class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-4 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition @error('password') border-red-300 ring-2 ring-red-100 @enderror" value="password" required placeholder="Masukkan kata sandi">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" id="remember" checked class="w-4 h-4 rounded border-zinc-300 text-zinc-900 focus:ring-zinc-900/20">
                    <span class="text-sm text-zinc-500">Ingat sesi login di perangkat ini</span>
                </label>
                <button type="submit" class="w-full bg-zinc-900 text-white rounded-xl py-2.5 text-sm font-semibold hover:bg-zinc-800 transition shadow-sm">
                    Masuk ke GudangSmart
                </button>
            </form>

            <!-- Test Credentials -->
            <div class="mt-6 pt-5 border-t border-zinc-100">
                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-3">Akun Uji Coba</p>
                <div class="space-y-2">
                    <button type="button" onclick="setLogin('manager@gudangsmart.com')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border border-zinc-200 hover:bg-zinc-50 transition text-left">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span class="text-sm text-zinc-700">manager@gudangsmart.com</span>
                        </div>
                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold bg-red-50 text-red-600">Akses Penuh</span>
                    </button>
                    <button type="button" onclick="setLogin('staff@gudangsmart.com')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl border border-zinc-200 hover:bg-zinc-50 transition text-left">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span class="text-sm text-zinc-700">staff@gudangsmart.com</span>
                        </div>
                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold bg-blue-50 text-blue-600">Akses Terbatas</span>
                    </button>
                </div>
                <p class="text-center text-zinc-400 text-[11px] mt-3">Password default: <code class="bg-zinc-100 px-1.5 py-0.5 rounded text-zinc-600">password</code></p>
            </div>
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
