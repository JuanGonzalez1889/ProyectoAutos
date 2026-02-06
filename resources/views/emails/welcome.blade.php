@extends('emails.layout')

@section('title', 'Bienvenido a AutoWeb Pro')

@section('content')
<h1>¡Bienvenido a AutoWeb Pro! 🎉</h1>

<p>Hola <strong>{{ $user->name }}</strong>,</p>

<p>
    Estamos emocionados de tenerte a bordo. Tu cuenta ha sido creada exitosamente y ya puedes empezar a construir 
    el sitio web perfecto para tu agencia automotriz.
</p>

<div class="info-box">
    <div class="info-box-header">📋 Datos de Acceso</div>
    <div class="info-row">
        <span class="info-label">Email:</span>
        <span class="info-value">{{ $user->email }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Contraseña:</span>
        <span class="info-value" style="font-family: monospace;">{{ $password }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Agencia:</span>
        <span class="info-value">{{ $tenant->name }}</span>
    </div>
</div>

<p style="background-color: #0f172a; border-left: 3px solid #fbbf24; padding: 12px 16px; border-radius: 4px; margin: 20px 0;">
    <strong style="color: #fbbf24;">⚠️ Importante:</strong> 
    <span style="color: #cbd5e1;">Por seguridad, te recomendamos cambiar tu contraseña después del primer inicio de sesión.</span>
</p>

<a href="{{ $loginUrl }}" class="button">Iniciar Sesión Ahora</a>

<div class="divider"></div>

<h2>🚀 Próximos Pasos</h2>

<ul>
    <li><strong>Personaliza tu sitio:</strong> Elige entre 4 plantillas profesionales (Moderno, Minimalista, Clásico, Deportivo)</li>
    <li><strong>Agrega vehículos:</strong> Carga tu catálogo completo con fotos y detalles</li>
    <li><strong>Configura formularios:</strong> Empieza a capturar leads desde el primer día</li>
    <li><strong>Explora el dashboard:</strong> Gestiona todo desde un solo lugar</li>
</ul>

<div class="divider"></div>

<h2>📚 Recursos Útiles</h2>

<p>Para ayudarte a empezar, hemos preparado estos recursos:</p>

<ul>
    <li><a href="{{ config('app.url') }}/guia-inicio" style="color: #60a5fa;">📖 Guía de Inicio Rápido</a></li>
    <li><a href="{{ config('app.url') }}/video-tutoriales" style="color: #60a5fa;">🎥 Video Tutoriales</a></li>
    <li><a href="{{ config('app.url') }}/mejores-practicas" style="color: #60a5fa;">💡 Mejores Prácticas</a></li>
    <li><a href="{{ config('app.url') }}/faq" style="color: #60a5fa;">❓ Preguntas Frecuentes</a></li>
</ul>

<div class="divider"></div>

<h2>🎁 Tu Prueba Gratuita</h2>

<p>
    Tienes <strong class="highlight">30 días de prueba gratuita</strong> para explorar todas las funcionalidades sin restricciones. 
    No necesitas ingresar una tarjeta de crédito todavía.
</p>

<p>
    Durante este período, podrás:
</p>

<ul>
    <li>Acceder a todas las plantillas premium</li>
    <li>Agregar hasta 50 vehículos</li>
    <li>Recibir leads ilimitados</li>
    <li>Soporte prioritario por email</li>
</ul>

<div class="divider"></div>

<h2>💬 ¿Necesitas Ayuda?</h2>

<p>
    Nuestro equipo está aquí para ayudarte. Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos:
</p>

<ul>
    <li><strong>Email:</strong> <a href="mailto:soporte@autowebpro.com" style="color: #60a5fa;">soporte@autowebpro.com</a></li>
    <li><strong>WhatsApp:</strong> <a href="https://wa.me/5491112345678" style="color: #34d399;">+54 911 1234-5678</a></li>
    <li><strong>Horario:</strong> Lunes a Viernes, 9:00 - 18:00 (GMT-3)</li>
</ul>

<p style="margin-top: 32px;">
    ¡Estamos emocionados de ver crecer tu negocio! 🚀
</p>

<p style="color: #94a3b8; margin-top: 24px;">
    Saludos,<br>
    <strong style="color: #f1f5f9;">El equipo de AutoWeb Pro</strong>
</p>
@endsection
