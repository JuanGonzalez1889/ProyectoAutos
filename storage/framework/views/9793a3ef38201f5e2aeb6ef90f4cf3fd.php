

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Pagar con MercadoPago</h2>
    <?php if(Auth::check()): ?>
        <p>Usuario logueado: <?php echo e(Auth::user()->email); ?></p>
        <?php if(isset($preferenceId) && isset($publicKey)): ?>
            <!-- Checkout PRO Botón clásico -->
            <script src="https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js"
                data-preference-id="<?php echo e($preferenceId); ?>"
                data-button-label="Pagar con MercadoPago"
                data-public-key="<?php echo e($publicKey); ?>">
            </script>
        <?php else: ?>
            <!-- Botón de pago MercadoPago -->
            <form action="/mercadopago/checkout" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-primary">Pagar con MercadoPago</button>
            </form>
        <?php endif; ?>
        <?php if(isset($mpError) && $mpError): ?>
            <div class="alert alert-danger mt-3">
                <strong>Error MercadoPago:</strong><br>
                <pre><?php echo e($mpError); ?></pre>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p>Debes iniciar sesión para pagar.</p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\mercadopago.blade.php ENDPATH**/ ?>