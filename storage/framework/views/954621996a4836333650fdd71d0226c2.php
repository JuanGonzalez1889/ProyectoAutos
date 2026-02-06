

<?php $__env->startSection('title', 'Configurar Mi Landing Page'); ?>
<?php $__env->startSection('page-title', 'Configurar Mi Landing Page'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-6">
        <div>
            <h3 class="text-xl font-semibold text-white">Configurar Landing Page</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Personaliza el aspecto de tu sitio público</p>
        </div>
    </div>

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

    <?php if(session('success')): ?>
        <div class="card border-l-4 border-l-green-500 bg-green-500/5">
            <p class="text-green-400"><?php echo e(session('success')); ?></p>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.landing-config.update')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>

        <!-- Sección: Información General -->
        <div class="card">
            <h4 class="text-lg font-semibold text-white mb-4">📋 Información General</h4>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Plantilla de Landing</label>
                    <select name="template" class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                        <option value="">Seleccionar plantilla...</option>
                        <option value="moderno" <?php echo e(old('template', $settings->template) === 'moderno' ? 'selected' : ''); ?>>🎨 Moderno - Hero grande + Grid</option>
                        <option value="minimalista" <?php echo e(old('template', $settings->template) === 'minimalista' ? 'selected' : ''); ?>>📋 Minimalista - Simple y Directo</option>
                        <option value="clasico" <?php echo e(old('template', $settings->template) === 'clasico' ? 'selected' : ''); ?>>👔 Clásico - Profesional</option>
                        <option value="deportivo" <?php echo e(old('template', $settings->template) === 'deportivo' ? 'selected' : ''); ?>>⚡ Deportivo - Potencia</option>
                    </select>
                    <p class="text-xs text-[hsl(var(--muted-foreground))] mt-1">Elige el diseño que mejor represente tu agencia</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Descripción Principal</label>
                    <textarea name="home_description" 
                              rows="4"
                              placeholder="Describe qué ofrece tu agencia..."
                              class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]"><?php echo e(old('home_description', $settings->home_description)); ?></textarea>
                    <p class="text-xs text-[hsl(var(--muted-foreground))] mt-1">Máximo 1000 caracteres</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Mensaje de Contacto</label>
                    <textarea name="contact_message" 
                              rows="3"
                              placeholder="Mensaje que aparecerá en el formulario de contacto..."
                              class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]"><?php echo e(old('contact_message', $settings->contact_message)); ?></textarea>
                </div>
            </div>
        </div>

        <!-- Sección: Colores -->
        <div class="card">
            <h4 class="text-lg font-semibold text-white mb-4">🎨 Colores</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Color Primario</label>
                    <div class="flex items-center gap-3">
                        <input type="color" 
                               name="primary_color" 
                               value="<?php echo e(old('primary_color', $settings->primary_color ?? '#00d084')); ?>"
                               class="h-10 w-20 rounded cursor-pointer">
                        <input type="text" 
                               placeholder="#00d084"
                               value="<?php echo e(old('primary_color', $settings->primary_color ?? '#00d084')); ?>"
                               class="flex-1 h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Color Secundario</label>
                    <div class="flex items-center gap-3">
                        <input type="color" 
                               name="secondary_color" 
                               value="<?php echo e(old('secondary_color', $settings->secondary_color ?? '#0a0f14')); ?>"
                               class="h-10 w-20 rounded cursor-pointer">
                        <input type="text" 
                               placeholder="#0a0f14"
                               value="<?php echo e(old('secondary_color', $settings->secondary_color ?? '#0a0f14')); ?>"
                               class="flex-1 h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: URLs de Imágenes -->
        <div class="card">
            <h4 class="text-lg font-semibold text-white mb-4">🖼️ Imágenes</h4>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">URL del Logo</label>
                    <input type="url" 
                           name="logo_url" 
                           placeholder="https://ejemplo.com/logo.png"
                           value="<?php echo e(old('logo_url', $settings->logo_url)); ?>"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-white mb-2">URL del Banner Principal</label>
                    <input type="url" 
                           name="banner_url" 
                           placeholder="https://ejemplo.com/banner.jpg"
                           value="<?php echo e(old('banner_url', $settings->banner_url)); ?>"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>
            </div>
        </div>

        <!-- Sección: Contacto -->
        <div class="card">
            <h4 class="text-lg font-semibold text-white mb-4">📞 Información de Contacto</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Teléfono</label>
                    <input type="text" 
                           name="phone" 
                           placeholder="+54 9 11 1234-5678"
                           value="<?php echo e(old('phone', $settings->phone)); ?>"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Email</label>
                    <input type="email" 
                           name="email" 
                           placeholder="contacto@agencia.com"
                           value="<?php echo e(old('email', $settings->email)); ?>"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-white mb-2">WhatsApp</label>
                    <input type="text" 
                           name="whatsapp" 
                           placeholder="+54 9 11 1234-5678"
                           value="<?php echo e(old('whatsapp', $settings->whatsapp)); ?>"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>
            </div>
        </div>

        <!-- Sección: Redes Sociales -->
        <div class="card">
            <h4 class="text-lg font-semibold text-white mb-4">🔗 Redes Sociales</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Facebook</label>
                    <input type="url" 
                           name="facebook_url" 
                           placeholder="https://facebook.com/..."
                           value="<?php echo e(old('facebook_url', $settings->facebook_url)); ?>"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Instagram</label>
                    <input type="url" 
                           name="instagram_url" 
                           placeholder="https://instagram.com/..."
                           value="<?php echo e(old('instagram_url', $settings->instagram_url)); ?>"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-white mb-2">LinkedIn</label>
                    <input type="url" 
                           name="linkedin_url" 
                           placeholder="https://linkedin.com/..."
                           value="<?php echo e(old('linkedin_url', $settings->linkedin_url)); ?>"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>
            </div>
        </div>

        <!-- Sección: Opciones -->
        <div class="card">
            <h4 class="text-lg font-semibold text-white mb-4">⚙️ Opciones</h4>
            
            <div class="space-y-3">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" 
                           name="show_contact_form" 
                           value="1"
                           <?php echo e(old('show_contact_form', $settings->show_contact_form) ? 'checked' : ''); ?>

                           class="rounded">
                    <span class="text-sm text-white">Mostrar formulario de contacto en la landing</span>
                </label>

                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" 
                           name="show_vehicles" 
                           value="1"
                           <?php echo e(old('show_vehicles', $settings->show_vehicles) ? 'checked' : ''); ?>

                           class="rounded">
                    <span class="text-sm text-white">Mostrar catálogo de vehículos</span>
                </label>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex gap-3">
            <button type="submit" class="flex-1 h-10 px-6 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg transition font-semibold">
                💾 Guardar Configuración
            </button>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex-1 h-10 px-6 bg-[hsl(var(--muted))] hover:bg-[hsl(var(--muted))]/80 text-[hsl(var(--muted-foreground))] rounded-lg transition font-semibold text-center flex items-center justify-center">
                Cancelar
            </a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos\resources\views/admin/landing-config/show.blade.php ENDPATH**/ ?>