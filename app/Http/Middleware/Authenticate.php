<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Models\Users;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        if (!Auth::check()) {
            return $request->expectsJson() ? null : route('sign-in');
        }
        $user = Auth::user();


        if ($user->role !== 'admin') {
            Auth::logout();
            return route('sign-in');
        }

        return null;
    }
}
