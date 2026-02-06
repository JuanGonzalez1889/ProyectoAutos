@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    @if($user->avatar)
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full">
                    @else
                    <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    @endif
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $user->name }}
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $user->email }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('admin.users.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    ← Volver
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- User Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Información del Usuario
                    </h2>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                            <div class="mt-1">
                                @if($user->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100">
                                    Activo
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-100">
                                    Inactivo
                                </span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Registrado</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $user->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Roles -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Roles
                    </h2>

                    <div class="flex flex-wrap gap-2">
                        @forelse($user->roles as $role)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100">
                            {{ $role->name }}
                        </span>
                        @empty
                        <p class="text-sm text-gray-600 dark:text-gray-400">Sin roles asignados</p>
                        @endforelse
                    </div>
                </div>

                <!-- Permissions -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Permisos Directos
                    </h2>

                    @if($user->permissions->count() > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->permissions as $permission)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-100">
                            {{ $permission->name }}
                        </span>
                        @endforeach
                    </div>
                    @else
                    <p class="text-sm text-gray-600 dark:text-gray-400">Sin permisos directos asignados</p>
                    @endif
                </div>
            </div>

            <!-- Actions Sidebar -->
            <div class="space-y-4">
                @can('users.edit')
                <a href="{{ route('admin.users.edit', $user) }}" 
                   class="w-full inline-flex justify-center items-center px-4 py-3 border border-blue-600 rounded-lg text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition">
                    <i class="fas fa-edit mr-2"></i>
                    Editar Usuario
                </a>
                @endcan

                @can('users.change_permissions')
                <a href="{{ route('admin.users.permissions.edit', $user) }}" 
                   class="w-full inline-flex justify-center items-center px-4 py-3 border border-green-600 rounded-lg text-sm font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 transition">
                    <i class="fas fa-lock mr-2"></i>
                    Gestionar Permisos
                </a>
                @endcan

                @can('audit.view_logs')
                <a href="{{ route('admin.users.activity', $user) }}" 
                   class="w-full inline-flex justify-center items-center px-4 py-3 border border-purple-600 rounded-lg text-sm font-medium text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 transition">
                    <i class="fas fa-history mr-2"></i>
                    Ver Actividad
                </a>
                @endcan

                @can('users.edit')
                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="w-full inline-flex justify-center items-center px-4 py-3 border border-orange-600 rounded-lg text-sm font-medium text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/20 hover:bg-orange-100 dark:hover:bg-orange-900/30 transition">
                        @if($user->is_active)
                        <i class="fas fa-pause mr-2"></i>
                        Desactivar
                        @else
                        <i class="fas fa-play mr-2"></i>
                        Activar
                        @endif
                    </button>
                </form>
                @endcan

                @can('users.delete')
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                      onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full inline-flex justify-center items-center px-4 py-3 border border-red-600 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 transition">
                        <i class="fas fa-trash mr-2"></i>
                        Eliminar Usuario
                    </button>
                </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
