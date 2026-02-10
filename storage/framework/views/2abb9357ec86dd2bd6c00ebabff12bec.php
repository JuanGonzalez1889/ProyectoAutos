

<?php $__env->startSection('title', 'Dashboard - Administrador'); ?>
<?php $__env->startSection('page-title', 'Resumen Global'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs text-[hsl(var(--muted-foreground))]">Bienvenido de nuevo, Administrador</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="h-9 px-4 bg-[hsl(var(--card))] hover:bg-[hsl(var(--muted))] border border-[hsl(var(--border))] rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Exportar Data
            </button>
            <button class="h-9 px-4 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Agencia
            </button>
        </div>
    </div>

    <!-- Cards de métricas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Total Agencias -->
        <div class="p-5 bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-lg">
            <div class="flex items-start justify-between mb-2">
                <div class="p-2 bg-green-500/20 rounded-lg">
                    <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <span class="text-[10px] px-1.5 py-0.5 bg-green-500/20 text-green-600 rounded">+22%</span>
            </div>
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Total Agencias</p>
            <p class="text-2xl font-bold text-white">24</p>
        </div>

        <!-- Usuarios Activos -->
        <div class="p-5 bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-lg">
            <div class="flex items-start justify-between mb-2">
                <div class="p-2 bg-purple-500/20 rounded-lg">
                    <svg class="h-4 w-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <span class="text-[10px] px-1.5 py-0.5 bg-purple-500/20 text-purple-600 rounded">+16%</span>
            </div>
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Usuarios Activos</p>
            <p class="text-2xl font-bold text-white"><?php echo e(number_format($stats['active_users'])); ?></p>
        </div>

        <!-- Ingresos Mes -->
        <div class="p-5 bg-gradient-to-br from-yellow-500/10 to-yellow-600/10 border border-yellow-500/20 rounded-lg">
            <div class="flex items-start justify-between mb-2">
                <div class="p-2 bg-yellow-500/20 rounded-lg">
                    <svg class="h-4 w-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-[10px] px-1.5 py-0.5 bg-yellow-500/20 text-yellow-600 rounded">+9%</span>
            </div>
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Ingresos Mes</p>
            <p class="text-2xl font-bold text-white">$450k</p>
        </div>

        <!-- Pendientes -->
        <div class="p-5 bg-gradient-to-br from-red-500/10 to-red-600/10 border border-red-500/20 rounded-lg">
            <div class="flex items-start justify-between mb-2">
                <div class="p-2 bg-red-500/20 rounded-lg">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
                <span class="text-[10px] px-1.5 py-0.5 bg-red-500/20 text-red-600 rounded flex items-center gap-0.5">
                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    Requiere Acción
                </span>
            </div>
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Pendientes</p>
            <p class="text-2xl font-bold text-white">12</p>
        </div>
    </div>

    <!-- Sección principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Administración de Usuarios (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Formulario Registrar Usuario -->
            <div class="card">
                <div class="border-b border-[hsl(var(--border))] pb-4 mb-6">
                    <h2 class="text-base font-semibold mb-1">Administración de Usuarios</h2>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Gestiona roles y permisos para agencias y colaboradores</p>
                </div>

                <div class="border border-[hsl(var(--border))] rounded-lg p-5 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[hsl(var(--primary))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold">Registrar Nuevo Usuario</h3>
                        </div>
                        <a href="<?php echo e(route('admin.users.create')); ?>" class="text-xs text-[hsl(var(--primary))] hover:underline">Acceso Admin</a>
                    </div>

                    <form action="<?php echo e(route('admin.users.store')); ?>" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label class="block text-xs font-medium text-[hsl(var(--muted-foreground))] mb-1.5">NOMBRE COMPLETO</label>
                            <input type="text" name="name" placeholder="Ej.: Juan Pérez" required
                                   class="w-full h-9 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[hsl(var(--muted-foreground))] mb-1.5">CORREO ELECTRÓNICO</label>
                            <input type="email" name="email" placeholder="usuario@empresa.com" required
                                   class="w-full h-9 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[hsl(var(--muted-foreground))] mb-1.5">ROL ASIGNADO</label>
                            <select name="role" required
                                    class="w-full h-9 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                                <option value="">Seleccionar rol...</option>
                                <option value="ADMIN">Administrador</option>
                                <option value="AGENCIERO">Agenciero</option>
                                <option value="COLABORADOR">Colaborador</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[hsl(var(--muted-foreground))] mb-1.5">AGENCIA (OPCIONAL)</label>
                            <div class="relative">
                                <input type="text" placeholder="Vincular a agencia..." 
                                       class="w-full h-9 px-3 pr-10 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                                <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 p-1 hover:bg-[hsl(var(--muted))] rounded">
                                    <svg class="w-4 h-4 text-[hsl(var(--muted-foreground))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="md:col-span-2 flex justify-end gap-3 mt-2">
                            <button type="button" class="h-9 px-4 text-sm text-[hsl(var(--muted-foreground))] hover:text-white">
                                Cancelar
                            </button>
                            <button type="submit" class="h-9 px-5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                Crear Usuario
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tabla de Usuarios Existentes -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold">Usuarios Existentes</h3>
                        <div class="flex items-center gap-2">
                            <div class="relative">
                                <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-[hsl(var(--muted-foreground))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input type="text" placeholder="Buscar"
                                       class="w-28 h-8 pl-8 pr-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-xs focus:outline-none focus:border-[hsl(var(--primary))]">
                            </div>
                            <button class="p-1.5 hover:bg-[hsl(var(--muted))] rounded">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="text-xs text-[hsl(var(--muted-foreground))] border-b border-[hsl(var(--border))]">
                                <tr>
                                    <th class="text-left pb-3 font-medium">USUARIO</th>
                                    <th class="text-left pb-3 font-medium">ROL</th>
                                    <th class="text-left pb-3 font-medium">AGENCIA</th>
                                    <th class="text-left pb-3 font-medium">ESTADO</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                <?php $__empty_1 = true; $__currentLoopData = $stats['recent_users'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="border-b border-[hsl(var(--border))] hover:bg-[hsl(var(--muted))]/50">
                                    <td class="py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-xs font-bold text-white">
                                                <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                            </div>
                                            <div>
                                                <p class="font-medium text-white"><?php echo e($user->name); ?></p>
                                                <p class="text-xs text-[hsl(var(--muted-foreground))]"><?php echo e($user->email); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="px-2 py-0.5 text-xs font-medium rounded
                                            <?php if($user->roles->first()?->name === 'AGENCIERO'): ?> bg-yellow-500/20 text-yellow-600
                                            <?php elseif($user->roles->first()?->name === 'ADMIN'): ?> bg-purple-500/20 text-purple-600
                                            <?php else: ?> bg-blue-500/20 text-blue-600 <?php endif; ?>">
                                            <?php echo e($user->roles->first()?->name ?? 'Sin rol'); ?>

                                        </span>
                                    </td>
                                    <td class="py-3 text-[hsl(var(--muted-foreground))]">
                                        <?php echo e($user->agencia?->nombre ?? '-'); ?>

                                    </td>
                                    <td class="py-3">
                                        <span class="px-2 py-0.5 text-xs font-medium rounded
                                            <?php if($user->is_active): ?> bg-green-500/20 text-green-600
                                            <?php else: ?> bg-red-500/20 text-red-600 <?php endif; ?>">
                                            <?php echo e($user->is_active ? 'Activo' : 'Inactivo'); ?>

                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-[hsl(var(--muted-foreground))]">
                                        No hay usuarios registrados
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna derecha (1/3) -->
        <div class="space-y-6">
            <!-- Gráfico Rendimiento -->
            <div class="card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold">Rendimiento</h3>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Esta semana</p>
                </div>

                <div class="h-48 flex items-end justify-around gap-1.5">
                    <div class="flex flex-col items-center gap-1 flex-1">
                        <div class="w-full bg-[hsl(var(--primary))]/40 rounded-t" style="height: 45%"></div>
                        <span class="text-[10px] text-[hsl(var(--muted-foreground))]">Lun</span>
                    </div>
                    <div class="flex flex-col items-center gap-1 flex-1">
                        <div class="w-full bg-[hsl(var(--primary))]/50 rounded-t" style="height: 55%"></div>
                        <span class="text-[10px] text-[hsl(var(--muted-foreground))]">Mar</span>
                    </div>
                    <div class="flex flex-col items-center gap-1 flex-1">
                        <div class="w-full bg-[hsl(var(--primary))]/60 rounded-t" style="height: 70%"></div>
                        <span class="text-[10px] text-[hsl(var(--muted-foreground))]">Mié</span>
                    </div>
                    <div class="flex flex-col items-center gap-1 flex-1">
                        <div class="w-full bg-[hsl(var(--primary))]/70 rounded-t" style="height: 85%"></div>
                        <span class="text-[10px] text-[hsl(var(--muted-foreground))]">Jue</span>
                    </div>
                    <div class="flex flex-col items-center gap-1 flex-1">
                        <div class="w-full bg-[hsl(var(--primary))]/80 rounded-t" style="height: 95%"></div>
                        <span class="text-[10px] text-[hsl(var(--muted-foreground))]">Vie</span>
                    </div>
                    <div class="flex flex-col items-center gap-1 flex-1">
                        <div class="w-full bg-[hsl(var(--primary))] rounded-t" style="height: 100%"></div>
                        <span class="text-[10px] text-[hsl(var(--muted-foreground))]">Sáb</span>
                    </div>
                </div>
            </div>

            <!-- Gráfico Distribución -->
            <div class="card">
                <h3 class="text-sm font-semibold mb-6">Distribución</h3>

                <div class="flex items-center justify-center mb-6">
                    <div class="relative w-40 h-40">
                        <!-- Círculo exterior -->
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <!-- Fondo -->
                            <circle cx="50" cy="50" r="40" fill="none" stroke="hsl(var(--border))" stroke-width="12"></circle>
                            <!-- Autos 65% -->
                            <circle cx="50" cy="50" r="40" fill="none" stroke="hsl(var(--primary))" stroke-width="12"
                                    stroke-dasharray="163 251" stroke-dashoffset="0"></circle>
                            <!-- Servicios 25% -->
                            <circle cx="50" cy="50" r="40" fill="none" stroke="#8b5cf6" stroke-width="12"
                                    stroke-dasharray="63 251" stroke-dashoffset="-163"></circle>
                            <!-- Otros 10% -->
                            <circle cx="50" cy="50" r="40" fill="none" stroke="#f59e0b" stroke-width="12"
                                    stroke-dasharray="25 251" stroke-dashoffset="-226"></circle>
                        </svg>
                        <!-- Texto central -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-3xl font-bold text-white">76%</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[hsl(var(--primary))]"></div>
                            <span class="text-xs text-[hsl(var(--muted-foreground))]">Autos</span>
                        </div>
                        <span class="text-sm font-semibold text-white">65%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                            <span class="text-xs text-[hsl(var(--muted-foreground))]">Servicios</span>
                        </div>
                        <span class="text-sm font-semibold text-white">25%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                            <span class="text-xs text-[hsl(var(--muted-foreground))]">Otros</span>
                        </div>
                        <span class="text-sm font-semibold text-white">10%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>