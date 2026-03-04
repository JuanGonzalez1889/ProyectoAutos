

<?php $__env->startSection('title', 'Problema con tu Pago'); ?>

<?php $__env->startSection('content'); ?>
<h1 style="color: #f87171;">⚠️ Hubo un Problema con tu Pago</h1>

<p>Hola <strong><?php echo e($user->name); ?></strong>,</p>

<p>
    Intentamos procesar el pago de tu suscripción al plan 
    <strong class="highlight"><?php echo e(ucfirst($subscription->plan)); ?></strong>, 
    pero no pudimos completar la transacción.
</p>

<div class="info-box" style="border-color: #f87171;">
    <div class="info-box-header" style="color: #f87171;">⚠️ Detalles del Problema</div>
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
        <span class="info-label">Fecha del intento:</span>
        <span class="info-value"><?php echo e(now()->format('d/m/Y H:i')); ?></span>
    </div>
    <?php if($errorMessage): ?>
    <div class="info-row">
        <span class="info-label">Razón:</span>
        <span class="info-value" style="color: #f87171;"><?php echo e($errorMessage); ?></span>
    </div>
    <?php endif; ?>
</div>

<p style="background-color: #0f172a; border-left: 3px solid #f87171; padding: 12px 16px; border-radius: 4px; margin: 20px 0;">
    <strong style="color: #f87171;">⏰ Acción Requerida:</strong> 
    <span style="color: #cbd5e1;">
        Para evitar la suspensión de tu cuenta, actualiza tu método de pago lo antes posible. 
        Tienes <strong>7 días</strong> antes de que tu cuenta sea suspendida.
    </span>
</p>

<a href="<?php echo e($updatePaymentUrl); ?>" class="button" style="background: linear-gradient(135deg, #f87171 0%, #dc2626 100%);">Actualizar Método de Pago</a>

<div class="divider"></div>

<h2>🔍 Causas Comunes</h2>

<p>Los problemas de pago generalmente ocurren por:</p>

<ul>
    <li><strong>Fondos insuficientes:</strong> Verifica el saldo de tu tarjeta</li>
    <li><strong>Tarjeta vencida:</strong> Comprueba la fecha de vencimiento</li>
    <li><strong>Límite excedido:</strong> Contacta a tu banco para aumentar el límite</li>
    <li><strong>Restricción de seguridad:</strong> Autoriza la transacción con tu banco</li>
    <li><strong>Datos incorrectos:</strong> Verifica que todos los datos sean correctos</li>
</ul>

<div class="divider"></div>

<h2>✅ Cómo Solucionar el Problema</h2>

<p><strong>Opción 1: Actualizar tu Método de Pago Actual</strong></p>
<ul>
    <li>Accede a tu <a href="<?php echo e($billingUrl); ?>" style="color: #60a5fa;">panel de facturación</a></li>
    <li>Actualiza la información de tu tarjeta</li>
    <li>Reintentar el pago automáticamente</li>
</ul>

<p><strong>Opción 2: Agregar un Nuevo Método de Pago</strong></p>
<ul>
    <li>Agrega una tarjeta de crédito/débito diferente</li>
    <li>Selecciónala como método principal</li>
    <li>El cargo se procesará automáticamente</li>
</ul>

<p><strong>Opción 3: Usar Otro Proveedor</strong></p>
<ul>
    <li>Si estabas usando Stripe, prueba con MercadoPago (o viceversa)</li>
    <li>Ambos aceptan pagos locales e internacionales</li>
</ul>

<div class="divider"></div>

<h2>⏰ ¿Qué Pasa Si No Actualizo?</h2>

<p style="color: #94a3b8;">
    Si no actualizas tu método de pago en los próximos 7 días:
</p>

<ul style="color: #94a3b8;">
    <li><strong>Día 1-3:</strong> Recordatorios por email</li>
    <li><strong>Día 4-6:</strong> Acceso limitado a funcionalidades premium</li>
    <li><strong>Día 7:</strong> Suspensión de tu cuenta</li>
    <li><strong>Día 30:</strong> Eliminación permanente de datos</li>
</ul>

<p style="background-color: #0f172a; border-left: 3px solid #fbbf24; padding: 12px 16px; border-radius: 4px; margin: 20px 0;">
    <strong style="color: #fbbf24;">💾 Respaldo de Datos:</strong> 
    <span style="color: #cbd5e1;">
        Te recomendamos hacer un respaldo de tus vehículos y leads antes de que tu cuenta sea suspendida.
    </span>
</p>

<div class="divider"></div>

<h2>🆘 ¿Necesitas Ayuda?</h2>

<p>
    Si tienes problemas para actualizar tu pago o necesitas asistencia, nuestro equipo está disponible para ayudarte:
</p>

<ul>
    <li><strong>Email:</strong> <a href="mailto:soporte@autowebpro.com" style="color: #60a5fa;">soporte@autowebpro.com</a></li>
    <li><strong>WhatsApp:</strong> <a href="https://wa.me/5491112345678" style="color: #34d399;">+54 911 1234-5678</a></li>
    <li><strong>Horario:</strong> Lunes a Viernes, 9:00 - 18:00 (GMT-3)</li>
</ul>

<p style="background-color: #0f172a; border-left: 3px solid #60a5fa; padding: 12px 16px; border-radius: 4px; margin: 20px 0;">
    <strong style="color: #60a5fa;">💡 Tip:</strong> 
    <span style="color: #cbd5e1;">
        Si estás experimentando dificultades financieras temporales, contactanos. 
        Podemos explorar opciones como cambiar a un plan más económico o una extensión de pago.
    </span>
</p>

<div class="divider"></div>

<p style="margin-top: 32px; color: #cbd5e1;">
    Esperamos resolver esto pronto. ¡Estamos aquí para ayudarte! 💙
</p>

<p style="color: #94a3b8; margin-top: 24px;">
    Saludos,<br>
    <strong style="color: #f1f5f9;">El equipo de AutoWeb Pro</strong>
</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\emails\payment-failed.blade.php ENDPATH**/ ?>