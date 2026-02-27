<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlanRolPermiso;
use App\Models\Plan;
use Spatie\Permission\Models\Role;

class PlanRolPermisoController extends Controller
{
    public function index()
    {
        $planes = Plan::all();
        $roles = Role::all();
        $permisos = config('permisos.modulos'); // Definir en config/permisos.php
        $asignaciones = PlanRolPermiso::all();
        return view('admin.planes.configuracion', compact('planes', 'roles', 'permisos', 'asignaciones'));
    }

    public function store(Request $request)
    {
        $permisos = $request->input('permisos', []);
        $planes = Plan::all();
        $roles = \Spatie\Permission\Models\Role::all();
        $modulos = config('permisos.modulos');

        foreach ($planes as $plan) {
            foreach ($roles as $rol) {
                foreach ($modulos as $modulo) {
                    $visible = isset($permisos[$plan->slug][$rol->id][$modulo]) ? true : false;
                    PlanRolPermiso::updateOrCreate(
                        [
                            'plan_id' => $plan->id, // Usar el ID numérico
                            'rol_id' => $rol->id,
                            'permiso' => $modulo,
                        ],
                        ['visible' => $visible]
                    );
                }
            }
        }
        return back()->with('success', 'Permisos actualizados correctamente');
    }
}
