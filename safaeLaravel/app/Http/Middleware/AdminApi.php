<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminApi
{
    public function handle(Request $request, Closure $next)
    {
        // Token tidak ada / invalid
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.'
            ], 401);
        }

        // Bukan admin
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden. Admin only.'
            ], 403);
        }

        return $next($request);
    }
}
