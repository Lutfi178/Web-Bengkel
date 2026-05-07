<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->role !== 'admin') {
            return redirect()
                ->route('sparepart.stok')
                ->with('error', 'Akses admin tidak tersedia untuk user biasa.');
        }

        return $next($request);
    }
}
