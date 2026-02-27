@extends('layouts.admin')
@push('styles')
<style>
    /* Achicar el logo SVG gigante en el main-content */
    #main-content svg:not(.sidebar-icon) {
        width: 80px !important;
        height: 80px !important;
        max-width: 80px !important;
        max-height: 80px !important;
        margin: 2rem auto !important;
        display: block !important;
    }

    /* Mejorar contraste de la tabla */
    .tabla-planes th {
        background: #1e3a8a !important;
        color: #fff !important;
        font-weight: bold;
        white-space: nowrap;
    }
    .tabla-planes .col-plan {
        background: #1e3a8a !important;
        color: #fff !important;
        font-weight: bold;
        white-space: nowrap;
    }
    .tabla-planes .col-rol {
        background: #2563eb !important;
        color: #fff !important;
        font-weight: bold;
        white-space: nowrap;
    }
    .tabla-planes td {
        color: #1e293b !important;
        background: #fff !important;
        border: 1px solid #cbd5e1;
        white-space: nowrap;
    }
    .tabla-planes tr:nth-child(even) td {
        background: #f1f5f9 !important;
    }
    .tabla-planes {
        width: 70vh;
        min-width: 700px;
        max-width: 700px;
        table-layout: auto;
    }
    .tabla-planes th, .tabla-planes td {
        padding: 0.5rem 0.75rem;
        font-size: 1rem;
    }
    .tabla-planes-wrapper {
        overflow-x: auto;
        width: 100%;
        max-width: 100vw;
        margin-bottom: 2rem;
    }
    .max-w-4xl {
        max-width: 100vw !important;
    }
</style>
@endpush

@section('title', 'Configuración de Visibilidad por Plan y Rol')
@section('page-title', 'Configurar visibilidad de módulos')

@section('content')
<div class="w-full p-6" style="">
    <h2 class="text-2xl font-bold mb-6">Configurar visibilidad de módulos por plan y rol</h2>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('admin.planes.configuracion.store') }}">
        @csrf
        <div class="tabla-planes-wrapper">
            <table class="tabla-planes bg-white rounded shadow">
                <thead>
                    <tr style="
    color: black;
">
                        <th class="px-4 py-2">Plan</th>
                        <th class="px-4 py-2">Rol</th>
                        @foreach($permisos as $permiso)
                            <th class="px-4 py-2">{{ $permiso }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($planes as $plan)
                        @foreach($roles as $rol)
                            <tr style="color: black;">
                                <td class="border px-4 py-2 col-plan">{{ $plan->nombre }}</td>
                                <td class="border px-4 py-2 col-rol">{{ $rol->name }}</td>
                                @foreach($permisos as $permiso)
                                    @php
                                        $asign = $asignaciones->first(fn($a) => $a->plan_id == $plan->id && $a->rol_id == $rol->id && $a->permiso == $permiso);
                                        $defaultChecked = false;
                                        $planSlug = $plan->slug;
                                        $rolName = strtoupper($rol->name);
                                        $modulo = $permiso;
                                        $defaultModulos = [
                                            'basico' => [
                                                'AGENCIERO' => [
                                                    'personalizar mi web', 'dashboard', 'inventario', 'usuarios', 'mi agencia', 'mis dominios', 'planes y facturación'
                                                ],
                                                'COLABORADOR' => [
                                                    'personalizar mi web', 'dashboard', 'inventario'
                                                ],
                                            ],
                                            'test100' => [
                                                'AGENCIERO' => [
                                                    'personalizar mi web', 'dashboard', 'inventario', 'usuarios', 'mi agencia', 'mis dominios', 'planes y facturación'
                                                ],
                                                'COLABORADOR' => [
                                                    'personalizar mi web', 'dashboard', 'inventario'
                                                ],
                                            ],
                                            'profesional' => [
                                                'AGENCIERO' => [
                                                    'personalizar mi web', 'dashboard', 'inventario', 'calendario', 'tareas', 'usuarios', 'mi agencia', 'mis dominios', 'planes y facturación'
                                                ],
                                                'COLABORADOR' => [
                                                    'personalizar mi web', 'dashboard', 'inventario', 'calendario', 'tareas'
                                                ],
                                            ],
                                            'premium' => [
                                                'AGENCIERO' => [
                                                    'personalizar mi web', 'dashboard', 'inventario', 'calendario', 'tareas', 'usuarios', 'mi agencia', 'mis dominios', 'planes y facturación', 'leads'
                                                ],
                                                'COLABORADOR' => [
                                                    'personalizar mi web', 'dashboard', 'inventario', 'calendario', 'tareas', 'leads'
                                                ],
                                            ],
                                            'premium_plus' => [
                                                'AGENCIERO' => [
                                                    'personalizar mi web', 'dashboard', 'inventario', 'calendario', 'tareas', 'usuarios', 'mi agencia', 'mis dominios', 'planes y facturación', 'leads'
                                                ],
                                                'COLABORADOR' => [
                                                    'personalizar mi web', 'dashboard', 'inventario', 'calendario', 'tareas', 'leads'
                                                ],
                                            ],
                                        ];
                                        if (!$asign) {
                                            $defaultChecked = isset($defaultModulos[$planSlug][$rolName]) && in_array($modulo, $defaultModulos[$planSlug][$rolName]);
                                        }
                                    @endphp
                                    <td class="border px-4 py-2 text-center">
                                        <input type="checkbox" name="permisos[{{ $plan->slug }}][{{ $rol->id }}][{{ $permiso }}]" value="1" {{ ($asign && $asign->visible) || $defaultChecked ? 'checked' : '' }}>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="submit" class="mt-6 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Guardar cambios</button>
    </form>
</div>
@endsection
