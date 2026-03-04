

<?php $__env->startSection('content'); ?>
<div class="container text-center py-5">
    <h1 class="text-danger">¡Pago rechazado!</h1>
    <p>Tu pago no pudo ser procesado. Por favor, intenta nuevamente o utiliza otro método de pago.</p>
    <a href="<?php echo e(route('subscriptions.index')); ?>" class="btn btn-primary mt-3">Volver a las suscripciones</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\subscriptions\failure.blade.php ENDPATH**/ ?>