

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <a href="<?php echo e(route('admin.domains.index')); ?>" class="text-blue-600 hover:text-blue-900">← Volver</a>
                <h1 class="mt-2 text-3xl font-bold text-gray-900"><?php echo e($domain->domain); ?></h1>
                <p class="mt-1 text-gray-600">Detalles y configuración del dominio</p>
            </div>
            <div class="flex gap-3">
                <a href="<?php echo e(route('admin.domains.edit', $domain)); ?>" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Editar
                </a>
                <form action="<?php echo e(route('admin.domains.destroy', $domain)); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700" onclick="return confirm('¿Estás seguro?')">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>

        <!-- Status Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Tipo</p>
                        <p class="text-lg font-medium text-gray-900"><?php echo e(ucfirst($domain->type)); ?></p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                        :class="<?php echo \Illuminate\Support\Js::from($domain->type === 'new' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')->toHtml() ?>">
                        <?php echo e($domain->type); ?>

                    </span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Registro</p>
                        <p class="text-lg font-medium text-gray-900"><?php echo e($domainReport['format_valid'] ? '✓ Válido' : '✗ Inválido'); ?></p>
                    </div>
                    <span class="text-2xl"><?php echo e($domainReport['format_valid'] ? '✓' : '✗'); ?></span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">DNS</p>
                        <p class="text-lg font-medium text-gray-900"><?php echo e($domain->dns_configured ? 'Configurado' : 'Pendiente'); ?></p>
                    </div>
                    <span class="text-2xl"><?php echo e($domain->dns_configured ? '✓' : '⏳'); ?></span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">SSL</p>
                        <p class="text-lg font-medium text-gray-900"><?php echo e($domain->ssl_verified ? 'Verificado' : 'Pendiente'); ?></p>
                    </div>
                    <span class="text-2xl"><?php echo e($domain->ssl_verified ? '✓' : '⏳'); ?></span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- DNS Configuration -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-900">Configuración DNS</h2>
                        <?php if(!$domain->dns_configured): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                Pendiente
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Configurado
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if(count($domainReport['dns_records']) > 0): ?>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $domainReport['dns_records']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $records): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!empty($records)): ?>
                                    <div class="border rounded-lg p-4">
                                        <h3 class="font-medium text-gray-900 mb-2">Registros <?php echo e($type); ?></h3>
                                        <div class="space-y-2">
                                            <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="text-sm font-mono text-gray-600 bg-gray-50 p-2 rounded">
                                                    <?php echo e(json_encode($record, JSON_PRETTY_PRINT)); ?>

                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-sm text-yellow-700">
                                <strong>Aún no hay registros DNS configurados.</strong> Consulta la sección de sugerencias para saber qué registros necesitas.
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- SSL Certificate -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-900">Certificado SSL</h2>
                        <?php if($domainReport['ssl_certificate']['valid']): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Válido
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                No verificado
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if($domainReport['ssl_certificate']['valid']): ?>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-600">Nombre Común</p>
                                <p class="font-mono text-gray-900"><?php echo e($domainReport['ssl_certificate']['common_name']); ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Emisor</p>
                                <p class="font-mono text-gray-900"><?php echo e($domainReport['ssl_certificate']['issuer']); ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Expira el</p>
                                <p class="font-mono text-gray-900"><?php echo e($domainReport['ssl_certificate']['expires_at']); ?></p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-sm text-yellow-700">
                                <strong><?php echo e($domainReport['ssl_certificate']['error']); ?></strong>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Suggestions & Next Steps -->
            <div>
                <!-- DNS Suggestions -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Sugerencias DNS</h3>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $domainReport['dns_suggestions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suggestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border rounded-lg p-3 <?php echo e($suggestion['required'] ? 'border-red-300 bg-red-50' : 'border-gray-200'); ?>">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="font-medium text-sm text-gray-900"><?php echo e($suggestion['name']); ?></p>
                                        <p class="text-xs text-gray-600 mt-1"><?php echo e($suggestion['description']); ?></p>
                                        <p class="font-mono text-xs text-gray-500 mt-2 break-words"><?php echo e($suggestion['example']); ?></p>
                                    </div>
                                    <?php if($suggestion['required']): ?>
                                        <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded">Requerido</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Próximos Pasos</h3>
                    <ol class="space-y-3">
                        <?php if($domainReport['format_valid'] && $domain->registration_status === 'available'): ?>
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-blue-100 text-blue-700 text-sm font-medium">1</span>
                                <p class="text-sm text-gray-700">Registra el dominio en tu registrador</p>
                            </li>
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-gray-200 text-gray-400 text-sm font-medium">2</span>
                                <p class="text-sm text-gray-500">Configura los registros DNS</p>
                            </li>
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-gray-200 text-gray-400 text-sm font-medium">3</span>
                                <p class="text-sm text-gray-500">Instala un certificado SSL</p>
                            </li>
                        <?php elseif(!$domain->dns_configured): ?>
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-blue-100 text-blue-700 text-sm font-medium">1</span>
                                <p class="text-sm text-gray-700">Configura los registros DNS</p>
                            </li>
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-gray-200 text-gray-400 text-sm font-medium">2</span>
                                <p class="text-sm text-gray-500">Instala un certificado SSL</p>
                            </li>
                        <?php elseif(!$domain->ssl_verified): ?>
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-blue-100 text-blue-700 text-sm font-medium">1</span>
                                <p class="text-sm text-gray-700">Instala un certificado SSL</p>
                            </li>
                        <?php else: ?>
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-green-100 text-green-700 text-sm font-medium">✓</span>
                                <p class="text-sm text-gray-700"><strong>El dominio está completamente configurado</strong></p>
                            </li>
                        <?php endif; ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\admin\domains\show.blade.php ENDPATH**/ ?>