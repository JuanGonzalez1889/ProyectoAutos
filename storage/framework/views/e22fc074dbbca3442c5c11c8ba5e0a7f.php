

<?php $__env->startSection('title', 'Iniciar Sesión'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex">
    <!-- Left side - Car image -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-[#0a0f14]">
        <img src="https://images.unsplash.com/photo-1583121274602-3e2820c69888?w=1200&h=1200&fit=crop" 
             alt="Luxury Car" 
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

        <!-- AutoManager branding -->
        <div class="absolute bottom-12 left-12 right-12 z-10">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-[hsl(var(--primary))] rounded-md flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#0a0f14]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                        <circle cx="7" cy="17" r="2" />
                        <circle cx="17" cy="17" r="2" />
                    </svg>
                </div>
                <span class="text-white font-bold text-xl"><?php echo e(config('app.name')); ?></span>
            </div>
            <p class="text-white/90 text-base leading-relaxed border-l-2 border-[hsl(var(--primary))] pl-4">
                "La plataforma definitiva para gestionar tu inventario, ventas y clientes en un solo lugar. Eficiencia y control total para tu agencia."
            </p>
            <div class="flex gap-2 mt-4">
                <div class="w-10 h-1 bg-[hsl(var(--primary))] rounded-full"></div>
                <div class="w-2 h-1 bg-white/30 rounded-full"></div>
                <div class="w-2 h-1 bg-white/30 rounded-full"></div>
            </div>
        </div>
    </div>

    <!-- Right side - Login form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center bg-[hsl(var(--background))] p-8">
        <div class="w-full max-w-md space-y-6">
            <!-- Header -->
            <div class="space-y-2 text-center">
                <h1 class="text-3xl font-bold text-white">Bienvenido</h1>
                <p class="text-sm text-[hsl(var(--muted-foreground))]">Gestiona tu agencia con eficiencia y estilo.</p>
            </div>

            <!-- Tabs -->
            <div class="flex border-b border-[hsl(var(--border))]">
                <button class="flex-1 pb-3 text-sm font-medium text-[hsl(var(--primary))] border-b-2 border-[hsl(var(--primary))]">
                    Iniciar Sesión
                </button>
                <!-- Registrarse solo accesible via invitación, no se muestra aquí -->
            </div>

            <!-- Google Button -->
            <a href="<?php echo e(route('auth.google')); ?>" class="w-full flex items-center justify-center px-4 py-3 bg-[#1a1f26] border border-[hsl(var(--border))] hover:bg-[#252b34] rounded-lg transition-colors">
                <svg class="mr-2 h-4 w-4" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span class="text-white text-sm font-medium">Continuar con Google</span>
            </a>

            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <span class="w-full border-t border-[hsl(var(--border))]"></span>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-[hsl(var(--background))] px-2 text-[hsl(var(--muted-foreground))]">O con tu email</span>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>

                <?php if($errors->any()): ?>
                    <div class="bg-red-500/20 border border-red-500/50 text-red-500 px-4 py-3 rounded-lg text-sm">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p><?php echo e($error); ?></p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <div class="space-y-2">
                    <label for="email" class="text-sm text-[hsl(var(--muted-foreground))]">Correo Electrónico</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-[hsl(var(--muted-foreground))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required
                               class="w-full pl-10 pr-4 py-3 bg-[#1a1f26] border border-[hsl(var(--border))] rounded-lg text-white placeholder-[hsl(var(--muted-foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--ring))]"
                               placeholder="ejemplo@agencia.com">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-sm text-[hsl(var(--muted-foreground))]">Contraseña</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-[hsl(var(--muted-foreground))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <input type="password" id="password" name="password" required
                               class="w-full pl-10 pr-4 py-3 bg-[#1a1f26] border border-[hsl(var(--border))] rounded-lg text-white placeholder-[hsl(var(--muted-foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--ring))]"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-[hsl(var(--border))] text-[hsl(var(--primary))] focus:ring-[hsl(var(--ring))]">
                        <label for="remember" class="text-sm text-[hsl(var(--muted-foreground))] cursor-pointer">Recordarme</label>
                    </div>
                    <a href="#" class="text-sm text-[hsl(var(--primary))] hover:underline">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="w-full bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] font-medium py-3 rounded-lg transition-opacity">
                    Acceder al Panel
                </button>
            </form>

            <!-- Crear Nueva Agencia -->
            <div class="pt-4 border-t border-[hsl(var(--border))]">
                <p class="text-sm text-[hsl(var(--muted-foreground))] text-center mb-3">
                    ¿Eres nuevo?
                </p>
                <a href="<?php echo e(route('register')); ?>" class="w-full block px-4 py-3 bg-[#1a1f26] border border-[hsl(var(--primary))] text-[hsl(var(--primary))] font-medium rounded-lg hover:bg-[hsl(var(--primary))]/10 transition-colors text-center">
                    + Registra tu Agencia
                </a>
            </div>

            <!-- Footer -->
            <div class="space-y-3 text-center text-xs text-[hsl(var(--muted-foreground))]">
                <p>
                    Al continuar, aceptas nuestros 
                    <a href="#" class="text-[hsl(var(--primary))] hover:underline">Términos de Servicio</a> 
                    y 
                    <a href="#" class="text-[hsl(var(--primary))] hover:underline">Política de Privacidad</a>.
                </p>
                <p>© <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?> Inc. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos\resources\views/auth/login.blade.php ENDPATH**/ ?>