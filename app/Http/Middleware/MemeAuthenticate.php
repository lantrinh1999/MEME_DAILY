<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

//use Illuminate\Http\Request;

class MemeAuthenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {

        $this->authenticate($request, $guards);
        // if (!$guards) {
        //     $route = $request->route()->getAction();

        //     $flag = collect($route)->get('permission');
        //     if ($flag && !$request->user()->hasPermission((string) $flag)) {
        //         if ($request->expectsJson()) {
        //             return response()->json(['message' => 'Unauthenticated.'], 401);
        //         }
        //         return redirect(config('base.general.admin_dir', 'admin'));
        //     }
        // }

        return $next($request);
    }
}
