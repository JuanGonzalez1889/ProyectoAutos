<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\BelongsToTenant;

class Vehicle extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'title',
        'brand',
        'model',
        'year',
        'price',
        'price_original',
        'description',
        'fuel_type',
        'transmission',
        'kilometers',
        'color',
        'plate',
        'features',
        'images',
        'contact_name',
        'contact_phone',
        'contact_email',
        'status',
        'featured',
        'user_id',
        'agencia_id',
    ];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'featured' => 'boolean',
        'price' => 'decimal:2',
        'price_original' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agencia(): BelongsTo
    {
        return $this->belongsTo(Agencia::class);
    }

    public function getMainImageAttribute()
    {
        return $this->images && count($this->images) > 0 
            ? $this->images[0] 
            : 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=400&h=300&fit=crop';
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
}
