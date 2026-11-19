<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarRol
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $usuario = $request->user();

        if (!$usuario || !in_array($usuario->rol, $roles, true)) {
            abort(403, 'Acceso denegado. No tienes permisos para esta accion.');
        }

        return $next($request);
    }
}
