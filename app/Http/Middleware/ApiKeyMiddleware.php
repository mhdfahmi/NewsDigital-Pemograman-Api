<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    // Ambil api_key dari header 'x-api-key'
    $key = $request->header('x-api-key');
    
    // Cek apakah key tersebut ada di database tabel users
    if (!$key || !\App\Models\User::where('api_key', $key)->exists()) {
        return response()->json(['message' => 'API Key Tidak Valid!'], 401);
    }

    return $next($request);
}
}
