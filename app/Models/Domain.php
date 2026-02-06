<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Database\Models\Domain as BaseDomain;

class Domain extends BaseDomain
{
    use HasFactory;
    
    protected $fillable = [
        'domain',
        'tenant_id',
        'type',
        'is_active',
        'registration_status',
        'dns_configured',
        'ssl_verified',
        'metadata',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'dns_configured' => 'boolean',
        'ssl_verified' => 'boolean',
        'metadata' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Domain belongs to Tenant
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get domain status badge
     */
    public function getStatusBadgeAttribute(): string
    {
        if (!$this->is_active) {
            return 'inactive';
        }

        if ($this->registration_status === 'available') {
            return 'available';
        }

        if (!$this->dns_configured) {
            return 'dns_pending';
        }

        if (!$this->ssl_verified) {
            return 'ssl_pending';
        }

        return 'active';
    }

    /**
     * Check if domain is fully configured
     */
    public function isFullyConfigured(): bool
    {
        return $this->is_active
            && $this->registration_status === 'registered'
            && $this->dns_configured
            && $this->ssl_verified;
    }

    /**
     * Get next configuration step
     */
    public function getNextConfigurationStep(): ?string
    {
        if ($this->registration_status !== 'registered') {
            return 'register_domain';
        }

        if (!$this->dns_configured) {
            return 'configure_dns';
        }

        if (!$this->ssl_verified) {
            return 'verify_ssl';
        }

        return null;
    }
}
