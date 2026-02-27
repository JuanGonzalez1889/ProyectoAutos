<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plans';
    protected $fillable = [
        'nombre', 'slug', 'price', 'features', 'activo'
    ];

    // Si necesitas métodos utilitarios, agrégalos aquí
}
