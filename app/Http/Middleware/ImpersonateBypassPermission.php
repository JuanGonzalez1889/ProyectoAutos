<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ImpersonateBypassPermission
{
    /**
     * Handle an incoming request.
     * Si el usuario impersonado no tiene el permiso, pero el admin original sí, permite el acceso.
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::user();
        // Si el usuario actual tiene el permiso, todo ok
        if ($user && $user->can($permission)) {
            return $next($request);
        }
        // Si está impersonando y el admin original tiene el permiso, permitir
        if (session()->has('impersonate_original_id')) {
            $original = \App\Models\User::find(session('impersonate_original_id'));
            if ($original && $original->can($permission)) {
                return $next($request);
            }
        }
        // Si ninguno tiene el permiso, lanzar excepción
        throw UnauthorizedException::forPermissions([$permission]);
    }
}
