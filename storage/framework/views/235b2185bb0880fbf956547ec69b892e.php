

<?php $__env->startSection('content'); ?>
    <?php
        $paymentMethod = match (strtolower((string) $invoice->payment_method)) {
            'mercadopago' => 'Mercado Pago',
            'transferencia', 'bank_transfer' => 'Transferencia bancaria',
            'stripe' => 'Stripe',
            default => ucfirst((string) $invoice->payment_method),
        };

        $status = strtolower((string) $invoice->status);
        $statusLabel = match ($status) {
            'paid' => 'Pagada',
            'pending' => 'Pendiente',
            'failed' => 'Fallida',
            'refunded' => 'Reembolsada',
            default => ucfirst((string) $invoice->status),
        };

        $statusClass = match ($status) {
            'paid' => 'status-paid',
            'pending' => 'status-pending',
            'failed' => 'status-failed',
            'refunded' => 'status-refunded',
            default => 'status-default',
        };
    ?>

    <style>
        .invoice-container { width: 100%; }
        .header { width: 100%; margin-bottom: 22px; border-bottom: 2px solid #1f2937; padding-bottom: 14px; }
        .brand-title { font-size: 22px; font-weight: 700; margin: 0; color: #111827; }
        .brand-subtitle { font-size: 12px; color: #6b7280; margin-top: 4px; }
        .invoice-title { font-size: 28px; font-weight: 800; margin: 8px 0 0; color: #111827; }
        .status-chip { display: inline-block; margin-top: 8px; padding: 4px 10px; font-size: 11px; font-weight: 700; border-radius: 999px; }
        .status-paid { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-failed { background: #fee2e2; color: #991b1b; }
        .status-refunded { background: #e0e7ff; color: #3730a3; }
        .status-default { background: #e5e7eb; color: #374151; }
        .section { border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px 14px; margin-bottom: 14px; }
        .section-title { font-size: 12px; text-transform: uppercase; letter-spacing: 0.7px; color: #6b7280; margin-bottom: 10px; font-weight: 700; }
        .row { margin-bottom: 6px; }
        .row:last-child { margin-bottom: 0; }
        .label { font-weight: 700; color: #111827; }
        .value { color: #1f2937; }
        .summary-table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        .summary-table th, .summary-table td { border-bottom: 1px solid #e5e7eb; padding: 8px 6px; text-align: left; }
        .summary-table th { font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px; color: #6b7280; }
        .summary-total td { font-weight: 700; color: #111827; border-bottom: none; }
        .text-right { text-align: right; }
        .footer-note { margin-top: 16px; font-size: 11px; color: #6b7280; }
    </style>

    <div class="invoice-container">
        <div class="header">
            <div class="brand-title">AutoWebPro</div>
            <div class="brand-subtitle"><?php echo e($domain ? $domain->domain : 'Plataforma de gestión para agencias'); ?></div>
            <div class="invoice-title">Factura #<?php echo e($invoice->invoice_number); ?></div>
            <span class="status-chip <?php echo e($statusClass); ?>"><?php echo e($statusLabel); ?></span>
        </div>

        <div class="section">
            <div class="section-title">Datos de facturación</div>
            <div class="row"><span class="label">Fecha:</span> <span class="value"><?php echo e($invoice->created_at->format('d/m/Y')); ?></span></div>
            <div class="row"><span class="label">Método de pago:</span> <span class="value"><?php echo e($paymentMethod); ?></span></div>
            <div class="row"><span class="label">Moneda:</span> <span class="value"><?php echo e(strtoupper((string) $invoice->currency)); ?></span></div>
        </div>

        <div class="section">
            <div class="section-title">Cliente</div>
            <?php if(isset($tenant)): ?>
                <div class="row"><span class="label">Nombre:</span> <span class="value"><?php echo e($tenant->name); ?></span></div>
                <?php if($tenant->billing_address): ?>
                    <div class="row"><span class="label">Dirección:</span> <span class="value"><?php echo e($tenant->billing_address); ?></span></div>
                <?php elseif($tenant->address): ?>
                    <div class="row"><span class="label">Dirección:</span> <span class="value"><?php echo e($tenant->address); ?></span></div>
                <?php endif; ?>
                <?php if($tenant->email): ?>
                    <div class="row"><span class="label">Email:</span> <span class="value"><?php echo e($tenant->email); ?></span></div>
                <?php endif; ?>
                <?php if($tenant->phone): ?>
                    <div class="row"><span class="label">Teléfono:</span> <span class="value"><?php echo e($tenant->phone); ?></span></div>
                <?php endif; ?>
            <?php else: ?>
                <div class="row"><span class="value">N/A</span></div>
            <?php endif; ?>
        </div>

        <div class="section">
            <div class="section-title">Resumen</div>
            <table class="summary-table">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th class="text-right">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo e($invoice->notes ?: 'Suscripción mensual de servicio'); ?></td>
                        <td class="text-right">$<?php echo e(number_format((float) $invoice->amount, 2)); ?></td>
                    </tr>
                    <?php if((float) $invoice->tax > 0): ?>
                    <tr>
                        <td>Impuestos</td>
                        <td class="text-right">$<?php echo e(number_format((float) $invoice->tax, 2)); ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr class="summary-total">
                        <td>Total</td>
                        <td class="text-right">$<?php echo e(number_format((float) $invoice->total, 2)); ?> <?php echo e(strtoupper((string) $invoice->currency)); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer-note">
            Documento generado automáticamente por AutoWebPro.
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pdf', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\invoices\pdf.blade.php ENDPATH**/ ?>