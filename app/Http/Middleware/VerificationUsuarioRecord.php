<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificationUsuarioRecord
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = auth('usuario')->user(); // obtenemos el usuario autenticado
        $trabajador_tipo_trabajador = $usuario->trabajador_tipo_trabajador; // obtenemos el trabajador_tipo_trabajador del usuario autenticado
        $trabajador = $trabajador_tipo_trabajador->trabajador; // obtenemos el trabajador del usuario autenticado
        if($trabajador_tipo_trabajador->id_tipo_trabajador == 3)
        {
            $administrativo = $trabajador->administrativo; // obtenemos el administrativo del usuario autenticado
            if($administrativo->id_area_administrativo == 9) // verificamos si el usuario autenticado es de la area de record academico
            {
                return $next($request);
            }
            else
            {
                return redirect()->back();
            }
        }
        else
        {
            return redirect()->back();
        }
    }
}
