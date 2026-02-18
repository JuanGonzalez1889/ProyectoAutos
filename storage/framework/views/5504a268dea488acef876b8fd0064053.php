

<?php $__env->startSection('title', 'Crear Nueva Cita'); ?>
<?php $__env->startSection('page-title', 'Agregar Cita'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Formulario de Creación de Evento -->
    <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
        <form action="<?php echo e(route('admin.events.store')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>

            <!-- Título -->
            <div>
                <label for="title" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                    Título de la Cita *
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="<?php echo e(old('title')); ?>"
                       placeholder="ej: Prueba de Manejo"
                       class="w-full px-4 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:border-[hsl(var(--primary))] <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Descripción -->
            <div>
                <label for="description" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                    Descripción
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          placeholder="Detalles adicionales de la cita"
                          class="w-full px-4 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:border-[hsl(var(--primary))] <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description')); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Tipo de Evento -->
            <div>
                <label for="type" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                    Tipo de Evento *
                </label>
                <select id="type" 
                        name="type"
                        class="w-full px-4 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:border-[hsl(var(--primary))] <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="">Selecciona un tipo</option>
                    <option value="meeting" <?php echo e(old('type') === 'meeting' ? 'selected' : ''); ?>>Reunión</option>
                    <option value="delivery" <?php echo e(old('type') === 'delivery' ? 'selected' : ''); ?>>Entrega</option>
                    <option value="test_drive" <?php echo e(old('type') === 'test_drive' ? 'selected' : ''); ?>>Prueba de Manejo</option>
                    <option value="service" <?php echo e(old('type') === 'service' ? 'selected' : ''); ?>>Servicio</option>
                    <option value="other" <?php echo e(old('type') === 'other' ? 'selected' : ''); ?>>Otro</option>
                </select>
                <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Fecha y Hora -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="start_time" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                        Fecha y Hora de Inicio *
                    </label>
                    <input type="datetime-local" 
                           id="start_time" 
                           name="start_time" 
                           value="<?php echo e(old('start_time')); ?>"
                           class="w-full px-4 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:border-[hsl(var(--primary))] <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="end_time" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                        Fecha y Hora de Fin
                    </label>
                    <input type="datetime-local" 
                           id="end_time" 
                           name="end_time" 
                           value="<?php echo e(old('end_time')); ?>"
                           class="w-full px-4 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:border-[hsl(var(--primary))] <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Ubicación -->
            <div>
                <label for="location" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                    Ubicación
                </label>
                <input type="text" 
                       id="location" 
                       name="location" 
                       value="<?php echo e(old('location')); ?>"
                       placeholder="ej: Agencia Principal"
                       class="w-full px-4 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:border-[hsl(var(--primary))] <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Nombre del Cliente -->
            <div>
                <label for="client_name" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                    Nombre del Cliente
                </label>
                <input type="text" 
                       id="client_name" 
                       name="client_name" 
                       value="<?php echo e(old('client_name')); ?>"
                       placeholder="ej: Juan Pérez"
                       class="w-full px-4 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:border-[hsl(var(--primary))] <?php $__errorArgs = ['client_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['client_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Teléfono del Cliente -->
            <div>
                <label for="client_phone" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                    Teléfono del Cliente
                </label>
                <input type="tel" 
                       id="client_phone" 
                       name="client_phone" 
                       value="<?php echo e(old('client_phone')); ?>"
                       placeholder="ej: +1 234 567 8900"
                       class="w-full px-4 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:border-[hsl(var(--primary))] <?php $__errorArgs = ['client_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['client_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Botones de Acción -->
            <div class="flex gap-4 justify-end pt-6 border-t border-[hsl(var(--border))]">
                <a href="<?php echo e(route('admin.events.index')); ?>" 
                   class="px-6 py-2 bg-[hsl(var(--secondary))] hover:opacity-80 text-[hsl(var(--foreground))] rounded-lg font-medium transition-opacity">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-medium transition-opacity">
                    Crear Cita
                </button>
            </div>
        </form>
    </div>

    <!-- Información de Ayuda -->
    <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-4">
        <p class="text-sm text-[hsl(var(--muted-foreground))]">
            <strong class="text-blue-500">Tip:</strong> Completa todos los campos obligatorios (marcados con *) para crear una nueva cita. Puedes editar o cancelar eventos existentes desde la sección de Calendario.
        </p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views/events/create.blade.php ENDPATH**/ ?>