<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ActivityLog;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        // Check if user has the required permission
        if (!auth()->user()->hasPermissionTo($permission)) {
            // Log failed permission attempt
            ActivityLog::logActivity([
                'action' => 'unauthorized_access',
                'module' => explode('.', $permission)[0] ?? 'system',
                'description' => "Intento de acceso sin permiso: {$permission}",
                'status' => 'failed',
            ]);

            abort(403, "No tienes permiso para: {$permission}");
        }

        // Log the action
        $this->logAction($request, $permission);

        return $next($request);
    }

    /**
     * Log the action taken by the user
     */
    private function logAction(Request $request, string $permission): void
    {
        // Map HTTP methods and permissions to actions
        $action = match (true) {
            $request->isMethod('post') && str_ends_with($permission, '.create') => 'create',
            ($request->isMethod('put') || $request->isMethod('patch')) && str_ends_with($permission, '.edit') => 'edit',
            $request->isMethod('delete') && str_ends_with($permission, '.delete') => 'delete',
            $request->isMethod('get') && str_ends_with($permission, '.view') => 'view',
            default => 'access',
        };

        $module = explode('.', $permission)[0];

        ActivityLog::logActivity([
            'action' => $action,
            'module' => $module,
            'description' => "{$action} en {$module}",
        ]);
    }
}
