

<?php $__env->startSection('title', 'Agregar Vehículo'); ?>
<?php $__env->startSection('page-title', 'Agregar Vehículo'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="<?php echo e(route('admin.vehicles.index')); ?>" 
           class="p-2 hover:bg-[hsl(var(--muted))] rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h3 class="text-xl font-semibold text-white">Agregar Nuevo Vehículo</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Completa los datos del vehículo</p>
        </div>
    </div>

    <form action="<?php echo e(route('admin.vehicles.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>

        <!-- Información Básica -->
        <div class="card">
            <h4 class="text-lg font-semibold mb-4">Información Básica</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Título del Anuncio</label>
                    <input type="text" name="title" value="<?php echo e(old('title')); ?>" required
                           placeholder="Ej: Toyota Corolla 2023 - Como Nuevo"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Marca</label>
                    <input type="text" name="brand" value="<?php echo e(old('brand')); ?>" required
                           placeholder="Toyota, Ford, Chevrolet..."
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                    <?php $__errorArgs = ['brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Modelo</label>
                    <input type="text" name="model" value="<?php echo e(old('model')); ?>" required
                           placeholder="Corolla, Fiesta, Cruze..."
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                    <?php $__errorArgs = ['model'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Año</label>
                    <input type="number" name="year" value="<?php echo e(old('year', date('Y'))); ?>" required
                           min="1900" max="<?php echo e(date('Y') + 1); ?>"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                    <?php $__errorArgs = ['year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Precio</label>
                    <input type="number" name="price" value="<?php echo e(old('price')); ?>" required
                           min="0" step="0.01" placeholder="25000"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                    <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Precio Original (opcional)</label>
                    <input type="number" name="price_original" value="<?php echo e(old('price_original')); ?>"
                           min="0" step="0.01" placeholder="30000"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                    <p class="mt-1 text-xs text-[hsl(var(--muted-foreground))]">Para mostrar descuento</p>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Kilómetros</label>
                    <input type="number" name="kilometers" value="<?php echo e(old('kilometers', 0)); ?>"
                           min="0" placeholder="15000"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Color</label>
                    <input type="text" name="color" value="<?php echo e(old('color')); ?>"
                           placeholder="Negro, Blanco, Rojo..."
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Combustible</label>
                    <select name="fuel_type"
                            class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                        <option value="">Seleccionar...</option>
                        <option value="Nafta" <?php echo e(old('fuel_type') === 'Nafta' ? 'selected' : ''); ?>>Nafta</option>
                        <option value="Diesel" <?php echo e(old('fuel_type') === 'Diesel' ? 'selected' : ''); ?>>Diesel</option>
                        <option value="GNC" <?php echo e(old('fuel_type') === 'GNC' ? 'selected' : ''); ?>>GNC</option>
                        <option value="Eléctrico" <?php echo e(old('fuel_type') === 'Eléctrico' ? 'selected' : ''); ?>>Eléctrico</option>
                        <option value="Híbrido" <?php echo e(old('fuel_type') === 'Híbrido' ? 'selected' : ''); ?>>Híbrido</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Transmisión</label>
                    <select name="transmission"
                            class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                        <option value="">Seleccionar...</option>
                        <option value="Manual" <?php echo e(old('transmission') === 'Manual' ? 'selected' : ''); ?>>Manual</option>
                        <option value="Automático" <?php echo e(old('transmission') === 'Automático' ? 'selected' : ''); ?>>Automático</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Placa</label>
                    <input type="text" name="plate" value="<?php echo e(old('plate')); ?>"
                           placeholder="ABC-123"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Descripción</label>
                    <textarea name="description" rows="5" required
                              placeholder="Describe el vehículo, su estado, características especiales..."
                              class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]"><?php echo e(old('description')); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>

        <!-- Imágenes -->
        <div class="card">
            <h4 class="text-lg font-semibold mb-4">Imágenes</h4>
            
            <div>
                <label class="block text-sm font-medium mb-2">Subir Fotos (hasta 10)</label>
                <input type="file" name="images[]" multiple accept="image/*"
                       class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                <p class="mt-2 text-xs text-[hsl(var(--muted-foreground))]">
                    Formatos: JPG, PNG. Tamaño máximo: 5MB por imagen.
                </p>
            </div>
        </div>

        <!-- Datos de Contacto -->
        <div class="card">
            <h4 class="text-lg font-semibold mb-4">Datos de Contacto</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Nombre de Contacto</label>
                    <input type="text" name="contact_name" value="<?php echo e(old('contact_name', auth()->user()->name)); ?>"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Teléfono</label>
                    <input type="text" name="contact_phone" value="<?php echo e(old('contact_phone')); ?>"
                           placeholder="+54 11 1234-5678"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" name="contact_email" value="<?php echo e(old('contact_email', auth()->user()->email)); ?>"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>
            </div>
        </div>

        <!-- Estado y Publicación -->
        <div class="card">
            <h4 class="text-lg font-semibold mb-4">Estado y Publicación</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Estado</label>
                    <select name="status" id="status-select" required
                            class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                        <option value="draft" <?php echo e(old('status', 'published') === 'draft' ? 'selected' : ''); ?>>Borrador</option>
                        <option value="published" <?php echo e(old('status', 'published') === 'published' ? 'selected' : ''); ?>>Publicado</option>
                        <option value="sold" <?php echo e(old('status', 'published') === 'sold' ? 'selected' : ''); ?>>Vendido</option>
                    </select>
                </div>

                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="featured" value="1" <?php echo e(old('featured') ? 'checked' : ''); ?>

                               class="w-4 h-4 rounded border-[hsl(var(--border))] bg-[hsl(var(--background))]">
                        <span class="text-sm">⭐ Marcar como destacado</span>
                    </label>
                    <p class="mt-1 text-xs text-[hsl(var(--muted-foreground))]">Los destacados aparecen primero</p>
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-3">
            <a href="<?php echo e(route('admin.vehicles.index')); ?>" 
               class="h-10 px-5 bg-[hsl(var(--secondary))] hover:bg-[hsl(var(--muted))] rounded-lg text-sm font-medium transition-colors flex items-center">
                Cancelar
            </a>
            <button type="submit" 
                    class="h-10 px-5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Guardar Vehículo
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\admin\vehicles\create.blade.php ENDPATH**/ ?>