@extends('layouts.admin')

@section('title', 'Usuarios')
@section('page-title', 'Gestión de Usuarios')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-semibold text-white mb-1">Lista de Usuarios</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Administra usuarios, roles y permisos del sistema</p>
        </div>
        
        @can('users.create')
        <a href="{{ route('admin.users.create') }}" 
           class="h-10 px-5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Crear Usuario
        </a>
        @endcan
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="p-4 bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500/20 rounded-lg">
                    <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Total Usuarios</p>
                    <p class="text-2xl font-bold text-white">{{ $users->total() }}</p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-green-500/20 rounded-lg">
                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Activos</p>
                    <p class="text-2xl font-bold text-green-500">{{ $users->where('is_active', true)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-purple-500/20 rounded-lg">
                    <svg class="h-5 w-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Administradores</p>
                    <p class="text-2xl font-bold text-purple-500">{{ $users->filter(fn($u) => $u->roles->contains('name', 'ADMIN'))->count() }}</p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-gradient-to-br from-yellow-500/10 to-yellow-600/10 border border-yellow-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-yellow-500/20 rounded-lg">
                    <svg class="h-5 w-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Agencieros</p>
                    <p class="text-2xl font-bold text-yellow-500">{{ $users->filter(fn($u) => $u->roles->contains('name', 'AGENCIERO'))->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Usuarios -->
    <div class="card">
        <!-- Barra de búsqueda y filtros -->
        <div class="flex items-center justify-between mb-6 gap-4">
            <div class="relative flex-1 max-w-md">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-[hsl(var(--muted-foreground))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" placeholder="Buscar por nombre, email o rol..." 
                       class="w-full h-10 pl-10 pr-4 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
            </div>
            
            @if(auth()->user()->isAdmin())
            <!-- Filtro por Agencia (solo ADMIN) -->
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center gap-2">
                <select name="agencia_id" onchange="this.form.submit()"
                        class="h-10 px-4 bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                    <option value="">Todas las agencias</option>
                    <option value="sin_agencia" {{ request('agencia_id') === 'sin_agencia' ? 'selected' : '' }}>Sin agencia</option>
                    @foreach($agencias as $agencia)
                        <option value="{{ $agencia->id }}" {{ request('agencia_id') == $agencia->id ? 'selected' : '' }}>
                            {{ $agencia->nombre }}
                        </option>
                    @endforeach
                </select>
                @if(request('agencia_id'))
                    <a href="{{ route('admin.users.index') }}" 
                       class="h-10 px-4 bg-red-500/20 hover:bg-red-500/30 text-red-500 rounded-lg text-sm font-medium transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Limpiar
                    </a>
                @endif
            </form>
            @endif
            
            <div class="flex items-center gap-2">
                <button class="h-10 px-4 bg-[hsl(var(--card))] hover:bg-[hsl(var(--muted))] border border-[hsl(var(--border))] rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filtros
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-xs text-[hsl(var(--muted-foreground))] border-b border-[hsl(var(--border))]">
                    <tr>
                        <th class="text-left pb-3 font-medium">USUARIO</th>
                        <th class="text-left pb-3 font-medium">EMAIL</th>
                        <th class="text-left pb-3 font-medium">ROL</th>
                        <th class="text-left pb-3 font-medium">AGENCIA</th>
                        <th class="text-left pb-3 font-medium">ESTADO</th>
                        <th class="text-left pb-3 font-medium">REGISTRO</th>
                        <th class="text-right pb-3 font-medium">ACCIONES</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($users as $user)
                    <tr class="border-b border-[hsl(var(--border))] hover:bg-[hsl(var(--muted))]/50 transition-colors">
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                @if($user->avatar)
                                    <img class="h-10 w-10 rounded-full" src="{{ $user->avatar }}" alt="">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ route('admin.users.show', $user) }}" 
                                       class="font-medium text-white hover:underline">{{ $user->name }}</a>
                                    @if($user->google_id)
                                        <span class="text-xs text-[hsl(var(--muted-foreground))] flex items-center gap-1 mt-0.5">
                                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                            </svg>
                                            Google
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-4 text-[hsl(var(--muted-foreground))]">
                            {{ $user->email }}
                        </td>
                        <td class="py-4">
                            @foreach($user->roles as $role)
                                <span class="px-2 py-1 text-xs font-medium rounded
                                    @if($role->name === 'ADMIN') bg-purple-500/20 text-purple-600
                                    @elseif($role->name === 'AGENCIERO') bg-green-500/20 text-green-600
                                    @else bg-yellow-500/20 text-yellow-600
                                    @endif">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </td>
                        <td class="py-4 text-[hsl(var(--muted-foreground))]">
                            @if($user->agencia)
                                <span class="px-2 py-1 text-xs font-medium rounded bg-blue-500/20 text-blue-600">
                                    {{ $user->agencia->nombre }}
                                </span>
                            @else
                                <span class="text-xs text-[hsl(var(--muted-foreground))]">Sin agencia</span>
                            @endif
                        </td>
                        <td class="py-4">
                            @if($user->is_active)
                                <span class="px-2 py-1 text-xs font-medium rounded bg-green-500/20 text-green-600">
                                    Activo
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded bg-red-500/20 text-red-600">
                                    Inactivo
                                </span>
                            @endif
                        </td>
                        <td class="py-4 text-[hsl(var(--muted-foreground))]">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                        <td class="py-4">
                            <div class="flex justify-end">
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false"
                                            class="p-2 hover:bg-[hsl(var(--muted))] rounded-lg transition-colors">
                                        <svg class="w-5 h-5 text-[hsl(var(--muted-foreground))]" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                                        </svg>
                                    </button>
                                    
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="absolute right-0 mt-2 w-48 bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg shadow-lg z-50"
                                         style="display: none;">
                                        <div class="py-1">
                                            @can('users.edit')
                                            <a href="{{ route('admin.users.edit', $user) }}" 
                                               class="flex items-center gap-2 px-4 py-2 text-sm text-[hsl(var(--foreground))] hover:bg-[hsl(var(--muted))] transition-colors">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Editar
                                            </a>
                                            @endcan

                                            @can('users.change_permissions')
                                            <a href="{{ route('admin.users.permissions.edit', $user) }}" 
                                               class="flex items-center gap-2 px-4 py-2 text-sm text-[hsl(var(--foreground))] hover:bg-[hsl(var(--muted))] transition-colors">
                                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Permisos
                                            </a>
                                            @endcan

                                            @can('audit.view_logs')
                                            <a href="{{ route('admin.users.activity', $user) }}" 
                                               class="flex items-center gap-2 px-4 py-2 text-sm text-[hsl(var(--foreground))] hover:bg-[hsl(var(--muted))] transition-colors">
                                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Actividad
                                            </a>
                                            @endcan

                                            @can('users.edit')
                                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-[hsl(var(--foreground))] hover:bg-[hsl(var(--muted))] transition-colors text-left">
                                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        @if($user->is_active)
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                        @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        @endif
                                                    </svg>
                                                    {{ $user->is_active ? 'Desactivar' : 'Activar' }}
                                                </button>
                                            </form>
                                            @endcan

                                            @can('users.delete')
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-500 hover:bg-[hsl(var(--muted))] transition-colors text-left">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Eliminar
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-[hsl(var(--muted-foreground))]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p class="mt-4 text-[hsl(var(--muted-foreground))]">No hay usuarios registrados</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="mt-6 pt-4 border-t border-[hsl(var(--border))]">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
