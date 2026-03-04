

<?php $__env->startSection('title', 'Gestión de Leads'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[hsl(var(--foreground))]">Leads / Prospectos</h1>
            <p class="text-sm text-[hsl(var(--muted-foreground))] mt-1">Gestiona tus clientes potenciales</p>
        </div>
        <a href="<?php echo e(route('admin.leads.create')); ?>" 
           class="px-4 py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-semibold transition-opacity flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nuevo Lead
        </a>
    </div>

    <!-- Recordatorio de Seguimiento -->
    <?php if(isset($pendingFollowUps) && $pendingFollowUps->count()): ?>
        <div class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 rounded">
            <strong>¡Tienes <?php echo e($pendingFollowUps->count()); ?> lead(s) con seguimiento pendiente en los próximos 5 días!</strong>
            <ul class="mt-2 text-sm">
                <?php $__currentLoopData = $pendingFollowUps->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>• <strong><?php echo e($lead->name); ?></strong> <?php if($lead->next_follow_up): ?> <span class="text-xs">(<?php echo e($lead->next_follow_up->format('d/m/Y H:i')); ?>)</span><?php endif; ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($pendingFollowUps->count() > 3): ?>
                    <li class="text-xs text-gray-600">y <?php echo e($pendingFollowUps->count() - 3); ?> más...</li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-3">
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Total</p>
            <p class="text-xl font-bold text-[hsl(var(--foreground))]"><?php echo e($stats['total']); ?></p>
        </div>

        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-3">
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Nuevos</p>
            <p class="text-xl font-bold text-blue-500"><?php echo e($stats['new']); ?></p>
        </div>

        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-3">
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Activos</p>
            <p class="text-xl font-bold text-yellow-500"><?php echo e($stats['active']); ?></p>
        </div>

        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-3">
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Ganados</p>
            <p class="text-xl font-bold text-emerald-500"><?php echo e($stats['won']); ?></p>
        </div>

        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-3">
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Perdidos</p>
            <p class="text-xl font-bold text-red-500"><?php echo e($stats['lost']); ?></p>
        </div>
    </div>

    <!-- Tabla de Leads -->
    <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg overflow-hidden">
        <div class="overflow-x-auto" style="
    height: 50vh;
">
            <table class="w-full">
                <thead class="bg-[hsl(var(--muted))] border-b border-[hsl(var(--border))]">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Nombre</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Contacto</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Vehículo</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Estado</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Fuente</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Asignado</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Próximo Seguimiento</th>
                        <th class="text-right px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[hsl(var(--border))]">
                    <?php $__empty_1 = true; $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-[hsl(var(--muted))] transition-colors">
                        <td class="px-4 py-3">
                            <div class="font-medium text-[hsl(var(--foreground))]"><?php echo e($lead->name); ?></div>
                            <?php if($lead->budget): ?>
                            <div class="text-xs text-[hsl(var(--muted-foreground))]">Presupuesto: $<?php echo e(number_format($lead->budget, 0, ',', '.')); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-[hsl(var(--foreground))]"><?php echo e($lead->phone); ?></div>
                            <?php if($lead->email): ?>
                            <div class="text-xs text-[hsl(var(--muted-foreground))]"><?php echo e($lead->email); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3">
                            <?php if($lead->vehicle): ?>
                            <div class="text-sm text-[hsl(var(--foreground))]"><?php echo e($lead->vehicle->brand); ?> <?php echo e($lead->vehicle->model); ?></div>
                            <div class="text-xs text-[hsl(var(--muted-foreground))]"><?php echo e($lead->vehicle->year); ?></div>
                            <?php else: ?>
                            <span class="text-sm text-[hsl(var(--muted-foreground))]">Sin vehículo</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                <?php if($lead->getStatusBadgeColor() === 'blue'): ?> bg-blue-500/20 text-blue-500
                                <?php elseif($lead->getStatusBadgeColor() === 'yellow'): ?> bg-yellow-500/20 text-yellow-500
                                <?php elseif($lead->getStatusBadgeColor() === 'green'): ?> bg-green-500/20 text-green-500
                                <?php elseif($lead->getStatusBadgeColor() === 'purple'): ?> bg-purple-500/20 text-purple-500
                                <?php elseif($lead->getStatusBadgeColor() === 'emerald'): ?> bg-emerald-500/20 text-emerald-500
                                <?php elseif($lead->getStatusBadgeColor() === 'red'): ?> bg-red-500/20 text-red-500
                                <?php else: ?> bg-gray-500/20 text-gray-500
                                <?php endif; ?>">
                                <?php echo e($lead->getStatusLabel()); ?>

                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-[hsl(var(--foreground))] capitalize">
                                <?php if($lead->source === 'web'): ?> Web
                                <?php elseif($lead->source === 'phone'): ?> Teléfono
                                <?php elseif($lead->source === 'social_media'): ?> Redes Sociales
                                <?php elseif($lead->source === 'referral'): ?> Referido
                                <?php elseif($lead->source === 'walk_in'): ?> Visita
                                <?php else: ?> <?php echo e($lead->source ?? 'N/A'); ?>

                                <?php endif; ?>
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-[hsl(var(--foreground))]"><?php echo e($lead->user->name); ?></div>
                        </td>
                        <td class="px-4 py-3">
                            <?php if($lead->next_follow_up): ?>
                            <div class="text-sm text-[hsl(var(--foreground))]"><?php echo e($lead->next_follow_up->format('d/m/Y')); ?></div>
                            <div class="text-xs text-[hsl(var(--muted-foreground))]"><?php echo e($lead->next_follow_up->format('H:i')); ?></div>
                            <?php else: ?>
                            <span class="text-sm text-[hsl(var(--muted-foreground))]">Sin programar</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="<?php echo e(route('admin.leads.edit', $lead)); ?>" 
                                   class="p-1.5 hover:bg-[hsl(var(--muted))] rounded transition-colors"
                                   title="Editar">
                                    <svg class="w-4 h-4 text-[hsl(var(--muted-foreground))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <!-- Botón cambiar estado -->
                                <div class="relative group">
                                    <button onclick="toggleStatusMenu(event, <?php echo e($lead->id); ?>)" class="p-1.5 hover:bg-emerald-500/20 rounded transition-colors" title="Cambiar estado">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10" stroke-width="2"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8M12 8v8"/>
                                        </svg>
                                    </button>
                                    <div id="status-menu-<?php echo e($lead->id); ?>" class="hidden absolute right-0 z-10 mt-2 w-32 bg-white border border-gray-200 rounded shadow-lg">
                                        <?php $__currentLoopData = ['new'=>'Nuevo','contacted'=>'Contactado','interested'=>'Interesado','negotiating'=>'Negociando','won'=>'Ganado','lost'=>'Perdido']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <button onclick="updateLeadStatus(<?php echo e($lead->id); ?>, '<?php echo e($key); ?>')" class="block w-full text-left px-4 py-2 text-sm hover:bg-emerald-100 text-gray-800"><?php echo e($label); ?></button>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <?php $__env->startPush('scripts'); ?>
                                <script>
                                function toggleStatusMenu(e, id) {
                                    e.preventDefault();
                                    document.querySelectorAll('[id^=\'status-menu-\']').forEach(el => el.classList.add('hidden'));
                                    document.getElementById('status-menu-' + id).classList.toggle('hidden');
                                    document.addEventListener('click', function handler(ev) {
                                        if (!ev.target.closest('#status-menu-' + id) && !ev.target.closest('[onclick^=toggleStatusMenu]')) {
                                            document.getElementById('status-menu-' + id).classList.add('hidden');
                                            document.removeEventListener('click', handler);
                                        }
                                    });
                                }

                                function updateLeadStatus(leadId, status) {
                                    fetch(`/admin/leads/${leadId}/status`, {
                                        method: 'PATCH',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                        },
                                        body: JSON.stringify({ status })
                                    })
                                    .then(r => r.json())
                                    .then(data => {
                                        if (data.success) {
                                            location.reload();
                                        } else {
                                            alert('Error al actualizar el estado');
                                        }
                                    });
                                }
                                </script>
                                <?php $__env->stopPush(); ?>
                                <form action="<?php echo e(route('admin.leads.destroy', $lead)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" 
                                            class="p-1.5 hover:bg-red-500/20 rounded transition-colors"
                                            onclick="return confirm('¿Estás seguro de eliminar este lead?')"
                                            title="Eliminar">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="px-4 py-12 text-center text-[hsl(var(--muted-foreground))]">
                            <svg class="w-12 h-12 mx-auto mb-4 text-[hsl(var(--muted-foreground))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p class="font-medium">No hay leads registrados</p>
                            <p class="text-sm mt-1">Crea tu primer lead para comenzar</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($leads->hasPages()): ?>
        <div class="px-4 py-3 border-t border-[hsl(var(--border))]">
            <?php echo e($leads->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\leads\index.blade.php ENDPATH**/ ?>