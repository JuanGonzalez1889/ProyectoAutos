

<?php $__env->startSection('title', 'Próximamente - AutoWeb Pro'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginala591787d01fe92c5706972626cdf7231 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala591787d01fe92c5706972626cdf7231 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar','data' => ['ctaLabel' => 'Notificarme','ctaLink' => '#notificarme','ctaClass' => 'bg-white/10 hover:bg-white/20 border border-white/10 text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['cta-label' => 'Notificarme','cta-link' => '#notificarme','cta-class' => 'bg-white/10 hover:bg-white/20 border border-white/10 text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $attributes = $__attributesOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__attributesOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $component = $__componentOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__componentOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>

<section class="pt-32 pb-16 px-4">
    <div class="max-w-6xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 rounded-full mb-6">
            <span class="w-2 h-2 bg-purple-400 rounded-full animate-pulse"></span>
            <span class="text-xs text-purple-200 tracking-widest">EN DESARROLLO ACTIVO</span>
        </div>

        <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">
            El futuro de la venta automotriz
            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-500">
                está muy cerca.
            </span>
        </h1>
        <p class="text-base md:text-lg text-gray-400 max-w-2xl mx-auto">
            Estamos construyendo herramientas avanzadas para potenciar tu concesionaria. Experimenta el siguiente nivel de gestión con funciones diseñadas para maximizar tu alcance.
        </p>
    </div>
</section>

<section class="pb-20 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Multipublicador Card (Constelación) -->
        <div class="lg:col-span-2 relative bg-slate-900/40 backdrop-blur-2xl border border-slate-800 rounded-3xl p-12 overflow-hidden group hover:filter-none transition-all duration-300 filter blur-[1px] hover:blur-[0px]">
            <!-- Resplandor azul de fondo -->
            <div class="absolute inset-0 bg-blue-600/10 blur-[100px] rounded-full"></div>
            
            <!-- SVG Connector Lines -->
            <svg class="absolute inset-0 w-full h-full" style="pointer-events: none;">
                <!-- Línea a Mercado Libre (top-left) -->
                <line x1="50%" y1="50%" x2="25%" y2="20%" stroke="#3b82f6" stroke-width="2" stroke-dasharray="5,5" opacity="0.3" class="transition-opacity duration-300 group-hover:opacity-50"/>
                <!-- Línea a Marketplace (bottom-left) -->
                <line x1="50%" y1="50%" x2="20%" y2="75%" stroke="#3b82f6" stroke-width="2" stroke-dasharray="5,5" opacity="0.3" class="transition-opacity duration-300 group-hover:opacity-50"/>
                <!-- Línea a RosarioGarage (bottom-right) -->
                <line x1="50%" y1="50%" x2="80%" y2="75%" stroke="#3b82f6" stroke-width="2" stroke-dasharray="5,5" opacity="0.3" class="transition-opacity duration-300 group-hover:opacity-50"/>
                <!-- Línea a Instagram (top-right) -->
                <line x1="50%" y1="50%" x2="75%" y2="20%" stroke="#3b82f6" stroke-width="2" stroke-dasharray="5,5" opacity="0.3" class="transition-opacity duration-300 group-hover:opacity-50"/>
            </svg>

            <div class="relative h-96 flex flex-col items-center justify-center">
                <!-- Etiqueta Próximamente -->
                <div class="absolute top-0 flex justify-center w-full mb-8">
                    <span class="bg-blue-500/20 text-blue-400 border border-blue-500/30 rounded-full px-4 py-1 text-xs uppercase font-bold tracking-widest">Próximamente</span>
                </div>

                <!-- Núcleo Central (AutoWeb Pro) -->
                <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-20">
                    <div class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center shadow-[0_0_40px_rgba(37,99,235,0.6)] border-2 border-blue-500/50 relative">
                        <!-- Check Icon -->
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Satélites - Top Left (Mercado Libre) -->
                <div class="absolute top-8 left-8 group-hover:animate-bounce" style="animation-delay: 0s;">
                    <div class="w-20 h-20 bg-slate-950 border border-slate-800 rounded-full flex items-center justify-center hover:border-blue-500/50 transition-all">
                        <img src="/storage/ml.png" alt="Mercado Libre" class="w-10 h-10 object-contain" />
                    </div>
                    <p class="text-xs text-gray-400 text-center mt-2">Mercado Libre</p>
                </div>

                <!-- Satélites - Bottom Left (Marketplace) -->
                <div class="absolute bottom-8 left-8 group-hover:animate-bounce" style="animation-delay: 0.2s;">
                    <div class="w-20 h-20 bg-slate-950 border border-slate-800 rounded-full flex items-center justify-center hover:border-blue-500/50 transition-all">
                        <svg viewBox="0 0 100 100" class="w-10 h-10">
                            <circle cx="50" cy="50" r="48" fill="#1e293b" stroke="#3b82f6" stroke-width="2"/>
                            <path d="M30 40h40l5 15H25l5-15zM25 55h50v20H25V55z" fill="#0866FF"/>
                            <rect x="42" y="60" width="16" height="15" fill="#1e293b"/>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-400 text-center mt-2">Marketplace</p>
                </div>

                <!-- Satélites - Bottom Right (RosarioGarage) -->
                <div class="absolute bottom-8 right-8 group-hover:animate-bounce" style="animation-delay: 0.4s;">
                    <div class="w-20 h-20 bg-slate-950 border border-slate-800 rounded-full flex items-center justify-center hover:border-blue-500/50 transition-all">
                        <svg viewBox="0 0 100 100" class="w-10 h-10">
                            <circle cx="50" cy="50" r="48" fill="#1e293b" stroke="#3b82f6" stroke-width="2"/>
                            <path d="M50 25c-11 0-20 9-20 20 0 15 20 30 20 30s20-15 20-30c0-11-9-20-20-20z" fill="#EF4444"/>
                            <text x="50" y="52" text-anchor="middle" fill="white" font-family="Arial" font-weight="bold" font-size="20">R</text>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-400 text-center mt-2">RosarioGarage</p>
                </div>

                <!-- Satélites - Top Right (Instagram) -->
                <div class="absolute top-8 right-8 group-hover:animate-bounce" style="animation-delay: 0.6s;">
                    <div class="w-20 h-20 bg-slate-950 border border-slate-800 rounded-full flex items-center justify-center hover:border-blue-500/50 transition-all">
                        <svg viewBox="0 0 100 100" class="w-10 h-10">
                            <circle cx="50" cy="50" r="48" fill="#1e293b" stroke="#3b82f6" stroke-width="2"/>
                            <rect x="30" y="30" width="40" height="40" rx="10" stroke="url(#insta-grad)" stroke-width="4" fill="none"/>
                            <circle cx="50" cy="50" r="10" stroke="url(#insta-grad)" stroke-width="4" fill="none"/>
                            <circle cx="62" cy="38" r="3" fill="url(#insta-grad)"/>
                            <defs>
                                <linearGradient id="insta-grad" x1="0%" y1="100%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:#f09433"/>
                                    <stop offset="25%" style="stop-color:#e6683c"/>
                                    <stop offset="50%" style="stop-color:#dc2743"/>
                                    <stop offset="75%" style="stop-color:#cc2366"/>
                                    <stop offset="100%" style="stop-color:#bc1888"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-400 text-center mt-2">Instagram</p>
                </div>
            </div>

            <!-- Texto y descripción (debajo) -->
            <div class="relative text-center mt-8">
                <h3 class="text-2xl md:text-3xl font-bold text-white mb-2">Sincronización Total</h3>
                <p class="text-slate-400 text-sm md:text-base">Publica en todos los portales con un solo click</p>
            </div>
        </div>

        <div class="flex flex-col gap-6">
            <!-- Vendedor IA -->
            <div class="rounded-2xl border border-white/10 bg-slate-900/40 backdrop-blur-md p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-purple-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3-1.343 3-3S13.657 2 12 2 9 3.343 9 5s1.343 3 3 3zm0 2c-2.761 0-5 2.239-5 5v5h10v-5c0-2.761-2.239-5-5-5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Vendedor IA</h3>
                </div>
                <p class="text-sm text-gray-400 mb-4">Un asistente virtual que atiende consultas 24/7, califica leads y agenda visitas automáticamente.</p>
                <div class="bg-white/5 rounded-lg p-3 text-xs text-gray-300">
                    <p class="mb-2">👤 Hola, ¿el Corolla sigue disponible?</p>
                    <p>🤖 ¡Sí! Tiene 12,000 km. ¿Te gustaría verlo mañana?</p>
                </div>
            </div>

            <!-- Smart Pricing -->
            <div class="rounded-2xl border border-white/10 bg-slate-900/40 backdrop-blur-md p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3h2v18h-2V3zm-4 8h2v10H7V11zm8 4h2v6h-2v-6z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Smart Pricing</h3>
                </div>
                <p class="text-sm text-gray-400 mb-4">Algoritmos que analizan el mercado en tiempo real para sugerir el precio óptimo de venta.</p>
                <div class="grid grid-cols-5 gap-2 items-end h-20">
                    <div class="bg-blue-500/40 h-6 rounded"></div>
                    <div class="bg-blue-500/40 h-10 rounded"></div>
                    <div class="bg-blue-500/40 h-4 rounded"></div>
                    <div class="bg-blue-500/40 h-14 rounded"></div>
                    <div class="bg-blue-500/40 h-8 rounded"></div>
                </div>
            </div>
        </div>

        <!-- Segunda fila: Boleto Compra Venta + Integración Redes Sociales -->
        <div class="lg:col-span-3 grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Boleto Compra Venta -->
            <div class="rounded-2xl border border-white/10 bg-slate-900/40 backdrop-blur-md p-6 group hover:border-emerald-500/30 transition-all duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-emerald-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Boleto Compra Venta</h3>
                </div>
                <p class="text-sm text-gray-400 mb-4">Generá boletos de compra-venta digitales de forma instantánea. Completá los datos del comprador, vendedor y vehículo, y obtené el documento listo para firmar.</p>
                <div class="bg-white/5 rounded-lg p-4 space-y-3">
                    <!-- Mini preview del documento -->
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-xs text-gray-300">Datos del comprador y vendedor</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-xs text-gray-300">Datos del vehículo (dominio, motor, chasis)</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-xs text-gray-300">Descarga en PDF listo para firmar</span>
                    </div>
                </div>
            </div>

            <!-- Integración Redes Sociales (Leads) -->
            <div class="rounded-2xl border border-white/10 bg-slate-900/40 backdrop-blur-md p-6 group hover:border-orange-500/30 transition-all duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-orange-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Leads desde Redes Sociales</h3>
                </div>
                <p class="text-sm text-gray-400 mb-4">Cada mensaje que llega por WhatsApp, Facebook o Instagram se convierte automáticamente en un nuevo lead dentro de tu CRM, sin perder ninguna oportunidad de venta.</p>
                <div class="flex items-center gap-4 mt-2">
                    <!-- WhatsApp -->
                    <div class="flex flex-col items-center gap-1">
                        <div class="w-12 h-12 bg-green-500/20 border border-green-500/30 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-green-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </div>
                        <span class="text-[10px] text-gray-500">WhatsApp</span>
                    </div>
                    <!-- Facebook -->
                    <div class="flex flex-col items-center gap-1">
                        <div class="w-12 h-12 bg-blue-500/20 border border-blue-500/30 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform" style="transition-delay: 0.1s;">
                            <svg class="w-6 h-6 text-blue-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </div>
                        <span class="text-[10px] text-gray-500">Facebook</span>
                    </div>
                    <!-- Instagram -->
                    <div class="flex flex-col items-center gap-1">
                        <div class="w-12 h-12 bg-pink-500/20 border border-pink-500/30 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform" style="transition-delay: 0.2s;">
                            <svg class="w-6 h-6 text-pink-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                            </svg>
                        </div>
                        <span class="text-[10px] text-gray-500">Instagram</span>
                    </div>
                    <!-- Flecha -->
                    <div class="flex-1 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </div>
                    <!-- CRM -->
                    <div class="flex flex-col items-center gap-1">
                        <div class="w-12 h-12 bg-orange-500/20 border border-orange-500/30 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <span class="text-[10px] text-gray-500">Nuevo Lead</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Tercera fila: Escaneo IA de Patente -->
        <div class="lg:col-span-3">
            <div class="rounded-2xl border border-white/10 bg-slate-900/40 backdrop-blur-md p-8 group hover:border-cyan-500/30 transition-all duration-300 overflow-hidden relative">
                <!-- Resplandor sutil de fondo -->
                <div class="absolute -top-20 -right-20 w-60 h-60 bg-cyan-500/10 blur-[80px] rounded-full"></div>

                <div class="relative grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <!-- Lado izquierdo: info -->
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-lg bg-cyan-500/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Escaneo IA de Patente</h3>
                            <span class="ml-2 bg-cyan-500/20 text-cyan-400 border border-cyan-500/30 rounded-full px-3 py-0.5 text-[10px] uppercase font-bold tracking-widest">IA</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-5">Sacá una foto a la patente del vehículo y nuestra inteligencia artificial extrae automáticamente todos los datos registrales. Sin cargar nada a mano.</p>

                        <!-- Flujo visual -->
                        <div class="flex items-center gap-3 mb-6">
                            <div class="flex items-center gap-2 bg-white/5 rounded-lg px-3 py-2">
                                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="text-xs text-gray-300">Foto</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            <div class="flex items-center gap-2 bg-cyan-500/10 border border-cyan-500/20 rounded-lg px-3 py-2">
                                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-xs text-cyan-300">IA Procesa</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            <div class="flex items-center gap-2 bg-white/5 rounded-lg px-3 py-2">
                                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-xs text-gray-300">Datos</span>
                            </div>
                        </div>
                    </div>

                    <!-- Lado derecho: preview de datos extraídos -->
                    <div class="bg-white/5 rounded-xl p-5 border border-white/5">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-2 h-2 bg-cyan-400 rounded-full animate-pulse"></div>
                            <span class="text-xs text-cyan-400 font-medium uppercase tracking-wider">Datos extraídos</span>
                        </div>
                        <div class="space-y-2.5">
                            <div class="flex justify-between items-center py-1.5 border-b border-white/5">
                                <span class="text-xs text-gray-500">Patente</span>
                                <span class="text-sm text-white font-mono bg-white/5 px-2 py-0.5 rounded">AB 123 CD</span>
                            </div>
                            <div class="flex justify-between items-center py-1.5 border-b border-white/5">
                                <span class="text-xs text-gray-500">Marca / Modelo</span>
                                <span class="text-sm text-white">Toyota Corolla</span>
                            </div>
                            <div class="flex justify-between items-center py-1.5 border-b border-white/5">
                                <span class="text-xs text-gray-500">Año</span>
                                <span class="text-sm text-white">2022</span>
                            </div>
                            <div class="flex justify-between items-center py-1.5 border-b border-white/5">
                                <span class="text-xs text-gray-500">N° de Chasis</span>
                                <span class="text-sm text-white font-mono text-[11px]">9BR53ZEC2N8...</span>
                            </div>
                            <div class="flex justify-between items-center py-1.5 border-b border-white/5">
                                <span class="text-xs text-gray-500">N° de Motor</span>
                                <span class="text-sm text-white font-mono text-[11px]">1NR-U285...</span>
                            </div>
                            <div class="flex justify-between items-center py-1.5 border-b border-white/5">
                                <span class="text-xs text-gray-500">Marca Chasis</span>
                                <span class="text-sm text-white">Toyota</span>
                            </div>
                            <div class="flex justify-between items-center py-1.5 border-b border-white/5">
                                <span class="text-xs text-gray-500">Marca Motor</span>
                                <span class="text-sm text-white">Toyota</span>
                            </div>
                            <div class="flex justify-between items-center py-1.5">
                                <span class="text-xs text-gray-500">Radicación</span>
                                <span class="text-sm text-white">Santa Fe, Rosario</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="notificarme" class="pb-20 px-4">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">¿Quieres acceso anticipado?</h2>
        <p class="text-gray-400 mb-6">Sé el primero en probar el Multipublicador cuando lancemos la beta cerrada.</p>
        <form action="<?php echo e(route('landing.newsletter')); ?>" method="POST" class="flex flex-col sm:flex-row gap-3 justify-center">
            <?php echo csrf_field(); ?>
            <input type="email" name="email" placeholder="Tu correo electrónico" class="w-full sm:w-96 px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-purple-400 transition-all" required>
            <button type="submit" class="px-6 py-3 bg-purple-500 hover:bg-purple-600 rounded-lg font-semibold text-white transition-all">Unirme a la lista</button>
        </form>
        <p class="text-xs text-gray-500 mt-3">No enviamos spam. Solo notificaciones importantes de lanzamiento.</p>
    </div>
</section>

<footer class="border-t border-white/10 py-6 px-4">
    <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-xs text-gray-500">© 2026 AutoWeb Pro. Todos los derechos reservados.</p>
        <div class="flex items-center gap-6 text-xs text-gray-400">
            <a href="#" class="hover:text-white">Privacidad</a>
            <a href="#" class="hover:text-white">Términos</a>
            <a href="#" class="hover:text-white">Contacto</a>
        </div>
    </div>
</footer>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\landing\proximamente.blade.php ENDPATH**/ ?>