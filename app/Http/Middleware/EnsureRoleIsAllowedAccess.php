<?php

namespace App\Http\Middleware;

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

        if (in_array($currentRouteName, $this->accessRole()[$role]))
            return $next($request);

        abort(403, 'You are not allowed to access this page.');
    }

    private function accessRole()
    {
        return [
            'user' => ['dashboard'],
            'admin' => ['pages', 'navigation-menus']
        ];
    }
}
