<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        // Jika belum login
        if (!Auth::check()) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        // Jika bukan admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Anda bukan admin.');
        }

        return $next($request);
    }
}
