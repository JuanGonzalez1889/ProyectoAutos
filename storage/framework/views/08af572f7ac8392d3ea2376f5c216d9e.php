

<?php $__env->startSection('title', 'Detalles de Agencia - ' . $tenant->name); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900"><?php echo e($tenant->name); ?></h1>
                <p class="text-gray-600 mt-1">Gestiona los detalles de la agencia</p>
            </div>
            <a href="<?php echo e(route('admin.tenants.index')); ?>" class="text-blue-600 hover:text-blue-700 font-medium">
                ← Volver al listado
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Información Principal -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow">
                    <!-- Información Básica -->
                    <div class="border-b border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Información Básica</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombre de la Agencia</label>
                                <p class="mt-1 text-gray-900 font-medium"><?php echo e($tenant->name); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-gray-900"><?php echo e($tenant->email); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                                <p class="mt-1 text-gray-900"><?php echo e($tenant->phone ?? 'No especificado'); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dirección</label>
                                <p class="mt-1 text-gray-900"><?php echo e($tenant->address ?? 'No especificada'); ?></p>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <a href="<?php echo e(route('admin.tenants.edit', $tenant)); ?>" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                ✏️ Editar Información
                            </a>
                        </div>
                    </div>

                    <!-- Información de Dominio -->
                    <div class="border-b border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Dominios</h2>
                        
                        <?php if($tenant->domains->count()): ?>
                            <div class="space-y-3">
                                <?php $__currentLoopData = $tenant->domains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $domain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                        <div>
                                            <p class="font-medium text-gray-900"><?php echo e($domain->domain); ?></p>
                                            <p class="text-sm text-gray-600">
                                                Creado: <?php echo e($domain->created_at->format('d/m/Y H:i')); ?>

                                            </p>
                                        </div>
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                            Activo
                                        </span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-600 text-center py-4">Sin dominios asignados</p>
                        <?php endif; ?>
                    </div>

                    <!-- Usuarios de la Agencia -->
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Usuarios de la Agencia</h2>
                        
                        <?php if($tenant->users->count()): ?>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Nombre</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Email</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Rol</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <?php $__currentLoopData = $tenant->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-900"><?php echo e($user->name); ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-600"><?php echo e($user->email); ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <?php $__empty_1 = true; $__currentLoopData = $user->getRoleNames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm">
                                                            <?php echo e($role); ?>

                                                        </span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <span class="text-gray-500 text-sm">Sin rol</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                                        Activo
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-600 text-center py-4">Sin usuarios asignados</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Información Secundaria (Sidebar) -->
            <div class="space-y-6">
                <!-- Estado y Plan -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Estado y Plan</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-gray-600">Estado</label>
                            <div class="mt-2 flex items-center">
                                <?php if($tenant->is_active): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        ● Activo
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        ● Inactivo
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-600">Plan</label>
                            <p class="mt-1 text-gray-900 font-semibold capitalize"><?php echo e($tenant->plan ?? 'Gratuito'); ?></p>
                        </div>

                        <!-- Trial Info -->
                        <?php if($tenant->isOnTrial()): ?>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <p class="text-sm font-medium text-yellow-800">📅 En Período de Prueba</p>
                                <p class="text-sm text-yellow-700 mt-1">
                                    Vence: <strong><?php echo e($tenant->trial_ends_at->format('d/m/Y')); ?></strong>
                                </p>
                                <p class="text-xs text-yellow-600 mt-2">
                                    Faltan: <?php echo e($tenant->trial_ends_at->diffInDays(now())); ?> días
                                </p>
                            </div>
                        <?php elseif($tenant->hasActiveSubscription()): ?>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <p class="text-sm font-medium text-green-800">✅ Suscripción Activa</p>
                                <p class="text-sm text-green-700 mt-1">
                                    Vence: <strong><?php echo e($tenant->subscription_ends_at->format('d/m/Y')); ?></strong>
                                </p>
                            </div>
                        <?php else: ?>
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <p class="text-sm font-medium text-red-800">⚠️ Suscripción Vencida</p>
                                <p class="text-sm text-red-700 mt-1">
                                    Vencida desde: <strong><?php echo e($tenant->subscription_ends_at->format('d/m/Y')); ?></strong>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones</h3>
                    
                    <div class="space-y-3">
                        <!-- Toggle Status -->
                        <form action="<?php echo e(route('admin.tenants.toggle-status', $tenant)); ?>" method="POST" class="inline-block w-full">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="w-full text-left px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-900 rounded-lg transition font-medium">
                                <?php if($tenant->is_active): ?>
                                    ⏹️ Desactivar Agencia
                                <?php else: ?>
                                    ▶️ Activar Agencia
                                <?php endif; ?>
                            </button>
                        </form>

                        <!-- Delete -->
                        <form action="<?php echo e(route('admin.tenants.destroy', $tenant)); ?>" 
                              method="POST" 
                              onsubmit="return confirm('⚠️ ¿Estás seguro? Se eliminará toda la información de esta agencia.');"
                              class="inline-block w-full">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="w-full text-left px-4 py-2 bg-red-100 hover:bg-red-200 text-red-900 rounded-lg transition font-medium">
                                🗑️ Eliminar Agencia
                            </button>
                        </form>
                    </div>

                    <p class="text-xs text-gray-500 mt-4 italic">
                        Creado: <?php echo e($tenant->created_at->format('d/m/Y H:i')); ?>

                    </p>
                </div>

                <!-- Información Rápida -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Rápida</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Total de Usuarios</span>
                            <span class="font-semibold text-gray-900"><?php echo e($tenant->users->count()); ?></span>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-200 pt-3">
                            <span class="text-gray-600">Total de Dominios</span>
                            <span class="font-semibold text-gray-900"><?php echo e($tenant->domains->count()); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\tenants\show.blade.php ENDPATH**/ ?>