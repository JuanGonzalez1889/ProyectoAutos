@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Gestionar Permisos
                    </h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Usuario: <span class="font-semibold">{{ $user->name }}</span>
                    </p>
                </div>
                <a href="{{ route('admin.users.show', $user) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    ← Volver
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form action="{{ route('admin.users.permissions.update', $user) }}" method="POST" class="space-y-8">
            @csrf
            @method('PATCH')

            <!-- Roles Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Roles del Sistema
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    Asigna los roles que determinarán el nivel de acceso de este usuario.
                </p>

                <div class="space-y-3">
                    @foreach ($availableRoles as $role)
                    <label class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition">
                        <input type="checkbox" 
                               name="roles[]" 
                               value="{{ $role->name }}"
                               @checked(in_array($role->name, $userRoles))
                               class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                        <span class="ml-3 flex-1">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $role->name }}</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Acceso: {{ match($role->name) {
                                    'ADMIN' => 'Total - Todas las funciones',
                                    'AGENCIERO' => 'Gerencia - Completa control de agencia',
                                    'COLABORADOR' => 'Básico - Acceso limitado',
                                    default => 'Personalizado'
                                } }}
                            </p>
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Permissions by Module -->
            <div class="space-y-6">
                @foreach ($permissions as $module => $modulePermissions)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4 capitalize">
                        {{ $module === 'audit' ? 'Auditoría' : 
                           $module === 'users' ? 'Usuarios' :
                           $module === 'vehicles' ? 'Vehículos' :
                           $module === 'leads' ? 'Leads' :
                           $module === 'tasks' ? 'Tareas' :
                           $module === 'events' ? 'Eventos' :
                           $module === 'settings' ? 'Configuración' :
                           $module === 'reports' ? 'Reportes' :
                           $module }}
                    </h3>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach ($modulePermissions as $permission)
                        <label class="flex items-center p-2 border border-gray-200 dark:border-gray-700 rounded hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition">
                            <input type="checkbox" 
                                   name="permissions[]" 
                                   value="{{ $permission->name }}"
                                   @checked(in_array($permission->name, $userPermissions))
                                   class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300 capitalize">
                                {{ explode('.', $permission->name)[1] }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="flex-1 inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition">
                    <i class="fas fa-check mr-2"></i>
                    Guardar Permisos
                </button>
                <a href="{{ route('admin.users.show', $user) }}" 
                   class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-base font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
