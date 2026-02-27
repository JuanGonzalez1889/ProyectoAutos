<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanRolPermiso extends Model
{
    use HasFactory;

    protected $table = 'plan_rol_permiso';

    protected $fillable = [
        'plan_id',
        'rol_id',
        'permiso',
        'visible',
    ];


    // No relación real con Plan, ya que es virtual (por slug)

    public function rol()
    {
        return $this->belongsTo(\Spatie\Permission\Models\Role::class, 'rol_id');
    }
}
