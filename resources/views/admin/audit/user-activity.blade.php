@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Actividad del Usuario
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
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                No hay actividades registradas para este usuario
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
