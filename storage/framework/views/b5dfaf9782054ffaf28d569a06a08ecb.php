<div x-data="publicacionAnimada()" x-init="initAnimacion($el)" class="w-full max-w-md mx-auto mt-20 p-8 rounded-2xl bg-[#181f2a] shadow-2xl border border-[#232c3b] relative">
    <!-- Barra de progreso -->
    <template x-if="!publicado">
        <div class="flex flex-col items-center">
            <div class="w-full h-3 bg-[#232c3b] rounded-full overflow-hidden mb-8 mt-8">
                <div x-init="iniciarBarra($el)" class="h-full bg-gradient-to-r from-blue-400 to-green-400 transition-all duration-200" style="width: 0%"></div>
            </div>
            <span class="text-white/80 text-lg mt-2 animate-pulse">Publicando tu sitio...</span>
        </div>
    </template>
    <!-- Mensaje de publicado -->
    <template x-if="publicado">
        <div class="flex flex-col items-center animate-fade-in">
            <div class="mb-6 mt-2">
                <div class="rounded-full bg-[#1e2633] p-6 flex items-center justify-center shadow-lg">
                    <svg width="56" height="56" fill="none" viewBox="0 0 56 56"><circle cx="28" cy="28" r="28" fill="#1e2633"/><path d="M18 29.5L25 36.5L38 21.5" stroke="#4ade80" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-white mb-2">¡Sitio Publicado!</h2>
            <a href="https://tuagencia.com" class="text-blue-400 hover:underline text-lg mb-2" target="_blank">https://tuagencia.com</a>
            <div class="flex items-center gap-2 mb-6">
                <span class="h-2 w-2 rounded-full bg-green-400 animate-pulse"></span>
                <span class="text-green-300 text-sm">System Operational</span>
            </div>
            <div class="flex gap-8 mt-2">
                <div class="bg-[#232c3b] rounded-xl px-6 py-4 flex flex-col items-center">
                    <span class="text-2xl font-mono text-blue-300">02:45</span>
                    <span class="text-xs text-white/60 mt-1">Setup Time</span>
                </div>
                <div class="bg-[#232c3b] rounded-xl px-6 py-4 flex flex-col items-center">
                    <span class="text-2xl font-mono text-green-300">100%</span>
                    <span class="text-xs text-white/60 mt-1">Uptime</span>
                </div>
            </div>
        </div>
    </template>
    <style>
        .animate-fade-in {
            animation: fadeIn 0.7s cubic-bezier(.4,0,.2,1);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.98); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</div>
<script src="/js/alpinejs.min.js" defer></script>
<script>
function publicacionAnimada() {
    return {
        publicado: false,
        observer: null,
        barra: null,
        animTimeout: null,
        initAnimacion(el) {
            // Intersection Observer para reactivar animación al entrar al viewport
            this.observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.reiniciarAnimacion();
                    } else {
                        // Opcional: resetear si sale del viewport
                        // this.publicado = false;
                    }
                });
            }, { threshold: 0.5 });
            this.observer.observe(el);
        },
        iniciarBarra(el) {
            // Reinicia la barra de progreso
            el.style.width = '0%';
            let w = 0;
            if (this.animTimeout) clearTimeout(this.animTimeout);
            let int = setInterval(() => {
                w += 5;
                el.style.width = w + '%';
                if (w >= 100) {
                    clearInterval(int);
                }
            }, 110);
            // Cuando termina la barra, mostrar publicado
            this.animTimeout = setTimeout(() => {
                this.publicado = true;
            }, 2200);
        },
        reiniciarAnimacion() {
            this.publicado = false;
        }
    }
}
</script>
<?php /**PATH C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos\resources\views/components/publicacion-exitosa.blade.php ENDPATH**/ ?>