<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        if (app('auth')->guest()) {
            return redirect()->route('login');
        }

        $arrRoles = is_array($roles)
            ? $roles
            : explode('|', $roles);
        if (auth()->user()->roles() && in_array(auth()->user()->roles()->first()->name, $arrRoles)) {
            return $next($request);
        }

        return abort(404);

    }
}
