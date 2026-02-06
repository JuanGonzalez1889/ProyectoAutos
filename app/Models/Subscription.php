<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'stripe_id',
        'stripe_status',
        'stripe_price',
        'mercadopago_id',
        'mercadopago_status',
        'plan',
        'payment_method',
        'status',
        'amount',
        'currency',
        'current_period_start',
        'current_period_end',
        'trial_ends_at',
        'canceled_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'current_period_start' => 'datetime',
        'current_period_end' => 'datetime',
        'trial_ends_at' => 'datetime',
        'canceled_at' => 'datetime',
    ];

    /**
     * Get the tenant that owns the subscription
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the invoices for the subscription
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Check if the subscription is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && 
               $this->current_period_end && 
               $this->current_period_end->isFuture();
    }

    /**
     * Check if the subscription is on trial
     */
    public function onTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Check if the subscription is canceled
     */
    public function canceled(): bool
    {
        return !is_null($this->canceled_at);
    }

    /**
     * Check if the subscription has ended
     */
    public function ended(): bool
    {
        return $this->canceled() || 
               ($this->current_period_end && $this->current_period_end->isPast());
    }

    /**
     * Mark subscription as active
     */
    public function activate(): void
    {
        $this->update(['status' => 'active']);
    }

    /**
     * Cancel the subscription
     */
    public function cancel(): void
    {
        $this->update([
            'status' => 'canceled',
            'canceled_at' => now(),
        ]);
    }

    /**
     * Get plan details
     */
    public function getPlanDetails(): array
    {
        $plans = [
            'basic' => [
                'name' => 'Plan Básico',
                'price_usd' => 29,
                'price_ars' => 29000,
                'features' => ['10 vehículos', 'Plantilla básica', 'Soporte email'],
            ],
            'premium' => [
                'name' => 'Plan Premium',
                'price_usd' => 79,
                'price_ars' => 79000,
                'features' => ['50 vehículos', '4 plantillas', 'Soporte prioritario', 'Analytics'],
            ],
            'enterprise' => [
                'name' => 'Plan Enterprise',
                'price_usd' => 199,
                'price_ars' => 199000,
                'features' => ['Vehículos ilimitados', 'Plantillas custom', 'Soporte 24/7', 'API access'],
            ],
        ];

        return $plans[$this->plan] ?? $plans['basic'];
    }
}
