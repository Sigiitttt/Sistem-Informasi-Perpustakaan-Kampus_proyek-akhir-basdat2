<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna sudah login DAN memiliki role 'admin'.
        // Jika tidak, tolak akses dengan halaman 403 Forbidden.
        if (! $request->user() || $request->user()->role !== 'admin') {
            abort(403, 'AKSES DITOLAK.');
        }

        // Jika pengguna adalah admin, izinkan request untuk melanjutkan.
        return $next($request);
    }
}