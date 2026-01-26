<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'tenant_id',
        'name',
        'email',
        'phone',
        'status',
        'source',
        'notes',
        'vehicle_id',
        'user_id',
        'agencia_id',
        'contacted_at',
        'next_follow_up',
        'budget',
    ];

    protected $casts = [
        'contacted_at' => 'datetime',
        'next_follow_up' => 'datetime',
        'budget' => 'decimal:2',
    ];

    // Scopes
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['new', 'contacted', 'interested', 'negotiating']);
    }

    public function scopeWon($query)
    {
        return $query->where('status', 'won');
    }

    public function scopeLost($query)
    {
        return $query->where('status', 'lost');
    }

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agencia()
    {
        return $this->belongsTo(Agencia::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Helpers
    public function getStatusBadgeColor(): string
    {
        return match($this->status) {
            'new' => 'blue',
            'contacted' => 'yellow',
            'interested' => 'green',
            'negotiating' => 'purple',
            'won' => 'emerald',
            'lost' => 'red',
            default => 'gray',
        };
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            'new' => 'Nuevo',
            'contacted' => 'Contactado',
            'interested' => 'Interesado',
            'negotiating' => 'Negociando',
            'won' => 'Ganado',
            'lost' => 'Perdido',
            default => $this->status,
        };
    }
}
