<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'address',
        'plan',
        'is_active',
        'trial_ends_at',
        'subscription_ends_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'trial_ends_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'email',
            'phone',
            'address',
            'plan',
            'is_active',
            'trial_ends_at',
            'subscription_ends_at',
        ];
    }

    /**
     * Get the administrator user for this tenant
     */
    public function administrator()
    {
        return $this->hasOne(User::class, 'tenant_id')->where('role', 'ADMIN');
    }

    /**
     * Get all users for this tenant
     */
    public function users()
    {
        return $this->hasMany(User::class, 'tenant_id');
    }

    /**
     * Get settings for this tenant
     */
    public function settings()
    {
        return $this->hasOne(TenantSetting::class, 'tenant_id', 'id');
    }

    /**
     * Get all vehicles for this tenant
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'tenant_id', 'id');
    }

    /**
     * Check if tenant is on trial
     */
    public function isOnTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Check if subscription is active
     */
    public function hasActiveSubscription(): bool
    {
        if ($this->isOnTrial()) {
            return true;
        }

        return $this->subscription_ends_at && $this->subscription_ends_at->isFuture();
    }
}
