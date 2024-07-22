<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class BackGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Http::withHeaders([
            'Authorization' => 'Bearer ' . session('auth_token'),
            'Accept' => 'application/json',
        ])->get('http://127.0.0.1:8000/v1/user')->successful()) {
            return to_route('home');
        }
        return $next($request);
    }
}
