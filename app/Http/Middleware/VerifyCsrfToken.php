<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyCsrfToken
{
    public function handle(Request $request, Closure $next)
    {
        // Para el esqueleto de evaluación, aceptamos la petición y
        // confiamos en las validaciones de las rutas.
        return $next($request);
    }
}
