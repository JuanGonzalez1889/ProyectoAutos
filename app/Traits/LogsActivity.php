<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    /**
     * Log an activity
     */
    public static function logActivity(string $action, string $module, ?Model $model = null, ?string $description = null, ?array $changes = null): ActivityLog
    {
        return ActivityLog::logActivity([
            'action' => $action,
            'module' => $module,
            'model_type' => $model ? $model::class : null,
            'model_id' => $model?->id,
            'description' => $description,
            'changes' => $changes,
        ]);
    }

    /**
     * Log created event
     */
    public static function logCreated(string $module, Model $model, ?string $description = null): ActivityLog
    {
        return self::logActivity('create', $module, $model, $description ?? "Creado nuevo {$module}");
    }

    /**
     * Log updated event
     */
    public static function logUpdated(string $module, Model $model, array $changes, ?string $description = null): ActivityLog
    {
        return self::logActivity('edit', $module, $model, $description ?? "Actualizado {$module}", $changes);
    }

    /**
     * Log deleted event
     */
    public static function logDeleted(string $module, Model $model, ?string $description = null): ActivityLog
    {
        return self::logActivity('delete', $module, $model, $description ?? "Eliminado {$module}");
    }

    /**
     * Log viewed event
     */
    public static function logViewed(string $module, ?Model $model = null, ?string $description = null): ActivityLog
    {
        return self::logActivity('view', $module, $model, $description ?? "Visualizado {$module}");
    }
}
