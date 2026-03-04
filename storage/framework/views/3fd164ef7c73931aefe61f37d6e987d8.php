                <?php
                ?>
                <?php if(canSeeMenu('planes por rol')): ?>
                <div class="flex flex-col items-center justify-center py-6">
                    <a href="<?php echo e(route('admin.planes.configuracion')); ?>"
                        class="flex flex-col items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('planes.configuracion') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]'); ?>">
                        <svg class="sidebar-icon mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:32px;height:32px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6" />
                        </svg>
                        <span class="sidebar-label text-center">Planes por Rol</span>
                    </a>
                </div>
                <?php endif; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <style>
        /* Sidebar collapsed: solo íconos visibles, íconos centrados y tamaño normal */
        #sidebar {
            width: 16rem;
            min-width: 4rem;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #sidebar.collapsed {
            width: 4rem !important;
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }

        #sidebar .sidebar-label,
        #sidebar .sidebar-logo,
        #sidebar .sidebar-user,
        #sidebar .sidebar-role,
        #sidebar .sidebar-extra {
            transition: opacity 0.2s;
        }

        #sidebar.collapsed .sidebar-label,
        #sidebar.collapsed .sidebar-user-info,
        #sidebar.collapsed .sidebar-role,
        #sidebar.collapsed .sidebar-extra {
            opacity: 0;
            pointer-events: none;
            width: 0;
            height: 0;
            overflow: hidden;
        }

        #sidebar.collapsed .sidebar-user-icon {
            display: flex !important;
            align-items: center;
            justify-content: center;
            width: 1.8rem;
            height: 1.8rem;
            font-size: 2rem;
            margin: 0 auto;
        }

        /* Mantener espacio del logo aunque esté oculto */
        #sidebar.collapsed .sidebar-logo {
            visibility: hidden;
            height: 56px;
            /* igual a la altura original del logo/nombre */
            margin-bottom: 2rem;
        }

        #sidebar .sidebar-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            min-width: 1.3rem;
            min-height: 1.3rem;
            width: 1.3rem;
            height: 1.3rem;
            margin-right: 0.75rem;
            transition: font-size 0.2s, width 0.2s, height 0.2s;
        }

        #sidebar.collapsed .sidebar-icon {
            margin: 0 auto !important;
            min-width: 1.5rem;
            min-height: 1.5rem;
            width: 1.5rem;
            height: 1.5rem;
            font-size: 1.5rem;
        }

        #sidebar .sidebar-logout-label {
            display: inline;
        }

        #sidebar.collapsed .sidebar-logout-label {
            display: none !important;
        }

        #main-content {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-left: 16rem;
        }

        #sidebar.collapsed~#main-content {
            margin-left: 4rem !important;
        }

        @media (max-width: 768px) {
            #main-content {
                margin-left: 0 !important;
            }

            #sidebar {
                /* position: absolute;
                z-index: 50;
                height: 100vh !important;
                min-height: 100vh !important;
                max-height: 100vh !important;
                top: 0;
                left: 0; */
            }
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/storage/icono.png">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> - <?php echo e(config('app.name')); ?></title>


    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="bg-[hsl(var(--background))]">
    <?php
        $isSuperAdmin = auth()->check() && in_array(auth()->user()->email, ['superadmin@autos.com', 'admin@autowebpro.com.ar']);
    ?>
    <?php echo $__env->make('components.plan-overlay', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed left-0 top-0 h-full bg-[hsl(var(--card))] border-r border-[hsl(var(--border))] p-6 flex flex-col z-50 transition-all duration-300">
            <!-- Botón Flecha Sidebar -->
            <button id="sidebar-toggle" aria-label="Contraer menú"
                class="absolute -right-4 top-6 w-8 h-8 bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-full shadow flex items-center justify-center z-50 transition-transform duration-300 focus:outline-none">
                <svg id="sidebar-arrow" class="w-6 h-6 text-[hsl(var(--foreground))] transition-transform duration-300"
                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <!-- Logo y nombre -->
            <div class="mb-8 sidebar-logo" style="height:56px;">
                <div class="flex items-center gap-2 mb-2" style="
    margin-top: 2rem;
">
                    <img src="<?php echo e(asset('storage/icono.png')); ?>" class="w-12 h-12 rounded" style="max-width:48px; max-height:48px; width:48px; height:48px;" alt="Logo">
                    <span class="text-[hsl(var(--foreground))] font-semibold text-lg">AutoWebPRO</span>
                </div>
                <p class="text-xs text-[hsl(var(--muted-foreground))]">
                    
                </p>
            </div>

            <!-- User Info -->
            <div class="mb-6 p-3 bg-[hsl(var(--secondary))]/50 rounded-lg sidebar-user" style="
    margin-bottom: -22px;
">
                <div class="flex items-center gap-3 mb-3">
                    <?php if(auth()->user()->avatar): ?>
                        <img src="<?php echo e(auth()->user()->avatar); ?>" class="sidebar-user-icon w-10 h-10 rounded-full"
                            alt="Avatar">
                    <?php else: ?>
                        <div
                            class="sidebar-user-icon w-10 h-10 rounded-full bg-[hsl(var(--primary))] flex items-center justify-center" style="aspect-ratio: 1/1;">
                            <span class="text-white font-bold text-sm" style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%;"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="flex-1 min-w-0 sidebar-user-info">
                        <p class="text-sm font-medium text-[hsl(var(--foreground))] truncate"><?php echo e(auth()->user()->name); ?>

                        </p>
                        <p class="text-xs text-[hsl(var(--muted-foreground))] truncate"><?php echo e(auth()->user()->email); ?></p>
                    </div>
                </div>
                <div class="px-3 py-2 bg-transparent border border-[hsl(var(--border))] rounded-lg sidebar-role">
                    <span
                        class="text-xs text-[hsl(var(--foreground))]"><?php echo e(auth()->user()->roles->first()->name ?? 'Sin rol'); ?></span>
                </div>
            </div>

            <!-- Navigation -->
            <?php \Log::channel('single')->info('[sidebar-blade]', ['user_id' => auth()->user()->id ?? null, 'email' => auth()->user()->email ?? null]); ?>
            <nav class="flex-1 flex flex-col justify-start pt-6 space-y-1" style="
    margin-top: 1rem;
">
                <?php if(canSeeMenu('personalizar mi web')): ?>
                <a href="<?php echo e(route('admin.landing-template.select')); ?>"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('landing-template.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]'); ?>">
                        <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 5a2 2 0 012-2h6a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 7h6"></path>
                        </svg>
                        <span class="sidebar-label">Personalizar Mi Web</span>
                </a>
                <?php endif; ?>

                <?php if(canSeeMenu('dashboard')): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]'); ?>">
                        <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="sidebar-label">Dashboard</span>
                </a>
                <?php endif; ?>

                <?php if(canSeeMenu('tareas')): ?>
                    <a href="<?php echo e(route('admin.tasks.list')); ?>"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('admin.tasks.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]'); ?>">
                                <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="flex-1">Mis Tareas</span>
                            <?php
                                $pendingTasksCount = \App\Models\Task::where('user_id', auth()->id())
                                    ->whereIn('status', ['todo', 'in_progress'])
                                    ->count();
                            ?>
                            <?php if($pendingTasksCount > 0): ?>
                                <span
                                    class="px-1.5 py-0.5 text-[10px] font-medium rounded-full bg-green-500/20 text-green-500"><?php echo e($pendingTasksCount); ?></span>
                            <?php endif; ?>
                        </a>
                        <?php endif; ?>

                    

                <!-- Inventario - Todos los usuarios -->
                <?php if(canSeeMenu('inventario')): ?>
                <a href="<?php echo e(route('admin.vehicles.index')); ?>"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('admin.vehicles.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]'); ?>">
                    <svg class="sidebar-icon" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2">
                        </path>
                        <circle cx="7" cy="17" r="2"></circle>
                        <circle cx="17" cy="17" r="2"></circle>
                    </svg>
                    <span class="sidebar-label flex-1">Inventario</span>
                </a>
                <?php endif; ?>


                <?php if(canSeeMenu('calendario')): ?>
                <a href="<?php echo e(route('admin.events.calendar')); ?>"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('admin.events.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]'); ?>">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="sidebar-label flex-1">Calendario</span>
                    <?php
                        $todayEventsCount = \App\Models\Event::where('agencia_id', auth()->user()->agencia_id)
                            ->whereDate('start_time', today())
                            ->count();
                    ?>
                    <?php if($todayEventsCount > 0): ?>
                        <span
                            class="px-1.5 py-0.5 text-[10px] font-medium rounded-full bg-orange-500/20 text-orange-500"><?php echo e($todayEventsCount); ?></span>
                    <?php endif; ?>
                </a>
                <?php endif; ?>

                <?php if(canSeeMenu('clientes')): ?>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]">
                        <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span class="sidebar-label flex-1">Clientes</span>
                    </a>
                <?php endif; ?>

                <?php if(canSeeMenu('usuarios')): ?>
                    <a href="<?php echo e(route('admin.users.index')); ?>"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('admin.users.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]'); ?>">
                        <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span class="sidebar-label flex-1">Usuarios</span>
                    </a>
                <?php endif; ?>

                <?php if(canSeeMenu('auditoria')): ?>
                    <a href="<?php echo e(route('admin.audit.activity-logs')); ?>"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('admin.audit.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]'); ?>">
                        <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <span class="sidebar-label flex-1">Auditoría</span>
                    </a>
                <?php endif; ?>

                
                <?php if(canSeeMenu('mi agencia')): ?>
                    <a href="<?php echo e(route('admin.agencia.show')); ?>"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('admin.agencia.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]'); ?>">
                        <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <span class="sidebar-label flex-1">Mi Agencia</span>
                    </a>
                <?php endif; ?>
                
                
                <?php if(canSeeMenu('mis dominios')): ?>
                    <a href="<?php echo e(route('admin.domains.index')); ?>"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('admin.domains.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]'); ?>">
                        <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                            </path>
                        </svg>
                        <span class="sidebar-label flex-1">Mis Dominios</span>
                    </a>
                <?php endif; ?>
                <!-- Instructivos -->
                <a href="<?php echo e(route('admin.instructivos')); ?>"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('admin.instructivos') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]'); ?>">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="sidebar-label flex-1">Instructivos</span>
                </a>

                <?php if(canSeeMenu('planes y facturacion')): ?>
                    <a href="<?php echo e(route('subscriptions.index')); ?>"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('subscriptions.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]'); ?>">
                        <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="sidebar-label flex-1">Planes y Facturación</span>
                    </a>
                <?php endif; ?>

                <?php if(canSeeMenu('multi-tenancy')): ?>
                    <div class="pt-4 mt-4 border-t border-[hsl(var(--border))]">
                        <p class="px-3 mb-2 text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase">
                            Configuración SaaS</p>
                        <a href="<?php echo e(route('admin.tenants.index')); ?>"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('admin.tenants.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]'); ?>">
                            <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                </path>
                            </svg>
                            Multi-Tenancy
                        </a>
                    </div>
                <?php endif; ?>
            </nav>

            <!-- Botón Nuevo Lead (solo para Colaborador) -->
            <?php if(canSeeMenu('nuevo lead')): ?>
                <div class="pb-4">
                    <a href="<?php echo e(route('admin.leads.create')); ?>"
                        class="w-full h-11 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-semibold text-sm transition-opacity flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                        </svg>
                        Nuevo Lead
                    </a>
                </div>
            <?php endif; ?>
            <?php if(canSeeMenu('leads')): ?>
                <a href="<?php echo e(route('admin.leads.index')); ?>"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors <?php echo e(request()->routeIs('admin.leads.*') ? 'bg-[hsl(var(--primary))] text-white' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--secondary))] hover:text-[hsl(var(--foreground))]'); ?>">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="sidebar-label flex-1">Leads</span>
                </a>
            <?php endif; ?>

            <!-- Impersonate Leave (solo si está impersonando) -->
            <?php if(auth()->check() && session('impersonate_original_id')): ?>
                <a href="<?php echo e(route('impersonate.leave')); ?>"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm bg-yellow-500 text-white font-bold mb-2 hover:bg-yellow-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    Salir de impersonate
                </a>
            <?php endif; ?>
            <!-- Logout -->
            <div class="pt-4 border-t border-[hsl(var(--border))]">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2 text-sm text-[hsl(var(--muted-foreground))] hover:text-[hsl(var(--foreground))] hover:bg-[hsl(var(--secondary))] rounded-lg transition-colors">
                        <svg class="sidebar-icon w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <span class="sidebar-logout-label">Cerrar sesión</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div id="main-content" class="flex-1 transition-all duration-300">
            <!-- Top Bar -->
            <header
                class="bg-[hsl(var(--card))] border-b border-[hsl(var(--border))] h-16 flex items-center justify-between px-8 sticky top-0 z-40">
                <h2 class="text-xl font-semibold text-[hsl(var(--foreground))]"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h2>

                <div class="flex items-center space-x-4">
                    <span class="text-sm text-[hsl(var(--muted-foreground))]"><?php echo e((string) now()); ?></span>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6  mx-auto w-full">
                <?php if(session('success')): ?>
                    <div class="mb-4 bg-green-500/20 border border-green-500/50 text-green-500 px-4 py-3 rounded-lg relative"
                        role="alert">
                        <span class="block sm:inline"><?php echo e(session('success')); ?></span>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="mb-4 bg-red-500/20 border border-red-500/50 text-red-500 px-4 py-3 rounded-lg relative"
                        role="alert">
                        <span class="block sm:inline"><?php echo e(session('error')); ?></span>
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="mb-4 bg-red-500/20 border border-red-500/50 text-red-500 px-4 py-3 rounded-lg relative"
                        role="alert">
                        <ul class="list-disc list-inside">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
    <script>
        // Sidebar toggle logic con persistencia
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const toggleBtn = document.getElementById('sidebar-toggle');
        const arrow = document.getElementById('sidebar-arrow');
        let collapsed = false;

        // Leer estado guardado
        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            collapsed = true;
            sidebar.classList.add('collapsed');
        }

        toggleBtn.addEventListener('click', function() {
            collapsed = !collapsed;
            sidebar.classList.toggle('collapsed', collapsed);
            localStorage.setItem('sidebarCollapsed', collapsed);
            if (collapsed) {
                arrow.style.transform = 'rotate(180deg)';
                mainContent.style.marginLeft = '4rem';
            } else {
                arrow.style.transform = 'rotate(0deg)';
                mainContent.style.marginLeft = '16rem';
            }
        });

        // Inicializa el margen correctamente al cargar
        if (sidebar.classList.contains('collapsed')) {
            mainContent.style.marginLeft = '4rem';
            arrow.style.transform = 'rotate(180deg)';
        } else {
            mainContent.style.marginLeft = '16rem';
            arrow.style.transform = 'rotate(0deg)';
        }
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Proyectos\ProyectoAutos\resources\views/layouts/admin.blade.php ENDPATH**/ ?>