<?php

namespace App\Http\Middleware\V1;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            if (Auth::user()->utype === 'ADMIN') {
                return $next($request);
            } else {
                Session::flush();

                return redirect()->route('login')->with('error', 'You are not authorized to access this page');
            }
        }
        return $next($request);
    }
}
