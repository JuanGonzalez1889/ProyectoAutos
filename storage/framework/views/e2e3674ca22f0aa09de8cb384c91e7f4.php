

<?php $__env->startSection('title', 'Seleccionar Plantilla - Mi Landing'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .template-card {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        transform: scale(0.82);
        transform-origin: top center;
    }
    
    .template-card:hover {
        transform: translateY(-10px) scale(0.85);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
    }
    
    .template-card img {
        transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .template-card:hover img {
        opacity: 0.7 !important;
    }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Elige tu Plantilla de Landing</h1>
        <p class="text-slate-400 mt-2">Selecciona el diseño que mejor se adapte a tu agencia. Podrás personalizarlo después.</p>
    </div>

    <!-- Grid de Plantillas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Plantilla Moderno -->
        <div class="template-card bg-[hsl(var(--card))] rounded-lg overflow-hidden shadow border border-[hsl(var(--border))]">
            <div class="relative bg-gradient-to-br from-purple-600 to-pink-500 h-48 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=400&h=300&fit=crop" alt="Moderno" class="w-full h-full object-cover opacity-40">
                <div class="absolute inset-0 flex items-center justify-center text-white">
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1">Moderno</div>
                        <div class="text-xs">Hero grande + Grid</div>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <h3 class="text-base font-bold mb-2 text-[hsl(var(--foreground))]">Moderno</h3>
                <p class="text-[hsl(var(--muted-foreground))] mb-3 text-xs line-clamp-2">Diseño contemporáneo con hero grande, vehículos en grid y contacto destacado.</p>
                <div class="flex gap-2">
                    <button onclick="previewTemplate('moderno')" class="flex-1 px-3 py-2 border border-[hsl(var(--border))] text-[hsl(var(--foreground))] rounded text-xs font-semibold hover:bg-[hsl(var(--secondary))] transition">
                        Preview
                    </button>
                    <form action="<?php echo e(route('admin.landing-template.store')); ?>" method="POST" class="flex-1">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="template" value="moderno">
                        <button type="submit" class="w-full px-3 py-2 bg-purple-600 text-white rounded text-xs font-semibold hover:bg-purple-700 transition">
                            Usar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Plantilla Minimalista -->
        <div class="template-card bg-[hsl(var(--card))] rounded-lg overflow-hidden shadow border border-[hsl(var(--border))]">
            <div class="relative bg-gradient-to-br from-gray-700 to-gray-900 h-48 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1618172193622-ae2d025f4032?w=400&h=300&fit=crop" alt="Minimalista" class="w-full h-full object-cover opacity-30">
                <div class="absolute inset-0 flex items-center justify-center text-white">
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1">Minimal</div>
                        <div class="text-xs">Simple y Directo</div>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <h3 class="text-base font-bold mb-2 text-[hsl(var(--foreground))]">Minimalista</h3>
                <p class="text-[hsl(var(--muted-foreground))] mb-3 text-xs line-clamp-2">Diseño limpio con lista vertical. Ideal para claridad del mensaje.</p>
                <div class="flex gap-2">
                    <button onclick="previewTemplate('minimalista')" class="flex-1 px-3 py-2 border border-[hsl(var(--border))] text-[hsl(var(--foreground))] rounded text-xs font-semibold hover:bg-[hsl(var(--secondary))] transition">
                        Preview
                    </button>
                    <form action="<?php echo e(route('admin.landing-template.store')); ?>" method="POST" class="flex-1">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="template" value="minimalista">
                        <button type="submit" class="w-full px-3 py-2 bg-gray-700 text-white rounded text-xs font-semibold hover:bg-gray-800 transition">
                            Usar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Plantilla Clásico -->
        <div class="template-card bg-[hsl(var(--card))] rounded-lg overflow-hidden shadow border border-[hsl(var(--border))]">
            <div class="relative bg-gradient-to-br from-blue-600 to-blue-900 h-48 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1617814076367-b759c7d7e738?w=400&h=300&fit=crop" alt="Clásico" class="w-full h-full object-cover opacity-40">
                <div class="absolute inset-0 flex items-center justify-center text-white">
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1">Clásico</div>
                        <div class="text-xs">Profesional</div>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <h3 class="text-base font-bold mb-2 text-[hsl(var(--foreground))]">Clásico</h3>
                <p class="text-[hsl(var(--muted-foreground))] mb-3 text-xs line-clamp-2">Header destacado con tarjetas bordeadas. Para seriedad y confianza.</p>
                <div class="flex gap-2">
                    <button onclick="previewTemplate('clasico')" class="flex-1 px-3 py-2 border border-[hsl(var(--border))] text-[hsl(var(--foreground))] rounded text-xs font-semibold hover:bg-[hsl(var(--secondary))] transition">
                        Preview
                    </button>
                    <form action="<?php echo e(route('admin.landing-template.store')); ?>" method="POST" class="flex-1">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="template" value="clasico">
                        <button type="submit" class="w-full px-3 py-2 bg-blue-900 text-white rounded text-xs font-semibold hover:bg-blue-950 transition">
                            Usar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Plantilla Deportivo -->
        <div class="template-card bg-[hsl(var(--card))] rounded-lg overflow-hidden shadow border border-[hsl(var(--border))]">
            <div class="relative bg-gradient-to-br from-red-600 via-orange-600 to-yellow-500 h-48 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1583121274602-3e2820c69888?w=400&h=300&fit=crop" alt="Deportivo" class="w-full h-full object-cover opacity-50">
                <div class="absolute inset-0 flex items-center justify-center text-white">
                    <div class="text-center">
                        <div class="text-3xl font-black mb-1">DEPORTIVO</div>
                        <div class="text-xs tracking-wider">POTENCIA</div>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <h3 class="text-base font-bold mb-2 text-[hsl(var(--foreground))]">Deportivo</h3>
                <p class="text-[hsl(var(--muted-foreground))] mb-3 text-xs line-clamp-2">Diseño agresivo con efectos dinámicos. Para agencias premium.</p>
                <div class="flex gap-2">
                    <button onclick="previewTemplate('deportivo')" class="flex-1 px-3 py-2 border border-[hsl(var(--border))] text-[hsl(var(--foreground))] rounded text-xs font-semibold hover:bg-[hsl(var(--secondary))] transition">
                        Preview
                    </button>
                    <form action="<?php echo e(route('admin.landing-template.store')); ?>" method="POST" class="flex-1">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="template" value="deportivo">
                        <button type="submit" class="w-full px-3 py-2 bg-gradient-to-r from-red-600 to-orange-600 text-white rounded text-xs font-semibold hover:opacity-90 transition">
                            Usar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Info sobre cambios futuros -->
    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded">
        <h4 class="font-bold text-blue-900 mb-2">💡 Cambiar de plantilla después</h4>
        <p class="text-blue-800">Una vez selecciones una plantilla, podrás cambiarla en cualquier momento. Tu contenido (textos, imágenes, datos de contacto) se mantendrá.</p>
    </div>
</div>

<!-- Modal Preview -->
<div id="previewModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-75 flex items-center justify-center">
    <div class="bg-white rounded-lg w-full h-full md:w-11/12 md:h-5/6 md:rounded-lg overflow-hidden flex flex-col">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="font-bold text-lg">Preview - <span id="templateName"></span></h3>
            <button onclick="closePreview()" class="text-2xl text-gray-600 hover:text-gray-900">×</button>
        </div>
        <iframe id="previewFrame" src="" class="flex-1 w-full border-0"></iframe>
    </div>
</div>

<script>
function previewTemplate(template) {
    const names = {
        'moderno': 'Moderno',
        'minimalista': 'Minimalista',
        'clasico': 'Clásico',
        'deportivo': 'Deportivo'
    };
    
    document.getElementById('templateName').textContent = names[template];
    document.getElementById('previewFrame').src = `/landing-preview/${template}`;
    document.getElementById('previewModal').classList.remove('hidden');
}

function closePreview() {
    document.getElementById('previewModal').classList.add('hidden');
    document.getElementById('previewFrame').src = '';
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closePreview();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos\resources\views/admin/landing-template/select.blade.php ENDPATH**/ ?>