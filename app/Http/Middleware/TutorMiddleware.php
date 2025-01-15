<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TutorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Verifica si el usuario es un tutor
            if (Auth::user()->user_type == 4) {
                return $next($request); // Permite el acceso
            }
        }

        // Cierra la sesión y redirige a la raíz si no es tutor o no está autenticado
        Auth::logout();
        return redirect('/');
    }
}
