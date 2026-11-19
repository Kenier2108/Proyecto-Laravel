<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BloquearCambiosConsulta
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->rol === 'consulta') {
            $metodo = $request->route()?->getActionMethod();

            if (
                !in_array($request->method(), ['GET', 'HEAD', 'OPTIONS'], true)
                || in_array($metodo, ['create', 'edit', 'store', 'update', 'destroy'], true)
            ) {
                abort(403, 'El rol consulta solo tiene permiso de lectura.');
            }
        }

        return $next($request);
    }
}
