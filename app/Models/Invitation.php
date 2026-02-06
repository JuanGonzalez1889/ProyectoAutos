<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Invitation extends Model
{
    protected $fillable = [
        'tenant_id',
        'email',
        'token',
        'role',
        'permissions',
        'expires_at',
        'accepted_at',
        'user_id',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'permissions' => 'array',
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    /**
     * Relación: Una invitación pertenece a un tenant
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Relación: Una invitación pertenece a un usuario (cuando se acepta)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Crear una nueva invitación
     */
    public static function create_for_collaborator($tenantId, $email, $role = 'collaborator', $permissions = null)
    {
        return self::create([
            'id' => Str::uuid(),
            'tenant_id' => $tenantId,
            'email' => $email,
            'token' => Str::random(60),
            'role' => $role,
            'permissions' => $permissions,
            'expires_at' => Carbon::now()->addDays(7), // Válida por 7 días
        ]);
    }

    /**
     * Verificar si la invitación es válida
     */
    public function isValid(): bool
    {
        return !$this->isExpired() && !$this->isAccepted();
    }

    /**
     * Verificar si la invitación expiró
     */
    public function isExpired(): bool
    {
        return Carbon::now()->isAfter($this->expires_at);
    }

    /**
     * Verificar si ya fue aceptada
     */
    public function isAccepted(): bool
    {
        return $this->accepted_at !== null;
    }

    /**
     * Aceptar la invitación
     */
    public function accept(User $user): void
    {
        $this->update([
            'accepted_at' => now(),
            'user_id' => $user->id,
        ]);
    }

    /**
     * Obtener invitaciones válidas pendientes
     */
    public static function valid()
    {
        return self::whereNull('accepted_at')
            ->where('expires_at', '>', now());
    }

    /**
     * Obtener invitación por token
     */
    public static function findByToken($token)
    {
        return self::where('token', $token)->first();
    }
}
