<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PenulisMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
{
    // Debug: Cek apakah user sudah login
    if (auth()->check()) {
        // Ambil role dari user (pastikan huruf kecil semua)
        if (auth()->user()->role === 'penulis') {
            return $next($request);
        }
    }

    // Jika gagal, arahkan ke Home (/) agar tidak loop ke login-page
    return redirect('/')->with('error', 'Role Anda bukan penulis!');
}
}