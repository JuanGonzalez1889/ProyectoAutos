

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestión de Dominios</h1>
                <p class="mt-2 text-gray-600">Administra y configura los dominios de tu agencia</p>
            </div>
            <a href="<?php echo e(route('admin.domains.create')); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Agregar Dominio
            </a>
        </div>

        <!-- Messages -->
        <?php if($message = Session::get('success')): ?>
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                <?php echo e($message); ?>

            </div>
        <?php endif; ?>

        <?php if($message = Session::get('info')): ?>
            <div class="mb-6 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
                <?php echo e($message); ?>

            </div>
        <?php endif; ?>

        <!-- Domains Table -->
        <div class="bg-white rounded-lg shadow">
            <?php if($domains->count() > 0): ?>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dominio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Configuración</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $domains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $domain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($domain->domain); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                        :class="<?php echo \Illuminate\Support\Js::from($domain->type === 'new' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')->toHtml() ?>">
                                        <?php echo e(ucfirst($domain->type)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($domain->isFullyConfigured()): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            ✓ Completado
                                        </span>
                                    <?php elseif($domain->registration_status === 'available'): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Disponible
                                        </span>
                                    <?php elseif(!$domain->dns_configured): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            DNS Pendiente
                                        </span>
                                    <?php elseif(!$domain->ssl_verified): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            SSL Pendiente
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex gap-2">
                                        <?php if(!$domain->dns_configured): ?>
                                            <span class="text-xs px-2 py-1 bg-orange-100 text-orange-700 rounded">DNS</span>
                                        <?php endif; ?>
                                        <?php if(!$domain->ssl_verified): ?>
                                            <span class="text-xs px-2 py-1 bg-orange-100 text-orange-700 rounded">SSL</span>
                                        <?php endif; ?>
                                        <?php if($domain->registration_status === 'available'): ?>
                                            <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-700 rounded">Registro</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="<?php echo e(route('admin.domains.show', $domain)); ?>" class="text-blue-600 hover:text-blue-900 mr-4">Ver</a>
                                    <a href="<?php echo e(route('admin.domains.edit', $domain)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-4">Editar</a>
                                    <form action="<?php echo e(route('admin.domains.destroy', $domain)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay dominios</h3>
                    <p class="mt-1 text-sm text-gray-500">Comienza agregando tu primer dominio.</p>
                    <div class="mt-6">
                        <a href="<?php echo e(route('admin.domains.create')); ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                            Agregar Dominio
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\admin\domains\index.blade.php ENDPATH**/ ?>