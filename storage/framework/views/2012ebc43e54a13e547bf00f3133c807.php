


<?php $__env->startSection('title', 'Usuarios'); ?>
<?php $__env->startSection('page-title', 'Gestión de Usuarios'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-semibold text-white mb-1">Lista de Usuarios</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Administra usuarios, roles y permisos del sistema</p>
        </div>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users.create')): ?>
        <a href="<?php echo e(route('admin.users.create')); ?>" 
           class="h-10 px-5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Crear Usuario
        </a>
        <?php endif; ?>
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
                    <p class="text-2xl font-bold text-white"><?php echo e($users->total()); ?></p>
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
                    <p class="text-2xl font-bold text-green-500"><?php echo e($users->where('is_active', true)->count()); ?></p>
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
                    <p class="text-2xl font-bold text-purple-500"><?php echo e($users->filter(fn($u) => $u->roles->contains('name', 'ADMIN'))->count()); ?></p>
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
                    <p class="text-2xl font-bold text-yellow-500"><?php echo e($users->filter(fn($u) => $u->roles->contains('name', 'AGENCIERO'))->count()); ?></p>
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
            
            <?php if(auth()->user()->isAdmin()): ?>
            <!-- Filtro por Agencia (solo ADMIN) -->
            <form method="GET" action="<?php echo e(route('admin.users.index')); ?>" class="flex items-center gap-2">
                <select name="agencia_id" onchange="this.form.submit()"
                        class="h-10 px-4 bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                    <option value="">Todas las agencias</option>
                    <option value="sin_agencia" <?php echo e(request('agencia_id') === 'sin_agencia' ? 'selected' : ''); ?>>Sin agencia</option>
                    <?php $__currentLoopData = $agencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($agencia->id); ?>" <?php echo e(request('agencia_id') == $agencia->id ? 'selected' : ''); ?>>
                            <?php echo e($agencia->nombre); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php if(request('agencia_id')): ?>
                    <a href="<?php echo e(route('admin.users.index')); ?>" 
                       class="h-10 px-4 bg-red-500/20 hover:bg-red-500/30 text-red-500 rounded-lg text-sm font-medium transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Limpiar
                    </a>
                <?php endif; ?>
            </form>
            <?php endif; ?>
            
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
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b border-[hsl(var(--border))] hover:bg-[hsl(var(--muted))]/50 transition-colors">
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <?php if($user->avatar): ?>
                                    <img class="h-10 w-10 rounded-full" src="<?php echo e($user->avatar); ?>" alt="">
                                <?php else: ?>
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                        <span class="text-white font-bold text-sm"><?php echo e(strtoupper(substr($user->name, 0, 1))); ?></span>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <a href="<?php echo e(route('admin.users.show', $user)); ?>" 
                                       class="font-medium text-white hover:underline"><?php echo e($user->name); ?></a>
                                    <?php if($user->google_id): ?>
                                        <span class="text-xs text-[hsl(var(--muted-foreground))] flex items-center gap-1 mt-0.5">
                                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                            </svg>
                                            Google
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 text-[hsl(var(--muted-foreground))]">
                            <?php echo e($user->email); ?>

                        </td>
                        <td class="py-4">
                            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="px-2 py-1 text-xs font-medium rounded
                                    <?php if($role->name === 'ADMIN'): ?> bg-purple-500/20 text-purple-600
                                    <?php elseif($role->name === 'AGENCIERO'): ?> bg-green-500/20 text-green-600
                                    <?php else: ?> bg-yellow-500/20 text-yellow-600
                                    <?php endif; ?>">
                                    <?php echo e($role->name); ?>

                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td class="py-4 text-[hsl(var(--muted-foreground))]">
                            <?php if($user->agencia): ?>
                                <span class="px-2 py-1 text-xs font-medium rounded bg-blue-500/20 text-blue-600">
                                    <?php echo e($user->agencia->nombre); ?>

                                </span>
                            <?php else: ?>
                                <span class="text-xs text-[hsl(var(--muted-foreground))]">Sin agencia</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4">
                            <?php if($user->is_active): ?>
                                <span class="px-2 py-1 text-xs font-medium rounded bg-green-500/20 text-green-600">
                                    Activo
                                </span>
                            <?php else: ?>
                                <span class="px-2 py-1 text-xs font-medium rounded bg-red-500/20 text-red-600">
                                    Inactivo
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 text-[hsl(var(--muted-foreground))]">
                            <?php echo e($user->created_at->format('d/m/Y')); ?>

                        </td>
                        <td class="py-4">
                            <div class="flex justify-end">
                                <div class="relative acciones-dropdown-container">
                                    <button type="button" class="p-2 hover:bg-[hsl(var(--muted))] rounded-lg transition-colors acciones-dropdown-btn">
                                        <svg class="w-5 h-5 text-[hsl(var(--muted-foreground))]" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                                        </svg>
                                    </button>
                                    <div class="absolute right-0 mt-2 w-48 bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg shadow-lg z-50 acciones-dropdown-menu" style="display: none;">
                                        <?php $__env->startPush('scripts'); ?>
                                        <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            document.querySelectorAll('.acciones-dropdown-btn').forEach(function(btn) {
                                                btn.addEventListener('click', function(e) {
                                                    e.stopPropagation();
                                                    // Cierra otros menús abiertos
                                                    document.querySelectorAll('.acciones-dropdown-menu').forEach(function(menu) {
                                                        if (menu !== btn.nextElementSibling) menu.style.display = 'none';
                                                    });
                                                    let menu = btn.nextElementSibling;
                                                    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
                                                });
                                            });
                                            document.addEventListener('click', function() {
                                                document.querySelectorAll('.acciones-dropdown-menu').forEach(function(menu) {
                                                    menu.style.display = 'none';
                                                });
                                            });
                                        });
                                        </script>
                                        <?php $__env->stopPush(); ?>
                                        <div class="py-1">
                                                                <?php if(auth()->user()->hasRole('ADMIN') && auth()->user()->id !== $user->id): ?>
                                                                <a href="<?php echo e(route('impersonate.start', $user->id)); ?>" class="flex items-center gap-2 px-4 py-2 text-sm text-indigo-500 hover:bg-[hsl(var(--muted))] transition-colors">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                                                    </svg>
                                                                    Impersonar
                                                                </a>
                                                                <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users.edit')): ?>
                                            <a href="<?php echo e(route('admin.users.edit', $user)); ?>" 
                                               class="flex items-center gap-2 px-4 py-2 text-sm text-[hsl(var(--foreground))] hover:bg-[hsl(var(--muted))] transition-colors">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Editar
                                            </a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users.change_permissions')): ?>
                                            <a href="<?php echo e(route('admin.users.permissions.edit', $user)); ?>" 
                                               class="flex items-center gap-2 px-4 py-2 text-sm text-[hsl(var(--foreground))] hover:bg-[hsl(var(--muted))] transition-colors">
                                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Permisos
                                            </a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('audit.view_logs')): ?>
                                            <a href="<?php echo e(route('admin.users.activity', $user)); ?>" 
                                               class="flex items-center gap-2 px-4 py-2 text-sm text-[hsl(var(--foreground))] hover:bg-[hsl(var(--muted))] transition-colors">
                                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Actividad
                                            </a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users.edit')): ?>
                                            <form method="POST" action="<?php echo e(route('admin.users.toggle-status', $user)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-[hsl(var(--foreground))] hover:bg-[hsl(var(--muted))] transition-colors text-left">
                                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <?php if($user->is_active): ?>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                        <?php else: ?>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        <?php endif; ?>
                                                    </svg>
                                                    <?php echo e($user->is_active ? 'Desactivar' : 'Activar'); ?>

                                                </button>
                                            </form>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users.delete')): ?>
                                            <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>" 
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-500 hover:bg-[hsl(var(--muted))] transition-colors text-left">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Eliminar
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-[hsl(var(--muted-foreground))]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p class="mt-4 text-[hsl(var(--muted-foreground))]">No hay usuarios registrados</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($users->hasPages()): ?>
        <div class="mt-6 pt-4 border-t border-[hsl(var(--border))]">
            <?php echo e($users->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<script>
document.addEventListener('DOMContentLoaded', function() {
    function initDropdowns() {
        document.querySelectorAll('.acciones-dropdown-btn').forEach(function(btn) {
            btn.onclick = function(e) {
                e.stopPropagation();
                document.querySelectorAll('.acciones-dropdown-menu').forEach(function(menu) {
                    if (menu !== btn.nextElementSibling) menu.style.display = 'none';
                });
                let menu = btn.nextElementSibling;
                menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
            };
        });
        document.addEventListener('click', function() {
            document.querySelectorAll('.acciones-dropdown-menu').forEach(function(menu) {
                menu.style.display = 'none';
            });
        });
    }
    initDropdowns();
    // Si usas AJAX/LIVEWIRE/INERTIA, llama initDropdowns() tras cada actualización de la tabla
});
</script>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views/admin/users/index.blade.php ENDPATH**/ ?>