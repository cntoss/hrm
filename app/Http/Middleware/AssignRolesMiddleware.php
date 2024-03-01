<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AssignRolesMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            if ($user->can('create employee')) {
                $user->assignRole('admin');
            } elseif ($user->can('edit employee') || $user->can('view employee')) {
                $user->assignRole('manager');
            } else {
                $user->assignRole('user');
            }
        }

        return $next($request);
    }
}