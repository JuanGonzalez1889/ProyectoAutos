

<?php $__env->startSection('title', 'Recordatorio de Renovación'); ?>

<?php $__env->startSection('content'); ?>
<h1>Tu Suscripción se Renueva Pronto 📅</h1>

<p>Hola <strong><?php echo e($user->name); ?></strong>,</p>

<p>
    Este es un recordatorio amigable de que tu suscripción al plan 
    <strong class="highlight"><?php echo e(ucfirst($subscription->plan)); ?></strong> se renovará automáticamente 
    en <strong class="warning"><?php echo e($daysRemaining); ?> días</strong>.
</p>

<div class="info-box">
    <div class="info-box-header">📋 Detalles de Renovación</div>
    <div class="info-row">
        <span class="info-label">Plan actual:</span>
        <span class="info-value"><?php echo e(ucfirst($subscription->plan)); ?></span>
    </div>
    <div class="info-row">
        <span class="info-label">Monto a cobrar:</span>
        <span class="info-value">
            <?php if($subscription->currency === 'USD'): ?>
                $<?php echo e(number_format($subscription->amount, 2)); ?> USD
            <?php else: ?>
                $<?php echo e(number_format($subscription->amount, 0)); ?> ARS
            <?php endif; ?>
        </span>
    </div>
    <div class="info-row">
        <span class="info-label">Fecha de renovación:</span>
        <span class="info-value"><?php echo e($subscription->current_period_end->format('d/m/Y')); ?></span>
    </div>
    <div class="info-row">
        <span class="info-label">Método de pago:</span>
        <span class="info-value"><?php echo e($subscription->payment_method === 'stripe' ? 'Stripe' : 'MercadoPago'); ?></span>
    </div>
</div>

<p style="background-color: #0f172a; border-left: 3px solid #60a5fa; padding: 12px 16px; border-radius: 4px; margin: 20px 0;">
    <strong style="color: #60a5fa;">ℹ️ Información:</strong> 
    <span style="color: #cbd5e1;">Tu suscripción se renovará automáticamente. No necesitas hacer nada si deseas continuar.</span>
</p>

<div class="divider"></div>

<h2>✅ Verifica tu Método de Pago</h2>

<p>
    Asegúrate de que tu método de pago esté actualizado para evitar interrupciones en el servicio. 
    Puedes verificar y actualizar tu información de pago en cualquier momento.
</p>

<a href="<?php echo e($billingUrl); ?>" class="button">Gestionar Facturación</a>

<div class="divider"></div>

<h2>🔄 ¿Quieres Cambiar de Plan?</h2>

<p>
    Si estás considerando actualizar o cambiar a otro plan, ahora es el momento perfecto. 
    Puedes hacerlo antes de la renovación y el cambio se aplicará inmediatamente.
</p>

<?php if($subscription->plan === 'basic'): ?>
<p style="background-color: #0f172a; border-left: 3px solid #34d399; padding: 12px 16px; border-radius: 4px; margin: 20px 0;">
    <strong style="color: #34d399;">💡 Sugerencia:</strong> 
    <span style="color: #cbd5e1;">
        El plan <strong>Premium</strong> te ofrece 40 vehículos adicionales, 4 plantillas, analytics avanzado 
        y soporte prioritario por solo $50 USD/mes más.
    </span>
</p>
<?php elseif($subscription->plan === 'premium'): ?>
<p style="background-color: #0f172a; border-left: 3px solid #34d399; padding: 12px 16px; border-radius: 4px; margin: 20px 0;">
    <strong style="color: #34d399;">⭐ Upgrade:</strong> 
    <span style="color: #cbd5e1;">
        El plan <strong>Enterprise</strong> incluye vehículos ilimitados, plantillas personalizadas, 
        soporte 24/7 y acceso a la API.
    </span>
</p>
<?php endif; ?>

<a href="<?php echo e($plansUrl); ?>" class="button" style="background: linear-gradient(135deg, #34d399 0%, #10b981 100%);">Ver Planes Disponibles</a>

<div class="divider"></div>

<h2>❌ ¿Necesitas Cancelar?</h2>

<p>
    Si decides no continuar, puedes cancelar tu suscripción en cualquier momento desde tu panel de facturación. 
    Mantendrás el acceso hasta el final de tu período actual.
</p>

<p style="color: #94a3b8; font-size: 14px;">
    <strong>Importante:</strong> Si cancelas, perderás acceso a:
</p>

<ul style="color: #94a3b8; font-size: 14px;">
    <li>Tu catálogo publicado de vehículos</li>
    <li>Leads capturados</li>
    <li>Analytics e informes</li>
    <li>Configuraciones personalizadas</li>
</ul>

<div class="divider"></div>

<h2>💬 ¿Tienes Preguntas?</h2>

<p>
    Si tienes alguna duda sobre tu facturación, plan o cualquier otra consulta, estamos aquí para ayudarte:
</p>

<ul>
    <li><strong>Email:</strong> <a href="mailto:soporte@autowebpro.com" style="color: #60a5fa;">soporte@autowebpro.com</a></li>
    <li><strong>WhatsApp:</strong> <a href="https://wa.me/5491112345678" style="color: #34d399;">+54 911 1234-5678</a></li>
</ul>

<p style="margin-top: 32px; color: #cbd5e1;">
    Gracias por ser parte de AutoWeb Pro 🚀
</p>

<p style="color: #94a3b8; margin-top: 24px;">
    Saludos,<br>
    <strong style="color: #f1f5f9;">El equipo de AutoWeb Pro</strong>
</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\emails\payment-reminder.blade.php ENDPATH**/ ?>