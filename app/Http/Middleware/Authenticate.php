<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     * Return null for API requests so middleware returns 401 JSON instead of redirecting.
     */
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return null;
        }

        // For non-API requests, attempt to redirect to named route 'login' if it exists.
        try {
            return route('login');
        } catch (\Throwable $e) {
            return '/login';
        }
    }
}
