<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'tenant_id',
        'user_id',
        'action',
        'module',
        'model_type',
        'model_id',
        'description',
        'changes',
        'metadata',
        'status',
    ];

    /**
     * Attribute casts
     */
    protected function casts(): array
    {
        return [
            'changes' => 'json',
            'metadata' => 'json',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Relation: Activity belongs to User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation: Activity belongs to Tenant
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get polymorphic model
     */
    public function getModel()
    {
        if ($this->model_type && $this->model_id) {
            return $this->model_type::find($this->model_id);
        }
        return null;
    }

    /**
     * Scope: Filter by tenant
     */
    public function scopeForTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    /**
     * Scope: Filter by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Filter by module
     */
    public function scopeByModule($query, $module)
    {
        return $query->where('module', $module);
    }

    /**
     * Scope: Filter by action
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope: Recent activities (last 7 days)
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Log activity
     */
    public static function logActivity(array $data): self
    {
        return static::create([
            'tenant_id' => $data['tenant_id'] ?? auth()->user()?->tenant_id,
            'user_id' => $data['user_id'] ?? auth()->id(),
            'action' => $data['action'],
            'module' => $data['module'],
            'model_type' => $data['model_type'] ?? null,
            'model_id' => $data['model_id'] ?? null,
            'description' => $data['description'] ?? null,
            'changes' => $data['changes'] ?? null,
            'metadata' => [
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ],
            'status' => $data['status'] ?? 'success',
        ]);
    }
}
