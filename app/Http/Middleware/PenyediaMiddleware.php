<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenyediaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika belum login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Jika login tapi bukan penyedia
        if (Auth::user()->role !== 'penyedia_jasa') {
            return redirect('/login');
        }

        return $next($request);
    }
}
