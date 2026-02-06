@extends('layouts.guest')

@section('title', 'Política de Privacidad')

@section('content')
<div class="min-h-screen bg-[#0a0f14] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="card">
            <div class="p-8">
                <h1 class="text-3xl font-bold text-white mb-2">Política de Privacidad</h1>
                <p class="text-sm text-[hsl(var(--muted-foreground))] mb-8">Última actualización: {{ date('d/m/Y') }}</p>
                
                <div class="prose prose-invert max-w-none">
                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">1. Información que Recopilamos</h2>
                    
                    <h3 class="text-xl font-semibold text-white mt-6 mb-3">1.1 Información que Usted Proporciona</h3>
                    <ul class="list-disc pl-6 text-[hsl(var(--muted-foreground))] mb-4">
                        <li><strong>Información de cuenta:</strong> Nombre, email, teléfono, dirección de la agencia</li>
                        <li><strong>Información de pago:</strong> Datos de tarjeta procesados por Stripe/MercadoPago (no almacenamos datos de tarjeta)</li>
                        <li><strong>Contenido:</strong> Vehículos, imágenes, descripciones, datos de contacto</li>
                        <li><strong>Comunicaciones:</strong> Mensajes de soporte, feedback</li>
                    </ul>

                    <h3 class="text-xl font-semibold text-white mt-6 mb-3">1.2 Información Recopilada Automáticamente</h3>
                    <ul class="list-disc pl-6 text-[hsl(var(--muted-foreground))] mb-4">
                        <li><strong>Datos de uso:</strong> Páginas visitadas, funciones utilizadas, tiempo de uso</li>
                        <li><strong>Información del dispositivo:</strong> Dirección IP, navegador, sistema operativo</li>
                        <li><strong>Cookies:</strong> Cookies de sesión, preferencias, analytics</li>
                    </ul>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">2. Cómo Utilizamos Su Información</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        Utilizamos la información recopilada para:
                    </p>
                    <ul class="list-disc pl-6 text-[hsl(var(--muted-foreground))] mb-4">
                        <li>Proporcionar y mantener el Servicio</li>
                        <li>Procesar pagos y transacciones</li>
                        <li>Enviar notificaciones importantes (confirmaciones, recordatorios, alertas)</li>
                        <li>Brindar soporte técnico</li>
                        <li>Mejorar nuestros servicios mediante análisis</li>
                        <li>Prevenir fraudes y abusos</li>
                        <li>Cumplir con obligaciones legales</li>
                    </ul>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">3. Compartir Información</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        <strong>No vendemos sus datos personales.</strong> Compartimos información solo en los siguientes casos:
                    </p>
                    
                    <h3 class="text-xl font-semibold text-white mt-6 mb-3">3.1 Proveedores de Servicios</h3>
                    <ul class="list-disc pl-6 text-[hsl(var(--muted-foreground))] mb-4">
                        <li><strong>Procesamiento de pagos:</strong> Stripe, MercadoPago</li>
                        <li><strong>Hosting:</strong> [Proveedor de hosting/cloud]</li>
                        <li><strong>Email:</strong> [Servicio de email transaccional]</li>
                        <li><strong>Analytics:</strong> Google Analytics</li>
                    </ul>

                    <h3 class="text-xl font-semibold text-white mt-6 mb-3">3.2 Requerimientos Legales</h3>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        Podemos divulgar información si es requerido por ley, orden judicial, o para proteger nuestros derechos.
                    </p>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">4. Seguridad de Datos</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        Implementamos medidas de seguridad técnicas y organizativas para proteger su información:
                    </p>
                    <ul class="list-disc pl-6 text-[hsl(var(--muted-foreground))] mb-4">
                        <li>Cifrado SSL/TLS para transmisión de datos</li>
                        <li>Cifrado de contraseñas con bcrypt</li>
                        <li>Backups diarios encriptados</li>
                        <li>Autenticación de dos factores (disponible)</li>
                        <li>Auditorías de seguridad regulares</li>
                    </ul>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">5. Retención de Datos</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        Conservamos su información mientras su cuenta esté activa y durante:
                    </p>
                    <ul class="list-disc pl-6 text-[hsl(var(--muted-foreground))] mb-4">
                        <li><strong>Datos de cuenta:</strong> 30 días después de la cancelación</li>
                        <li><strong>Datos de facturación:</strong> 7 años (requerimientos fiscales)</li>
                        <li><strong>Logs de acceso:</strong> 90 días</li>
                    </ul>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">6. Sus Derechos (GDPR y CCPA)</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        Usted tiene derecho a:
                    </p>
                    <ul class="list-disc pl-6 text-[hsl(var(--muted-foreground))] mb-4">
                        <li><strong>Acceso:</strong> Solicitar una copia de sus datos</li>
                        <li><strong>Rectificación:</strong> Corregir datos inexactos</li>
                        <li><strong>Eliminación:</strong> Derecho al olvido (con excepciones legales)</li>
                        <li><strong>Portabilidad:</strong> Exportar sus datos en formato estructurado</li>
                        <li><strong>Oposición:</strong> Oponerse al procesamiento de marketing</li>
                        <li><strong>Restricción:</strong> Limitar el procesamiento en ciertos casos</li>
                    </ul>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        Para ejercer estos derechos, contáctenos en privacy@autowebpro.com
                    </p>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">7. Cookies</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        Utilizamos cookies para:
                    </p>
                    <ul class="list-disc pl-6 text-[hsl(var(--muted-foreground))] mb-4">
                        <li><strong>Esenciales:</strong> Autenticación, seguridad (no se pueden deshabilitar)</li>
                        <li><strong>Funcionales:</strong> Preferencias, idioma</li>
                        <li><strong>Analytics:</strong> Google Analytics (puede optar por no participar)</li>
                    </ul>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        Puede controlar las cookies en la configuración de su navegador.
                    </p>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">8. Transferencias Internacionales</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        Sus datos pueden ser procesados en servidores ubicados en diferentes países. Aseguramos que todas las transferencias cumplan con estándares de protección de datos adecuados.
                    </p>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">9. Menores de Edad</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        Nuestro Servicio no está dirigido a menores de 18 años. No recopilamos intencionalmente información de menores. Si descubrimos que hemos recopilado datos de un menor, los eliminaremos inmediatamente.
                    </p>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">10. Cambios a Esta Política</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        Podemos actualizar esta política ocasionalmente. Le notificaremos sobre cambios significativos por email. La fecha de "Última actualización" al inicio indica cuándo se modificó por última vez.
                    </p>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">11. Contacto</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        Para preguntas sobre privacidad o para ejercer sus derechos:
                    </p>
                    <ul class="list-none text-[hsl(var(--muted-foreground))] mb-4">
                        <li><strong>Email:</strong> privacy@autowebpro.com</li>
                        <li><strong>Dirección:</strong> [Dirección de la Empresa]</li>
                        <li><strong>DPO (Delegado de Protección de Datos):</strong> dpo@autowebpro.com</li>
                    </ul>
                </div>

                <div class="mt-8 pt-8 border-t border-[hsl(var(--border))]">
                    <a href="{{ route('landing.home') }}" class="text-blue-400 hover:text-blue-300">← Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
