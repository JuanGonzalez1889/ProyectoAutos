@extends('layouts.guest')

@section('title', 'Términos y Condiciones')

@section('content')
<div class="min-h-screen bg-[#0a0f14] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="card">
            <div class="p-8">
                <h1 class="text-3xl font-bold text-white mb-2">Términos y Condiciones</h1>
                <p class="text-sm text-[hsl(var(--muted-foreground))] mb-8">Última actualización: {{ date('d/m/Y') }}</p>
                
                <div class="prose prose-invert max-w-none">
                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">1. Aceptación de Términos</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        Al acceder y utilizar AutoWeb Pro ("el Servicio"), usted acepta cumplir y estar sujeto a los siguientes términos y condiciones de uso. Si no está de acuerdo con alguno de estos términos, no debe utilizar el Servicio.
                    </p>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">2. Descripción del Servicio</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        AutoWeb Pro es una plataforma SaaS (Software as a Service) que permite a agencias automotrices crear y gestionar su presencia en línea, incluyendo:
                    </p>
                    <ul class="list-disc pl-6 text-[hsl(var(--muted-foreground))] mb-4">
                        <li>Creación de sitios web personalizados</li>
                        <li>Gestión de catálogo de vehículos</li>
                        <li>Sistema de gestión de leads</li>
                        <li>Herramientas de análisis y reportes</li>
                    </ul>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">3. Planes y Pagos</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        <strong>3.1 Planes de Suscripción:</strong> Ofrecemos tres planes de suscripción: Básico, Premium y Enterprise. Los detalles y precios de cada plan están disponibles en nuestra página de precios.
                    </p>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        <strong>3.2 Período de Prueba:</strong> Todos los nuevos usuarios reciben un período de prueba gratuito de 30 días. No se requiere tarjeta de crédito para comenzar la prueba.
                    </p>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        <strong>3.3 Facturación:</strong> Las suscripciones se facturan mensualmente por adelantado. Los cargos son no reembolsables excepto según lo requerido por la ley.
                    </p>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        <strong>3.4 Renovación Automática:</strong> Su suscripción se renovará automáticamente al final de cada período de facturación a menos que la cancele antes de la fecha de renovación.
                    </p>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">4. Cancelación y Reembolsos</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        <strong>4.1 Cancelación:</strong> Puede cancelar su suscripción en cualquier momento desde su panel de control. La cancelación será efectiva al final del período de facturación actual.
                    </p>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        <strong>4.2 Acceso Post-Cancelación:</strong> Después de la cancelación, mantendrá acceso a su cuenta hasta el final del período pagado. Sus datos se conservarán durante 30 días adicionales.
                    </p>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        <strong>4.3 Política de Reembolso:</strong> No ofrecemos reembolsos por períodos parciales. Si cancela, no recibirá un reembolso prorrateado.
                    </p>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">5. Uso Aceptable</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        Usted se compromete a no:
                    </p>
                    <ul class="list-disc pl-6 text-[hsl(var(--muted-foreground))] mb-4">
                        <li>Utilizar el Servicio para fines ilegales o no autorizados</li>
                        <li>Violar leyes en su jurisdicción</li>
                        <li>Cargar contenido que infrinja derechos de propiedad intelectual</li>
                        <li>Intentar obtener acceso no autorizado a sistemas o redes</li>
                        <li>Interferir con el funcionamiento del Servicio</li>
                        <li>Revender o redistribuir el Servicio sin autorización</li>
                    </ul>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">6. Propiedad Intelectual</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        <strong>6.1 Propiedad del Software:</strong> AutoWeb Pro y todo el software relacionado son propiedad de [Nombre de la Empresa] y están protegidos por leyes de propiedad intelectual.
                    </p>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        <strong>6.2 Su Contenido:</strong> Usted conserva todos los derechos sobre el contenido que carga al Servicio (imágenes, textos, datos de vehículos, etc.). Nos otorga una licencia para almacenar y mostrar ese contenido según sea necesario para proporcionar el Servicio.
                    </p>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">7. Limitación de Responsabilidad</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        El Servicio se proporciona "tal cual" sin garantías de ningún tipo. En la medida máxima permitida por la ley, no seremos responsables por:
                    </p>
                    <ul class="list-disc pl-6 text-[hsl(var(--muted-foreground))] mb-4">
                        <li>Pérdida de ingresos o ganancias</li>
                        <li>Pérdida de datos o información</li>
                        <li>Interrupción del servicio</li>
                        <li>Daños indirectos, incidentales o consecuentes</li>
                    </ul>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">8. Modificaciones</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        Nos reservamos el derecho de modificar estos términos en cualquier momento. Le notificaremos sobre cambios significativos por correo electrónico. El uso continuado del Servicio después de dichos cambios constituye su aceptación de los nuevos términos.
                    </p>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">9. Jurisdicción y Ley Aplicable</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        Estos términos se regirán e interpretarán de acuerdo con las leyes de [Jurisdicción]. Cualquier disputa se resolverá en los tribunales de [Jurisdicción].
                    </p>

                    <h2 class="text-2xl font-semibold text-white mt-8 mb-4">10. Contacto</h2>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">
                        Para preguntas sobre estos términos, contáctenos:
                    </p>
                    <ul class="list-none text-[hsl(var(--muted-foreground))] mb-4">
                        <li><strong>Email:</strong> legal@autowebpro.com</li>
                        <li><strong>Dirección:</strong> [Dirección de la Empresa]</li>
                        <li><strong>Teléfono:</strong> +54 11 5555-0000</li>
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
