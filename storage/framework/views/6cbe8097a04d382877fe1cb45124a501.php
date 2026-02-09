

<?php $__env->startSection('title', 'Registrar Nueva Agencia - ProyectoAutos SaaS'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .lamborghini-bg {
        position: fixed;
        left: 0;
        top: 0;
        width: 100vw;
        height: 100vh;
        z-index: 0;
        background: url('/storage/lambo.jpg') no-repeat center center;
        background-size: cover;
        filter: blur(8px) brightness(0.7);
        opacity: 0.85;
    }
    .register-container {
        position: relative;
        z-index: 1;
    }
    @media (max-width: 600px) {
        .domain-ext-mobile {
            font-size: 8px !important;
            line-height: 1 !important;
        }
    }
</style>
<div class="lamborghini-bg"></div>
<div class="register-container">
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-2xl">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-[hsl(var(--foreground))] mb-2">Auto Web Pro</h1>
            <p class="text-[hsl(var(--muted-foreground))]">Registra tu agencia y comienza hoy mismo</p>
        </div>

        <!-- Tarjeta de Registro -->
        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg shadow-lg p-8">
            <?php if($errors->any()): ?>
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-lg">
                    <p class="text-red-500 font-semibold mb-2 text-sm">❌ Errores encontrados:</p>
                    <ul class="text-red-400 text-xs space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>• <?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('tenants.register')); ?>" method="POST" class="space-y-5">
                <?php echo csrf_field(); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nombre de la Agencia -->
                    <div class="md:col-span-2">
                        <label for="agencia_name" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                            Nombre de la Agencia <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="agencia_name" 
                               id="agencia_name"
                               required
                               value="<?php echo e(old('agencia_name')); ?>"
                               class="w-full px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="Agencia Mi Auto">
                        <?php $__errorArgs = ['agencia_name'];
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

                    <!-- Nombre del Administrador -->
                    <div>
                        <label for="admin_name" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                            Tu Nombre Completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="admin_name" 
                               id="admin_name"
                               required
                               value="<?php echo e(old('admin_name')); ?>"
                               class="w-full px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="Juan Pérez">
                        <?php $__errorArgs = ['admin_name'];
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

                    <!-- Email del Administrador -->
                    <div>
                        <label for="admin_email" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               name="admin_email" 
                               id="admin_email"
                               required
                               value="<?php echo e(old('admin_email')); ?>"
                               class="w-full px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="tu@email.com">
                        <?php $__errorArgs = ['admin_email'];
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

                    <!-- Contraseña -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                            Contraseña <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               name="password" 
                               id="password"
                               required
                               class="w-full px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="Mínimo 8 caracteres">
                        <?php $__errorArgs = ['password'];
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

                    <!-- Confirmar Contraseña -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                            Confirmar Contraseña <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation"
                               required
                               class="w-full px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="Repetir contraseña">
                    </div>

                    <!-- Dominio -->
                    <div class="md:col-span-2">
                        <label for="domain" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                            Dominio <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="text" 
                                   name="domain" 
                                   id="domain"
                                   required
                                   value="<?php echo e(old('domain')); ?>"
                                   class="flex-1 px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                                   placeholder="miagencia"
                                   oninput="validateDomainInput(this.value)">
                            <span class="text-[hsl(var(--muted-foreground))] font-medium domain-ext-mobile">.misaas.com</span>
                            <span id="domainStatus" class="text-2xl w-6 h-6 flex items-center justify-center"></span>
                        </div>
                        <p class="mt-1 text-xs text-[hsl(var(--muted-foreground))]">
                            Ej: Si pones "miagencia", tu URL será miagencia.misaas.com
                        </p>
                        <p id="domainMessage" class="mt-2 text-sm text-gray-400"></p>
                        <?php $__errorArgs = ['domain'];
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
                        <label for="phone" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                            Teléfono
                        </label>
                        <input type="tel" 
                               name="phone" 
                               id="phone"
                               value="<?php echo e(old('phone')); ?>"
                               class="w-full px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="+54 9 11 1234-5678">
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

                    <!-- Dirección -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                            Dirección
                        </label>
                        <input type="text" 
                               name="address" 
                               id="address"
                               value="<?php echo e(old('address')); ?>"
                               class="w-full px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="Calle Principal 123">
                        <?php $__errorArgs = ['address'];
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

                <!-- Aviso de Términos -->
                

                <!-- Botones -->
                <div class="flex gap-3 pt-4">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-semibold transition-opacity">
                        Registrar Agencia
                    </button>
                    <a href="<?php echo e(route('login')); ?>" 
                       class="flex-1 px-6 py-3 bg-[hsl(var(--secondary))] hover:bg-[hsl(var(--secondary))]/80 text-[hsl(var(--foreground))] rounded-lg font-semibold transition-colors text-center">
                        Ya tengo cuenta
                    </a>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-sm text-[hsl(var(--muted-foreground))]">
            <p>¿Preguntas? <a href="mailto:soporte@proyectoautos.com" class="text-[hsl(var(--primary))] hover:underline">Contacta con soporte</a></p>
        </div>
    </div>
</div>

<script>
let domainValidationTimeout;

function validateDomainInput(domain) {
    const statusSpan = document.getElementById('domainStatus');
    const messageSpan = document.getElementById('domainMessage');

    // Limpiar mensaje anterior
    statusSpan.textContent = '';
    messageSpan.textContent = '';

    if (!domain || domain.length < 3) {
        return;
    }

    // Debounce: esperar a que el usuario deje de escribir
    clearTimeout(domainValidationTimeout);
    domainValidationTimeout = setTimeout(() => {
        fetch(`<?php echo e(route('api.validate-domain')); ?>?domain=${encodeURIComponent(domain)}`)
            .then(response => response.json())
            .then(data => {
                if (data.available) {
                    statusSpan.textContent = '✓';
                    statusSpan.className = 'text-2xl w-6 h-6 flex items-center justify-center text-green-400 font-bold';
                    messageSpan.textContent = data.message;
                    messageSpan.className = 'mt-2 text-sm text-green-400';
                } else {
                    statusSpan.textContent = '✗';
                    statusSpan.className = 'text-2xl w-6 h-6 flex items-center justify-center text-red-400 font-bold';
                    messageSpan.textContent = data.message;
                    messageSpan.className = 'mt-2 text-sm text-red-400';
                }
            })
            .catch(error => {
                console.error('Error validando dominio:', error);
                messageSpan.textContent = 'Error al validar dominio';
                messageSpan.className = 'mt-2 text-sm text-gray-400';
            });
    }, 500); // Esperar 500ms después de que el usuario deje de escribir
}

// Validar dominio al cargar si hay un valor previo
document.addEventListener('DOMContentLoaded', function() {
    const domainInput = document.getElementById('domain');
    if (domainInput.value) {
        validateDomainInput(domainInput.value);
    }
});
</script>
</div>
<?php $__env->stopSection(); ?>
 </div>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos\resources\views/tenants/register.blade.php ENDPATH**/ ?>