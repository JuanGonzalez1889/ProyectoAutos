

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="<?php echo e(route('admin.domains.index')); ?>" class="text-blue-600 hover:text-blue-900">← Volver</a>
            <h1 class="mt-2 text-3xl font-bold text-gray-900">Crear Nuevo Dominio</h1>
        </div>

        <!-- Create Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <form action="<?php echo e(route('admin.domains.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <!-- Domain Input -->
                <div class="mb-6">
                    <label for="domain" class="block text-sm font-medium text-gray-700">Nombre del Dominio</label>
                    <div class="mt-2 relative">
                        <input 
                            type="text" 
                            id="domain" 
                            name="domain" 
                            placeholder="ejemplo.com"
                            value="<?php echo e(old('domain')); ?>"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['domain'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            @input="validateDomain"
                            x-data="{ validating: false, status: null }"
                        >
                        <div id="validation-feedback" class="mt-2 text-sm"></div>
                    </div>
                    <?php $__errorArgs = ['domain'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Type Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Tipo de Dominio</label>
                    <div class="mt-3 space-y-3">
                        <label class="flex items-center">
                            <input type="radio" name="type" value="existing" checked class="h-4 w-4 text-blue-600">
                            <span class="ml-3 text-sm text-gray-700">
                                Dominio Existente
                                <p class="text-xs text-gray-500 mt-1">El dominio ya está registrado en un registrador</p>
                            </span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="type" value="new" class="h-4 w-4 text-blue-600">
                            <span class="ml-3 text-sm text-gray-700">
                                Nuevo Dominio
                                <p class="text-xs text-gray-500 mt-1">Necesita ser registrado</p>
                            </span>
                        </label>
                    </div>
                    <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Information -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h3 class="text-sm font-medium text-blue-900">Próximos pasos</h3>
                    <ul class="mt-2 text-sm text-blue-700 list-disc list-inside space-y-1">
                        <li>Configurar registros DNS</li>
                        <li>Verificar certificado SSL</li>
                        <li>Realizar pruebas de conectividad</li>
                    </ul>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500"
                    >
                        Crear Dominio
                    </button>
                    <a 
                        href="<?php echo e(route('admin.domains.index')); ?>" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
                    >
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <!-- Tips -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Validación de Dominio</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li>✓ Formato válido (.com, .es, etc)</li>
                    <li>✓ No puede ser un dominio reservado</li>
                    <li>✓ No puede estar en uso en el sistema</li>
                    <li>✓ Máximo 253 caracteres</li>
                </ul>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Configuración Recomendada</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li>1. Registrar el dominio (si es nuevo)</li>
                    <li>2. Configurar registros DNS</li>
                    <li>3. Instalar certificado SSL</li>
                    <li>4. Verificar conectividad</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    function validateDomain() {
        const domain = document.getElementById('domain').value.trim().toLowerCase();
        const feedback = document.getElementById('validation-feedback');
        
        if (!domain) {
            feedback.innerHTML = '';
            return;
        }

        // Show loading state
        feedback.innerHTML = '<span class="text-gray-500">Validando...</span>';

        // Call validation endpoint
        fetch(`<?php echo e(route('admin.domains.validate')); ?>?domain=${encodeURIComponent(domain)}`)
            .then(response => response.json())
            .then(data => {
                let html = '';
                
                if (!data.format_valid) {
                    html = '<div class="text-red-600"><strong>Formato inválido:</strong><br>';
                    data.format_errors.forEach(error => {
                        html += error + '<br>';
                    });
                    html += '</div>';
                } else if (!data.available && !data.registered) {
                    html = '<div class="text-yellow-600"><strong>Estado:</strong> Disponible para registrar</div>';
                } else if (!data.available && data.registered) {
                    html = '<div class="text-green-600"><strong>Estado:</strong> Registrado y activo</div>';
                    if (!data.dns_configured) {
                        html += '<div class="text-orange-600 mt-2">⚠️ DNS no configurado</div>';
                    }
                    if (!data.ssl_valid) {
                        html += '<div class="text-orange-600 mt-2">⚠️ SSL no verificado</div>';
                    }
                } else {
                    html = '<div class="text-green-600"><strong>✓ Válido</strong></div>';
                }
                
                feedback.innerHTML = html;
            })
            .catch(error => {
                feedback.innerHTML = '<span class="text-gray-500">No se pudo validar</span>';
            });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\admin\domains\create.blade.php ENDPATH**/ ?>