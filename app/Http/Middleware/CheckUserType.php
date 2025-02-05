<?php

namespace App\Http\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!empty(Auth::check())) {
            return $next($request);
        } else {
            Auth::logout(); 
            return redirect(url('')); 
        }
    }
}