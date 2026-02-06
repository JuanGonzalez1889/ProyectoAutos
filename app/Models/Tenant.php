<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains, HasFactory;

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
        'business_hours',
        'social_media',
        'payment_methods',
        'whatsapp',
        'commission_percentage',
        'commission_currency',
        'business_registration',
        'tax_id',
        'business_type',
        'bank_name',
        'bank_account',
        'bank_account_holder',
        'bank_routing_number',
        'billing_address',
        'billing_notes',
        'auto_approve_leads',
        'response_time_hours',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'trial_ends_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
        'business_hours' => 'array',
        'social_media' => 'array',
        'payment_methods' => 'array',
        'commission_percentage' => 'decimal:2',
        'auto_approve_leads' => 'boolean',
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
     * Get all subscriptions for this tenant
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the active subscription
     */
    public function subscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active')->latest();
    }

    /**
     * Get all invoices for this tenant
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get all invitations for this tenant
     */
    public function invitations()
    {
        return $this->hasMany(Invitation::class, 'tenant_id');
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
    public function isSubscriptionActive(): bool
    {
        if ($this->isOnTrial()) {
            return true;
        }

        // Check new subscriptions table
        $activeSubscription = $this->subscriptions()
            ->where('status', 'active')
            ->where('current_period_end', '>', now())
            ->first();

        if ($activeSubscription) {
            return true;
        }

        // Fallback to old subscription_ends_at field
        return $this->subscription_ends_at && $this->subscription_ends_at->isFuture();
    }

    /**
     * Get days remaining in trial
     */
    public function trialDaysRemaining(): int
    {
        if (!$this->isOnTrial()) {
            return 0;
        }

        return now()->diffInDays($this->trial_ends_at, false);
    }

    /**
     * Obtener el primer dominio asociado al tenant
     */
    public function getPrimaryDomain()
    {
        return $this->domains()->first();
    }

    /**
     * Obtener el slug del dominio principal (sin .test)
     */
    public function getPrimaryDomainSlug()
    {
        $domain = $this->getPrimaryDomain();
        return $domain ? str_replace('.test', '', $domain->domain) : null;
    }

    /**
     * Obtener suscripción activa
     */
    public function activeSubscription()
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->latest()
            ->first();
    }

    /**
     * Verificar si tiene suscripción activa o trial vigente
     */
    public function hasActiveSubscription(): bool
    {
        $subscription = $this->activeSubscription();
        
        if (!$subscription) {
            return false;
        }

        // Si está en plan free con trial vigente
        if ($subscription->plan === 'free' && $subscription->isOnTrial()) {
            return true;
        }

        // Si está en plan pagado y es activo
        if ($subscription->plan !== 'free' && $subscription->isActive()) {
            return true;
        }

        return false;
    }

    /**
     * Obtener información de plan actual
     */
    public function getPlanInfo(): array
    {
        $subscription = $this->activeSubscription();
        
        if (!$subscription) {
            return [
                'plan' => 'free',
                'name' => 'Plan Gratuito',
                'is_trial' => false,
                'days_remaining' => 0,
            ];
        }

        return [
            'plan' => $subscription->plan,
            'name' => $subscription->getPlanConfig($subscription->plan)['name'] ?? 'Desconocido',
            'is_trial' => $subscription->isOnTrial(),
            'days_remaining' => $subscription->trialDaysRemaining(),
            'expires_at' => $subscription->trial_ends_at ?? $subscription->renews_at,
        ];
    }
}
