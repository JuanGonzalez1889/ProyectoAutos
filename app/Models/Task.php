<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Task extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'user_id',
        'agencia_id',
        'related_to',
        'related_id',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agencia()
    {
        return $this->belongsTo(Agencia::class);
    }

    public function scopePendiente($query)
    {
        return $query->where('status', 'pendiente');
    }

    public function scopeCompleto($query)
    {
        return $query->where('status', 'completo');
    }

    public function scopeCancelado($query)
    {
        return $query->where('status', 'cancelado');
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }
}
