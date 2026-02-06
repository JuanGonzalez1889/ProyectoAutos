<!DOCTYPE html>
<html lang="es" style="font-size: 140%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[hsl(var(--background))]">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="fixed left-0 top-0 h-full w-64 bg-[hsl(var(--card))] border-r border-[hsl(var(--border))] p-6 flex flex-col z-50">
            <!-- Logo -->
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-[hsl(var(--primary))] rounded flex items-center justify-center">
                        <span class="text-white font-bold text-sm">A</span>
                    </div>
                    <span class="text-[hsl(var(--foreground))] font-semibold text-lg">{{ config('app.name') }}</span>
                </div>
                <p class="text-xs text-[hsl(var(--muted-foreground))]">
                    @if(auth()->user()->isAdmin())
                        Dashboard de Administrador
                    @elseif(auth()->user()->isAgenciero())
                        Dashboard de Agenciero
                    @else
                        Dashboard de Colaborador
                    @endif
                </p>
            </div>

            <!-- User Info -->
            <div class="mb-6 p-3 bg-[hsl(var(--secondary))]/50 rounded-lg">
                <div class="flex items-center gap-3 mb-3">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" class="w-10 h-10 rounded-full" alt="Avatar">
                    @else
                        <div class="w-10 h-10 rounded-full bg-[hsl(var(--primary))] flex items-center justify-center">
                            <span class="text-white font-bold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-[hsl(var(--foreground))] truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-[hsl(var(--muted-foreground))] truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                
                <div class="px-3 py-2 bg-transparent border border-[hsl(var(--border))] rounded-lg">
                    <span class="text-xs text-[hsl(var(--foreground))]">{{ auth()->user()->roles->first()->name ?? 'Sin rol' }}</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 space-y-1">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                @if(auth()->user()->isColaborador())
                <!-- Menú para Colaborador -->
                <a href="{{ route('tasks.index') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.tasks.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="flex-1">Mis Tareas</span>
                    @php
                        $pendingTasksCount = \App\Models\Task::where('user_id', auth()->id())
                            ->whereIn('status', ['todo', 'in_progress'])
                            ->count();
                    @endphp
                    @if($pendingTasksCount > 0)
                    <span class="px-1.5 py-0.5 text-[10px] font-medium rounded-full bg-green-500/20 text-green-500">{{ $pendingTasksCount }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.events.calendar') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.events.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="flex-1">Calendario</span>
                    @php
                        $todayEventsCount = \App\Models\Event::where('agencia_id', auth()->user()->agencia_id)
                            ->whereDate('start_time', today())
                            ->count();
                    @endphp
                    @if($todayEventsCount > 0)
                    <span class="px-1.5 py-0.5 text-[10px] font-medium rounded-full bg-orange-500/20 text-orange-500">{{ $todayEventsCount }}</span>
                    @endif
                </a>
                @endif

                <!-- Inventario - Todos los usuarios -->
                <a href="{{ route('admin.vehicles.index') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.vehicles.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]' }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"></path>
                        <circle cx="7" cy="17" r="2"></circle>
                        <circle cx="17" cy="17" r="2"></circle>
                    </svg>
                    Inventario
                </a>

                <!-- Calendario - Todos los usuarios autenticados -->
                <a href="{{ route('admin.events.calendar') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.events.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="flex-1">Calendario</span>
                    @php
                        $todayEventsCount = \App\Models\Event::where('agencia_id', auth()->user()->agencia_id)
                            ->whereDate('start_time', today())
                            ->count();
                    @endphp
                    @if($todayEventsCount > 0)
                    <span class="px-1.5 py-0.5 text-[10px] font-medium rounded-full bg-orange-500/20 text-orange-500">{{ $todayEventsCount }}</span>
                    @endif
                </a>

                @if(auth()->user()->isColaborador())
                <a href="#" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Clientes
                </a>
                @endif

                @can('users.view')
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Usuarios
                </a>
                @endcan

                @can('audit.view_logs')
                <a href="{{ route('admin.audit.activity-logs') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.audit.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Auditoría
                </a>
                @endcan

                @if(auth()->user()->isAgenciero())
                <a href="{{ route('admin.agencia.show') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.agencia.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Mi Agencia
                </a>

                <a href="{{ route('admin.landing-template.select') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('landing-template.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a2 2 0 012-2h6a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 7h6"></path>
                    </svg>
                    Plantillas
                </a>

                <a href="{{ route('admin.landing-config.show') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('landing-config.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                    </svg>
                    Configurar Landing
                </a>

                <a href="{{ route('admin.domains.index') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.domains.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                    </svg>
                    Mis Dominios
                </a>

                <a href="{{ route('subscriptions.index') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('subscriptions.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="flex-1">Planes y Facturación</span>
                </a>

                @if(auth()->user()->isAgenciero())
                <a href="{{ route('admin.agencia.advanced-settings.show') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.agencia.advanced-settings*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    </svg>
                    <span class="flex-1">Configuración Avanzada</span>
                </a>
                @endif
                @endif

                @if(auth()->user()->isAdmin())
                <div class="pt-4 mt-4 border-t border-[hsl(var(--border))]">
                    <p class="px-3 mb-2 text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase">Configuración SaaS</p>
                     <a href="{{ route('admin.tenants.index') }}" 
                         class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.tenants.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                        Multi-Tenancy
                    </a>
                </div>
                @endif
            </nav>

            <!-- Botón Nuevo Lead (solo para Colaborador) -->
            @if(auth()->user()->isColaborador())
            <div class="pb-4">
                <a href="{{ route('admin.leads.create') }}" class="w-full h-11 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-semibold text-sm transition-opacity flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nuevo Lead
                </a>
            </div>
            @endif

            <!-- Logout -->
            <div class="pt-4 border-t border-[hsl(var(--border))]">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-sm text-[hsl(var(--muted-foreground))] hover:text-[hsl(var(--foreground))] hover:bg-[hsl(var(--secondary))] rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="ml-64 flex-1" style="zoom: 1.15;">
            <!-- Top Bar -->
            <header class="bg-[hsl(var(--card))] border-b border-[hsl(var(--border))] h-16 flex items-center justify-between px-8 sticky top-0 z-40">
                <h2 class="text-xl font-semibold text-[hsl(var(--foreground))]">@yield('page-title', 'Dashboard')</h2>
                
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-[hsl(var(--muted-foreground))]">{{ (string) now() }}</span>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-500/20 border border-green-500/50 text-green-500 px-4 py-3 rounded-lg relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-500/20 border border-red-500/50 text-red-500 px-4 py-3 rounded-lg relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-500/20 border border-red-500/50 text-red-500 px-4 py-3 rounded-lg relative" role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
