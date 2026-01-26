<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Event extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'title',
        'description',
        'type',
        'start_time',
        'end_time',
        'location',
        'user_id',
        'agencia_id',
        'client_name',
        'client_phone',
        'related_to',
        'related_id',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agencia()
    {
        return $this->belongsTo(Agencia::class);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('start_time', today());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>=', now())->orderBy('start_time');
    }
}
