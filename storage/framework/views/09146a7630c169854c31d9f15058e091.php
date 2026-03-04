

<?php $__env->startSection('content'); ?>
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
                        Usuario: <span class="font-semibold"><?php echo e($user->name); ?></span>
                    </p>
                </div>
                <a href="<?php echo e(route('admin.users.show', $user)); ?>" 
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
                        <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                <?php echo e($activity->created_at->format('d/m/Y H:i')); ?>

                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-100 capitalize">
                                    <?php echo e(match($activity->module) {
                                        'vehicles' => 'Vehículos',
                                        'leads' => 'Leads',
                                        'tasks' => 'Tareas',
                                        'events' => 'Eventos',
                                        'users' => 'Usuarios',
                                        'settings' => 'Configuración',
                                        default => $activity->module
                                    }); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                                    <?php if($activity->action === 'create'): ?>
                                        bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100
                                    <?php elseif($activity->action === 'edit'): ?>
                                        bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-100
                                    <?php elseif($activity->action === 'delete'): ?>
                                        bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-100
                                    <?php else: ?>
                                        bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100
                                    <?php endif; ?>
                                ">
                                    <?php echo e($activity->action); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                <?php echo e($activity->description ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?php if($activity->status === 'success'): ?>
                                        bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100
                                    <?php else: ?>
                                        bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-100
                                    <?php endif; ?>
                                ">
                                    <?php echo e($activity->status === 'success' ? 'Exitoso' : 'Error'); ?>

                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                No hay actividades registradas para este usuario
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($activities->hasPages()): ?>
            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                <?php echo e($activities->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\admin\audit\user-activity.blade.php ENDPATH**/ ?>