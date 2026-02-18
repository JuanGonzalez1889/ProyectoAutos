<?php
    $isOnPlansPage = request()->routeIs('subscriptions.index');
?>
<?php if(auth()->user()->tenant && auth()->user()->tenant->getPlanInfo()['plan'] === 'free' && !$isOnPlansPage): ?>
    <div id="plan-overlay" class="fixed inset-0 z-[9999] flex items-center justify-center bg-[hsl(var(--background)/0.7)] backdrop-blur-sm">
        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-2xl shadow-2xl px-10 py-8 max-w-[90vw] text-center">
            <h2 class="text-3xl font-bold text-[hsl(var(--primary))] mb-2">Debes seleccionar un plan</h2>
            <p class="mt-2 mb-4 text-[hsl(var(--muted-foreground))]">Para acceder a todas las funciones, primero contrata un plan para tu agencia.</p>
            <a href="<?php echo e(route('subscriptions.index')); ?>" class="inline-block px-8 py-3 bg-[hsl(var(--primary))] hover:bg-[hsl(var(--primary)/.90)] text-white rounded-lg font-semibold text-lg mt-2 shadow transition">Seleccionar Plan</a>
            <br>
            <a href="https://wa.me/5493413365206?text=Hola!%20Necesito%20ayuda%20para%20elegir%20un%20plan%20en%20el%20panel%20de%20agencias" target="_blank" rel="noopener" class="inline-block px-8 py-2 mt-4 bg-[hsl(var(--secondary))] hover:bg-[hsl(var(--primary)/.10)] text-[hsl(var(--primary))] border border-[hsl(var(--primary))] rounded-lg font-semibold text-base transition">Contactar a soporte</a>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\Proyectos\ProyectoAutos\resources\views/components/plan-overlay.blade.php ENDPATH**/ ?>