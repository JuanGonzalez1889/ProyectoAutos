<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserPermissionController extends Controller
{
    use AuthorizesRequests;
    /**
     * Show user permissions management page
     */
    public function edit(User $user)
    {
        $this->authorize('users.change_permissions');

        // Ensure user belongs to current tenant
        if ($user->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'No tienes permiso para modificar permisos de este usuario');
        }

        // Get all available permissions grouped by module
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });

        // Get user's current permissions and roles
        $userPermissions = $user->permissions()->pluck('name')->toArray();
        $userRoles = $user->roles()->pluck('name')->toArray();

        // Get all roles for assignment
        $availableRoles = Role::all();

        return view('admin.users.permissions', compact('user', 'permissions', 'userPermissions', 'userRoles', 'availableRoles'));
    }

    /**
     * Update user permissions
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('users.change_permissions');

        // Ensure user belongs to current tenant
        if ($user->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'No tienes permiso para modificar permisos de este usuario');
        }

        $validated = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
        ]);

        // Store old permissions for audit
        $oldPermissions = $user->permissions()->pluck('name')->toArray();
        $oldRoles = $user->roles()->pluck('name')->toArray();

        // Sync permissions
        $permissionsToSync = $validated['permissions'] ?? [];
        $user->syncPermissions($permissionsToSync);

        // Sync roles
        $rolesToSync = $validated['roles'] ?? [];
        $user->syncRoles($rolesToSync);

        // Log activity
        ActivityLog::logActivity([
            'action' => 'update',
            'module' => 'users',
            'model_type' => User::class,
            'model_id' => $user->id,
            'description' => "Actualizados permisos del usuario {$user->name}",
            'changes' => [
                'permissions' => [
                    'old' => $oldPermissions,
                    'new' => $permissionsToSync,
                ],
                'roles' => [
                    'old' => $oldRoles,
                    'new' => $rolesToSync,
                ],
            ],
        ]);

        return redirect()->route('admin.users.show', $user)
            ->with('success', "Permisos de {$user->name} actualizados correctamente");
    }

    /**
     * View user activity log
     */
    public function activityLog(User $user)
    {
        $this->authorize('audit.view_logs');

        // Ensure user belongs to current tenant
        if ($user->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'No tienes permiso para ver la auditoría de este usuario');
        }

        $activities = ActivityLog::where('user_id', $user->id)
            ->latest()
            ->paginate(50);

        return view('admin.audit.user-activity', compact('user', 'activities'));
    }

    /**
     * View all activity logs for agency
     */
    public function allActivityLogs()
    {
        $this->authorize('audit.view_logs');

        $activities = ActivityLog::where('tenant_id', auth()->user()->tenant_id)
            ->with('user')
            ->latest()
            ->paginate(50);

        return view('admin.audit.activity-logs', compact('activities'));
    }

    /**
     * Export activity logs
     */
    public function exportActivityLogs(Request $request)
    {
        $this->authorize('audit.view_logs');

        $query = ActivityLog::where('tenant_id', auth()->user()->tenant_id);

        // Apply filters
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('module') && $request->module) {
            $query->where('module', $request->module);
        }

        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $activities = $query->get();

        // Generate CSV
        $csv = "Fecha,Usuario,Módulo,Acción,Descripción,Estado\n";
        foreach ($activities as $activity) {
            $csv .= "\"{$activity->created_at},";
            $csv .= $activity->user?->name ?? 'N/A'.",";
            $csv .= "{$activity->module},";
            $csv .= "{$activity->action},";
            $csv .= "{$activity->description},";
            $csv .= "{$activity->status}\"\n";
        }

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'activity-logs-' . now()->format('Y-m-d-His') . '.csv');
    }
}
