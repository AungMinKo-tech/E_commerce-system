<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // If user is authenticated and trying to access login/register, redirect based on role
            if ($request->route()->getName() == 'login' || $request->route()->getName() == 'register') {
                if (Auth::user()->role == 'admin' || Auth::user()->role == 'owner') {
                    return redirect()->route('admin#dashboard');
                } elseif (Auth::user()->role == 'delivery') {
                    return redirect()->route('delivery#home');
                } else {
                    return redirect()->route('user#home');
                }
            }
            return $next($request);
        } else {
            return $next($request);
        }
    }
}
