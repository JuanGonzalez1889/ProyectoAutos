

<?php $__env->startSection('title', 'Pago Rechazado'); ?>
<?php $__env->startSection('page-title', 'Estado de Suscripción'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <div class="card">
        <div class="p-6">
            <div class="flex items-start gap-4 mb-6">
                <div class="w-12 h-12 rounded-full bg-red-500/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>

                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-white mb-2">No pudimos renovar tu suscripción</h2>
                    <p class="text-sm text-[hsl(var(--muted-foreground))] mb-4">
                        Tu panel quedó pausado hasta que el pago se procese correctamente.
                    </p>

                    <div class="rounded-lg border border-red-500/30 bg-red-500/10 p-4 mb-6">
                        <p class="text-xs text-red-300 uppercase tracking-wide mb-1">Motivo del rechazo</p>
                        <p class="text-sm text-red-100"><?php echo e($reason); ?></p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <form action="<?php echo e(route('subscriptions.retry')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                    class="h-10 px-5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity">
                                Reintentar pago
                            </button>
                        </form>

                        <a href="<?php echo e(route('subscriptions.index')); ?>"
                           class="h-10 px-5 border border-[hsl(var(--border))] text-white rounded-lg text-sm font-medium flex items-center">
                            Ver planes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\subscriptions\rejected.blade.php ENDPATH**/ ?>