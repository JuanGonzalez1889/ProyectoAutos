

<?php $__env->startSection('title', 'Suscripción Activada'); ?>

<?php $__env->startSection('content'); ?>
<h1>¡Tu Suscripción está Activa! 🎉</h1>

<p>Hola <strong><?php echo e($user->name); ?></strong>,</p>

<p>
    ¡Excelentes noticias! Tu pago ha sido procesado correctamente y tu suscripción al plan 
    <strong class="highlight"><?php echo e(ucfirst($subscription->plan)); ?></strong> ya está activa.
</p>

<div class="info-box">
    <div class="info-box-header">📋 Detalles de tu Suscripción</div>
    <div class="info-row">
        <span class="info-label">Plan:</span>
        <span class="info-value"><?php echo e(ucfirst($subscription->plan)); ?></span>
    </div>
    <div class="info-row">
        <span class="info-label">Monto:</span>
        <span class="info-value">
            <?php if($subscription->currency === 'USD'): ?>
                $<?php echo e(number_format($subscription->amount, 2)); ?> USD
            <?php else: ?>
                $<?php echo e(number_format($subscription->amount, 0)); ?> ARS
            <?php endif; ?>
        </span>
    </div>
    <div class="info-row">
        <span class="info-label">Período:</span>
        <span class="info-value"><?php echo e($subscription->current_period_start->format('d/m/Y')); ?> - <?php echo e($subscription->current_period_end->format('d/m/Y')); ?></span>
    </div>
    <div class="info-row">
        <span class="info-label">Próxima renovación:</span>
        <span class="info-value"><?php echo e($subscription->current_period_end->format('d/m/Y')); ?></span>
    </div>
    <div class="info-row">
        <span class="info-label">Método de pago:</span>
        <span class="info-value"><?php echo e($subscription->payment_method === 'stripe' ? 'Stripe' : 'MercadoPago'); ?></span>
    </div>
</div>

<div class="info-box">
    <div class="info-box-header">🧾 Información de Factura</div>
    <div class="info-row">
        <span class="info-label">Número de factura:</span>
        <span class="info-value" style="font-family: monospace;"><?php echo e($invoice->invoice_number); ?></span>
    </div>
    <div class="info-row">
        <span class="info-label">Fecha:</span>
        <span class="info-value"><?php echo e($invoice->created_at->format('d/m/Y H:i')); ?></span>
    </div>
    <div class="info-row">
        <span class="info-label">Subtotal:</span>
        <span class="info-value">$<?php echo e(number_format($invoice->amount, 2)); ?></span>
    </div>
    <?php if($invoice->tax > 0): ?>
    <div class="info-row">
        <span class="info-label">IVA:</span>
        <span class="info-value">$<?php echo e(number_format($invoice->tax, 2)); ?></span>
    </div>
    <?php endif; ?>
    <div class="info-row" style="border-top: 2px solid #60a5fa; padding-top: 12px; margin-top: 8px;">
        <span class="info-label"><strong>Total:</strong></span>
        <span class="info-value"><strong>$<?php echo e(number_format($invoice->total, 2)); ?></strong></span>
    </div>
</div>

<a href="<?php echo e($billingUrl); ?>" class="button">Ver Mi Facturación</a>

<div class="divider"></div>

<h2>✨ ¿Qué incluye tu plan <?php echo e(ucfirst($subscription->plan)); ?>?</h2>

<?php if($subscription->plan === 'basic'): ?>
<ul>
    <li><strong>10 vehículos</strong> en catálogo</li>
    <li>1 plantilla básica</li>
    <li>Soporte por email</li>
    <li>Gestión de leads</li>
</ul>
<?php elseif($subscription->plan === 'premium'): ?>
<ul>
    <li><strong>50 vehículos</strong> en catálogo</li>
    <li><strong>4 plantillas</strong> premium (Moderno, Minimalista, Clásico, Deportivo)</li>
    <li>Soporte prioritario</li>
    <li>Analytics avanzado</li>
    <li>SEO optimizado</li>
</ul>
<?php else: ?>
<ul>
    <li><strong>Vehículos ilimitados</strong></li>
    <li>Plantillas <strong>personalizadas</strong></li>
    <li>Soporte <strong>24/7</strong></li>
    <li>Acceso a <strong>API REST</strong></li>
    <li>Multipublicador</li>
    <li>Gestor de cuentas dedicado</li>
</ul>
<?php endif; ?>

<div class="divider"></div>

<h2>🚀 Próximos Pasos</h2>

<p>Ya estás listo para aprovechar al máximo tu suscripción:</p>

<ul>
    <li>Accede a tu <a href="<?php echo e($dashboardUrl); ?>" style="color: #60a5fa;">Dashboard</a> para empezar</li>
    <li>Explora todas las plantillas disponibles</li>
    <li>Agrega tu catálogo de vehículos</li>
    <li>Configura tu dominio personalizado</li>
</ul>

<div class="divider"></div>

<h2>💡 Consejos para el Éxito</h2>

<p style="background-color: #0f172a; border-left: 3px solid #60a5fa; padding: 12px 16px; border-radius: 4px; margin: 20px 0;">
    <strong style="color: #60a5fa;">✨ Tip:</strong> 
    <span style="color: #cbd5e1;">Las agencias que agregan al menos 15 vehículos en la primera semana tienen un 3x más de conversiones de leads.</span>
</p>

<div class="divider"></div>

<h2>📞 ¿Necesitas Ayuda?</h2>

<p>
    Nuestro equipo está disponible para ayudarte a configurar todo:
</p>

<ul>
    <li><strong>Email:</strong> <a href="mailto:soporte@autowebpro.com" style="color: #60a5fa;">soporte@autowebpro.com</a></li>
    <li><strong>WhatsApp:</strong> <a href="https://wa.me/5491112345678" style="color: #34d399;">+54 911 1234-5678</a></li>
    <?php if($subscription->plan === 'enterprise'): ?>
    <li><strong>Teléfono Directo:</strong> <span style="color: #fbbf24;">+54 11 5555-0000</span> (24/7)</li>
    <?php endif; ?>
</ul>

<p style="margin-top: 32px;">
    ¡Gracias por confiar en nosotros! 🙌
</p>

<p style="color: #94a3b8; margin-top: 24px;">
    Saludos,<br>
    <strong style="color: #f1f5f9;">El equipo de AutoWeb Pro</strong>
</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\emails\subscription-confirmed.blade.php ENDPATH**/ ?>