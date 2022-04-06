<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if (app('auth')->guest()) {
            return redirect()->route('login');
        }

        $arrPermissions = auth()->user()->roles()->first()->permissions()->get()->map(function ($item) {
            return $item->name;
        })->toArray();

        $specificPermission = auth()->user()->permissions()->get()->map(function ($item) {
            return $item->name;
        })->toArray();

        if (in_array($permission, $arrPermissions) || in_array($permission, $specificPermission)) {
            return $next($request);
        }

        return abort(404);

    }
}
