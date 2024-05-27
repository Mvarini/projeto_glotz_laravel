<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        // Adicionar o alias antes para funcionar esse redirecionamento bootstrap/app.php
//        if (!auth()->check()) {
//            return redirect()->route('login.index');
//        }
        return $next($request);
    }
}
