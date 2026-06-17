<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    $key = $request->header('x-api-key');

    // Cek apakah key ada di database user
    $user = \App\Models\User::where('api_key', $key)->first();

    if (!$user) {
        return response()->json(['message' => 'API Key Tidak Valid!'], 401);
    }

    return $next($request);
}
}
