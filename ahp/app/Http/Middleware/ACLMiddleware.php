<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ACLMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        if (auth()->check() && auth()->user()->hasRole(explode('|', $roles))) {
            return $next($request);
        }

        return redirect()->intended('/login');
    }
}
