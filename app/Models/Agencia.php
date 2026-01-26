<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'ubicacion',
        'telefono',
    ];

    /**
     * Usuarios de esta agencia
     */
    public function users()
    {
        return $this->hasMany(User::class, 'agencia_id');
    }

    /**
     * Agencieros de esta agencia
     */
    public function agencieros()
    {
        return $this->users()->role('AGENCIERO');
    }

    /**
     * Colaboradores de esta agencia
     */
    public function colaboradores()
    {
        return $this->users()->role('COLABORADOR');
    }
}
