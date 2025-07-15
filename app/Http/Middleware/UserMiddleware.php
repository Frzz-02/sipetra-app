<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class UserMiddleware
{
      /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse
     */
     public function handle(Request $request, Closure $next)
    {
        // Jika belum login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Jika login tapi bukan penyedia
        if (Auth::user()->role !== 'user') {
            return redirect('/login');
        }

        return $next($request);
    }

}


