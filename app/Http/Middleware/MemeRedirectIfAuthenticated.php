<?php

namespace App\Http\Middleware;

use Closure;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemeRedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //        dd(Auth::guard($guard)->check());
        if (Auth::guard($guard)->check()) {
            return redirect()->route('memes.index');
        }
        return $next($request);
    }
}
