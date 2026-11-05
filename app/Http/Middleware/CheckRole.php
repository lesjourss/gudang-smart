<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah pengguna sudah terautentikasi
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir atau Anda belum login. Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // 2. Cek apakah peran pengguna sesuai dengan peran yang diizinkan pada rute ini
        if (!in_array($user->role, $roles)) {
            // Jika request AJAX/JSON, return 403 JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Akses ditolak: Anda tidak memiliki wewenang untuk tindakan ini.'
                ], 403);
            }

            // Jika pengguna adalah staff tapi mencoba tindakan restricted manager
            return redirect()->route('admin.dashboard')->with('error', "Akses Ditolak: Peran akun Anda ({$user->role}) tidak memiliki izin untuk mengakses fitur tersebut.");
        }

        return $next($request);
    }
}

