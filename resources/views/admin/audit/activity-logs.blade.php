@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Registro de Actividades
                    </h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Auditoría de todas las acciones en el sistema
                    </p>
                </div>
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    ← Volver
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Usuario
                    </label>
                    <select name="user_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos los usuarios</option>
                        @foreach(\App\Models\User::where('tenant_id', auth()->user()->tenant_id)->orderBy('name')->get() as $user)
                        <option value="{{ $user->id }}" @selected(request('user_id') == $user->id)>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Módulo
                    </label>
                    <select name="module" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos los módulos</option>
                        <option value="vehicles" @selected(request('module') == 'vehicles')>Vehículos</option>
                        <option value="leads" @selected(request('module') == 'leads')>Leads</option>
                        <option value="tasks" @selected(request('module') == 'tasks')>Tareas</option>
                        <option value="events" @selected(request('module') == 'events')>Eventos</option>
                        <option value="users" @selected(request('module') == 'users')>Usuarios</option>
                        <option value="settings" @selected(request('module') == 'settings')>Configuración</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Acción
                    </label>
                    <select name="action" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">Todas las acciones</option>
                        <option value="view" @selected(request('action') == 'view')>Ver</option>
                        <option value="create" @selected(request('action') == 'create')>Crear</option>
                        <option value="edit" @selected(request('action') == 'edit')>Editar</option>
                        <option value="delete" @selected(request('action') == 'delete')>Eliminar</option>
                        <option value="login" @selected(request('action') == 'login')>Login</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        Filtrar
                    </button>
                    <a href="{{ route('admin.audit.activity-logs') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        <!-- Activity Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Fecha
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Usuario
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Módulo
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Acción
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Descripción
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Estado
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($activities as $activity)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $activity->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                @if ($activity->user)
                                    <div class="flex items-center">
                                        <span class="text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100 px-2.5 py-0.5 rounded-full">
                                            {{ $activity->user->name }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-100 capitalize">
                                    {{ match($activity->module) {
                                        'vehicles' => 'Vehículos',
                                        'leads' => 'Leads',
                                        'tasks' => 'Tareas',
                                        'events' => 'Eventos',
                                        'users' => 'Usuarios',
                                        'settings' => 'Configuración',
                                        default => $activity->module
                                    } }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                                    @if($activity->action === 'create')
                                        bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100
                                    @elseif($activity->action === 'edit')
                                        bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-100
                                    @elseif($activity->action === 'delete')
                                        bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-100
                                    @else
                                        bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100
                                    @endif
                                ">
                                    {{ $activity->action }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                {{ $activity->description ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($activity->status === 'success')
                                        bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100
                                    @else
                                        bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-100
                                    @endif
                                ">
                                    {{ $activity->status === 'success' ? 'Exitoso' : 'Error' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                No hay actividades registradas
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($activities->hasPages())
            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                {{ $activities->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
