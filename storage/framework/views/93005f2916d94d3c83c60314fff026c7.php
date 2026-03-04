

<?php $__env->startSection('title', 'Mis Dominios'); ?>
<?php $__env->startSection('page-title', 'Gestión de Dominios'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-semibold text-white mb-1">Mis Dominios</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Administra los dominios de tu agencia</p>
        </div>

        <div class="flex flex-col gap-2 items-end">
            <a href="<?php echo e(route('admin.domains.create')); ?>" 
               class="h-10 px-5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Registrar Dominio
            </a>
        </div>
    </div>

    <!-- Messages -->
    <?php if($message = Session::get('success')): ?>
        <div class="p-4 bg-green-500/10 border border-green-500/30 text-green-400 rounded-lg text-sm">
            <?php echo e($message); ?>

        </div>
    <?php endif; ?>

    <?php if($message = Session::get('error')): ?>
        <div class="p-4 bg-red-500/10 border border-red-500/30 text-red-400 rounded-lg text-sm">
            <?php echo e($message); ?>

        </div>
    <?php endif; ?>

    <!-- Tabla/Grid de Dominios -->
    <?php if($domains->count()): ?>
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[hsl(var(--muted))] border-b border-[hsl(var(--border))]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Dominio</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Registrado</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[hsl(var(--border))]">
                        <?php $__currentLoopData = $domains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $domain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-[hsl(var(--muted))]/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-[hsl(var(--primary))]/20 rounded">
                                            <svg class="w-4 h-4 text-[hsl(var(--primary))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-white"><?php echo e($domain->domain); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($domain->type === 'new'): ?>
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-xs font-semibold border border-green-500/30">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Nuevo
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-xs font-semibold border border-blue-500/30">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Existente
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-[hsl(var(--muted-foreground))]">
                                    <?php echo e($domain->created_at->format('d/m/Y H:i')); ?>

                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="<?php echo e(route('admin.domains.show', $domain)); ?>" 
                                           class="px-3 py-1 text-[hsl(var(--primary))] hover:bg-[hsl(var(--primary))]/10 rounded text-sm font-medium transition-colors">
                                            Ver
                                        </a>
                                        <a href="<?php echo e(route('admin.domains.edit', $domain)); ?>" 
                                           class="px-3 py-1 text-blue-400 hover:bg-blue-500/10 rounded text-sm font-medium transition-colors">
                                            Editar
                                        </a>
                                        <form action="<?php echo e(route('admin.domains.destroy', $domain)); ?>" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este dominio?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="px-3 py-1 text-red-400 hover:bg-red-500/10 rounded text-sm font-medium transition-colors">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="card py-16 text-center">
            <svg class="mx-auto h-16 w-16 text-[hsl(var(--muted-foreground))]/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <p class="text-[hsl(var(--muted-foreground))] mb-4">Aún no tienes dominios registrados</p>
            <a href="<?php echo e(route('admin.domains.create')); ?>" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Registra tu primer dominio aquí
            </a>
        </div>
    <?php endif; ?>

</div>

<!-- Sección: Dominio personalizado por WhatsApp -->
<div class="mt-10 flex justify-center">
    <div class="bg-[hsl(var(--muted))] border border-[hsl(var(--border))] rounded-lg p-6 flex flex-col items-center w-full max-w-xl">
        <span class="text-base text-white font-semibold mb-2">¿Ya tenes un dominio o necesitas uno personalizado?</span>
        <p class="text-sm text-[hsl(var(--muted-foreground))] mb-4 text-center">Comunicate con nosotros por WhatsApp y nuestro equipo te ayudará a gestionarlo.</p>
        <a href="https://wa.me/5493413365206?text=quiero%20un%20dominio%20personalizado" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-semibold transition">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.031-.967-.273-.099-.472-.148-.67.15-.197.297-.767.967-.94 1.164-.173.198-.347.223-.644.075-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.5-.669-.51-.173-.008-.372-.01-.571-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.099 3.2 5.077 4.363.71.306 1.263.489 1.694.626.712.227 1.36.195 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.413-.074-.124-.272-.198-.57-.347z"/>
            </svg>
            Contactar por WhatsApp
        </a>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\domains\index.blade.php ENDPATH**/ ?>