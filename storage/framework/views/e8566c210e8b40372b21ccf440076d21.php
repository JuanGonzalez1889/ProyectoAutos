

<?php $__env->startSection('title', 'Editar Lead'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-[hsl(var(--muted-foreground))] mb-2">
            <a href="<?php echo e(route('admin.leads.index')); ?>" class="hover:text-[hsl(var(--foreground))]">Leads</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-[hsl(var(--foreground))]">Editar Lead</span>
        </div>
        <h1 class="text-2xl font-bold text-[hsl(var(--foreground))]">Editar Lead: <?php echo e($lead->name); ?></h1>
    </div>

    <!-- Formulario -->
    <div class="max-w-4xl">
        <form action="<?php echo e(route('admin.leads.update', $lead)); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>

            <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
                <h2 class="text-lg font-semibold text-[hsl(var(--foreground))] mb-4">Información del Cliente</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nombre -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Nombre Completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               required
                               value="<?php echo e(old('name', $lead->name)); ?>"
                               class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent">
                        <?php $__errorArgs = ['name'];
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

                    <!-- Teléfono -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Teléfono <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                               name="phone" 
                               id="phone" 
                               required
                               value="<?php echo e(old('phone', $lead->phone)); ?>"
                               class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent">
                        <?php $__errorArgs = ['phone'];
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

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Email
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email"
                               value="<?php echo e(old('email', $lead->email)); ?>"
                               class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent">
                        <?php $__errorArgs = ['email'];
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

                    <!-- Presupuesto -->
                    <div>
                        <label for="budget" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Presupuesto
                        </label>
                        <input type="number" 
                               name="budget" 
                               id="budget"
                               min="0"
                               step="0.01"
                               value="<?php echo e(old('budget', $lead->budget)); ?>"
                               class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent">
                        <?php $__errorArgs = ['budget'];
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

                    <!-- Fuente -->
                    <div>
                        <label for="source" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Fuente del Lead
                        </label>
                        <select name="source" 
                                id="source"
                                class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent">
                            <option value="">Seleccionar...</option>
                            <option value="web" <?php echo e(old('source', $lead->source) === 'web' ? 'selected' : ''); ?>>Sitio Web</option>
                            <option value="phone" <?php echo e(old('source', $lead->source) === 'phone' ? 'selected' : ''); ?>>Teléfono</option>
                            <option value="social_media" <?php echo e(old('source', $lead->source) === 'social_media' ? 'selected' : ''); ?>>Redes Sociales</option>
                            <option value="referral" <?php echo e(old('source', $lead->source) === 'referral' ? 'selected' : ''); ?>>Referido</option>
                            <option value="walk_in" <?php echo e(old('source', $lead->source) === 'walk_in' ? 'selected' : ''); ?>>Visita Directa</option>
                            <option value="other" <?php echo e(old('source', $lead->source) === 'other' ? 'selected' : ''); ?>>Otro</option>
                        </select>
                        <?php $__errorArgs = ['source'];
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
            </div>

            <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
                <h2 class="text-lg font-semibold text-[hsl(var(--foreground))] mb-4">Detalles del Lead</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Estado -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Estado <span class="text-red-500">*</span>
                        </label>
                        <select name="status" 
                                id="status"
                                required
                                class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent">
                            <option value="new" <?php echo e(old('status', $lead->status) === 'new' ? 'selected' : ''); ?>>Nuevo</option>
                            <option value="contacted" <?php echo e(old('status', $lead->status) === 'contacted' ? 'selected' : ''); ?>>Contactado</option>
                            <option value="interested" <?php echo e(old('status', $lead->status) === 'interested' ? 'selected' : ''); ?>>Interesado</option>
                            <option value="negotiating" <?php echo e(old('status', $lead->status) === 'negotiating' ? 'selected' : ''); ?>>Negociando</option>
                            <option value="won" <?php echo e(old('status', $lead->status) === 'won' ? 'selected' : ''); ?>>Ganado</option>
                            <option value="lost" <?php echo e(old('status', $lead->status) === 'lost' ? 'selected' : ''); ?>>Perdido</option>
                        </select>
                        <?php $__errorArgs = ['status'];
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

                    <!-- Vehículo de Interés -->
                    <div>
                        <label for="vehicle_id" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Vehículo de Interés
                        </label>
                        <select name="vehicle_id" 
                                id="vehicle_id"
                                class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent">
                            <option value="">Sin vehículo específico</option>
                            <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($vehicle->id); ?>" <?php echo e(old('vehicle_id', $lead->vehicle_id) == $vehicle->id ? 'selected' : ''); ?>>
                                <?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?> (<?php echo e($vehicle->year); ?>)
                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['vehicle_id'];
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

                    <!-- Próximo Seguimiento -->
                    <div class="md:col-span-2">
                        <label for="next_follow_up" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Próximo Seguimiento
                        </label>
                        <input type="datetime-local" 
                               name="next_follow_up" 
                               id="next_follow_up"
                               value="<?php echo e(old('next_follow_up', $lead->next_follow_up?->format('Y-m-d\TH:i'))); ?>"
                               class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent">
                        <?php $__errorArgs = ['next_follow_up'];
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

                    <!-- Notas -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Notas / Observaciones
                        </label>
                        <textarea name="notes" 
                                  id="notes"
                                  rows="4"
                                  class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent resize-none"><?php echo e(old('notes', $lead->notes)); ?></textarea>
                        <?php $__errorArgs = ['notes'];
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
            </div>

            <!-- Botones -->
            <div class="flex items-center gap-3">
                <button type="submit" 
                        class="px-6 py-2.5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-semibold transition-opacity">
                    Actualizar Lead
                </button>
                <a href="<?php echo e(route('admin.leads.index')); ?>" 
                   class="px-6 py-2.5 bg-[hsl(var(--secondary))] hover:bg-[hsl(var(--secondary))]/80 text-[hsl(var(--foreground))] rounded-lg font-semibold transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\leads\edit.blade.php ENDPATH**/ ?>