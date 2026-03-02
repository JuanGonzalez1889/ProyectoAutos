

<?php $__env->startSection('content'); ?>
    <div style="display: flex; align-items: center; margin-bottom: 24px;">
        <img src="https://autowebpro.com.ar/logo-autowebpro.png" alt="AutoWebPro" style="height: 48px; margin-right: 20px;">
        <div>
            <h1 style="margin: 0; font-size: 26px;">Factura #<?php echo e($invoice->invoice_number); ?></h1>
            <div style="font-size: 13px; color: #888;"><?php echo e($domain ? $domain->domain : ''); ?></div>
        </div>
    </div>
    <div class="info">
        <span class="label">Fecha:</span> <?php echo e($invoice->created_at->format('d/m/Y')); ?><br>
        <span class="label">Monto:</span> $<?php echo e(number_format($invoice->total, 2)); ?> <?php echo e(strtoupper($invoice->currency)); ?><br>
        <span class="label">Método de pago:</span> <?php echo e(ucfirst($invoice->payment_method)); ?><br>
        <span class="label">Estado:</span> <?php echo e(ucfirst($invoice->status)); ?><br>
    </div>
    <hr>
    <div class="info">
        <span class="label">Cliente:</span> 
        <?php if(isset($tenant)): ?>
            <?php echo e($tenant->name); ?><br>
            <?php if($tenant->billing_address): ?>
                <span class="label">Dirección:</span> <?php echo e($tenant->billing_address); ?><br>
            <?php elseif($tenant->address): ?>
                <span class="label">Dirección:</span> <?php echo e($tenant->address); ?><br>
            <?php endif; ?>
            <?php if($tenant->email): ?>
                <span class="label">Email:</span> <?php echo e($tenant->email); ?><br>
            <?php endif; ?>
            <?php if($tenant->phone): ?>
                <span class="label">Teléfono:</span> <?php echo e($tenant->phone); ?><br>
            <?php endif; ?>
        <?php else: ?>
            N/A<br>
        <?php endif; ?>
        <span class="label">Descripción:</span> <?php echo e($invoice->description ?? 'N/A'); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pdf', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views/invoices/pdf.blade.php ENDPATH**/ ?>