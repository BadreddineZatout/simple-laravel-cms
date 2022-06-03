<?php

namespace App\Http\Middleware;

use App\Models\UserPermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class EnsureRoleIsAllowedAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $role = auth()->user()->role;
        $currentRouteName = Route::currentRouteName();

        if (UserPermission::where([
            'role' => $role,
            'route_name' => $currentRouteName
        ])->count()) {
            return $next($request);
        }

        abort(403, 'You are not allowed to access this page.');
    }
}
