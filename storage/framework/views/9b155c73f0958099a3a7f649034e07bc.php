

<?php $__env->startSection('title', 'Editar Dominio - ' . $domain->domain); ?>
<?php $__env->startSection('page-title', 'Editar Dominio'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-6">
        <a href="<?php echo e(route('admin.domains.index')); ?>" 
           class="p-2 hover:bg-[hsl(var(--muted))] rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h3 class="text-xl font-semibold text-white">Editar Dominio</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))]"><?php echo e($domain->domain); ?></p>
        </div>
    </div>

    <form action="<?php echo e(route('admin.domains.update', $domain)); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>

        <!-- Campo: Dominio -->
        <div class="card">
            <label for="domain" class="block text-sm font-semibold text-white mb-3">
                Dominio <span class="text-red-400">*</span>
            </label>
            <input type="text" 
                   id="domain" 
                   name="domain" 
                   value="<?php echo e(old('domain', $domain->domain)); ?>"
                   placeholder="ejemplo.com"
                   class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))] <?php $__errorArgs = ['domain'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   required>
            <p class="text-xs text-[hsl(var(--muted-foreground))] mt-2">Ejemplo: midominio.com</p>
            <?php $__errorArgs = ['domain'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-400 text-xs mt-2"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Información del dominio -->
        <div class="card border-l-4 border-l-[hsl(var(--primary))] bg-[hsl(var(--primary))]/5">
            <p class="text-sm font-semibold text-white mb-3">Información actual:</p>
            <ul class="text-xs text-[hsl(var(--muted-foreground))] space-y-2">
                <li>• <strong>Tipo:</strong> <?php echo e($domain->type === 'new' ? 'Dominio Nuevo' : 'Dominio Existente'); ?></li>
                <li>• <strong>Registrado:</strong> <?php echo e($domain->created_at->format('d/m/Y H:i')); ?></li>
            </ul>
        </div>

        <!-- Botones -->
        <div class="flex gap-3 pt-4">
            <button type="submit" class="flex-1 h-10 px-6 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg transition font-semibold">
                💾 Guardar Cambios
            </button>
            <a href="<?php echo e(route('admin.domains.show', $domain)); ?>" class="flex-1 h-10 px-6 bg-[hsl(var(--muted))] hover:bg-[hsl(var(--muted))]/80 text-[hsl(var(--muted-foreground))] rounded-lg transition font-semibold text-center flex items-center justify-center">
                Cancelar
            </a>
        </div>

        <!-- Errores globales -->
        <?php if($errors->any()): ?>
            <div class="card border-l-4 border-l-red-500 bg-red-500/5">
                <p class="text-red-400 font-semibold mb-2">Errores encontrados:</p>
                <ul class="text-red-400 text-xs list-disc list-inside space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\domains\edit.blade.php ENDPATH**/ ?>