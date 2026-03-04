

<?php $__env->startSection('title', 'Lista de Tareas'); ?>
<?php $__env->startSection('page-title', 'Tareas'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
        <!-- Resumen de tareas por estado -->
        <div class="flex gap-4 mb-6">
            <div class="flex-1 p-4 rounded-lg flex items-center gap-3 border"
                style="background-color: <?php echo e($tasks->where('status','pendiente')->count() > 0 ? '#facc15' : '#374151'); ?>; border-color: <?php echo e($tasks->where('status','pendiente')->count() > 0 ? '#eab308' : '#374151'); ?>;">
                <div style="background-color: #fde68a;" class="p-2 rounded-lg">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-gray-800 font-bold">Pendientes</div>
                    <div class="text-2xl font-bold text-gray-900"><?php echo e($tasks->where('status','pendiente')->count()); ?></div>
                </div>
            </div>
            <div class="flex-1 p-4 rounded-lg flex items-center gap-3 border"
                style="background-color: <?php echo e($tasks->where('status','completado')->count() > 0 ? '#22c55e' : '#374151'); ?>; border-color: <?php echo e($tasks->where('status','completado')->count() > 0 ? '#16a34a' : '#374151'); ?>;">
                <div style="background-color: #bbf7d0;" class="p-2 rounded-lg">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-white-900 font-bold">Completadas</div>
                    <div class="text-2xl font-bold text-white-900"><?php echo e($tasks->where('status','completado')->count()); ?></div>
                </div>
            </div>
            <div class="flex-1 p-4 rounded-lg flex items-center gap-3 border"
                style="background-color: <?php echo e($tasks->where('status','cancelado')->count() > 0 ? '#ef4444' : '#374151'); ?>; border-color: <?php echo e($tasks->where('status','cancelado')->count() > 0 ? '#b91c1c' : '#374151'); ?>;">
                <div style="background-color: #fecaca;" class="p-2 rounded-lg">
                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-red-900 font-bold">Canceladas</div>
                    <div class="text-2xl font-bold text-red-900"><?php echo e($tasks->where('status','cancelado')->count()); ?></div>
                </div>
            </div>
        </div>
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-white">Tareas</h2>
        <a href="<?php echo e(route('admin.events.create', ['return' => 'tasks'])); ?>" class="h-10 px-5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-semibold transition-opacity flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nueva Tarea
        </a>
    </div>
    <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
        <table class="min-w-full divide-y divide-[hsl(var(--border))]">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase">Título</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase">Inicio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white"><?php echo e($task->title); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                        <?php
                            $tipos = [
                                'other' => 'Otro',
                                'delivery' => 'Entrega',
                                'test_drive' => 'Test Drive',
                                'meeting' => 'Reunión',
                            ];
                        ?>
                        <?php echo e($tipos[$task->type] ?? ucfirst($task->type)); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white"><?php echo e($task->start_time->format('d/m/Y H:i')); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                        <select class="estado-select rounded px-2 py-1 text-xs font-bold text-white"
                            data-task-id="<?php echo e($task->id); ?>"
                            style="background-color:
                                <?php if($task->status==='pendiente'): ?> #facc15;
                                <?php elseif($task->status==='completado'): ?> #22c55e;
                                <?php elseif($task->status==='cancelado'): ?> #ef4444;
                                <?php else: ?> #374151;
                                <?php endif; ?>">
                            <option value="pendiente" <?php if($task->status==="pendiente"): ?> selected <?php endif; ?> style="background-color:#facc15;color:#1e293b;">Pendiente</option>
                            <option value="completado" <?php if($task->status==="completado"): ?> selected <?php endif; ?> style="background-color:#22c55e;color:#fff;">Completado</option>
                            <option value="cancelado" <?php if($task->status==="cancelado"): ?> selected <?php endif; ?> style="background-color:#ef4444;color:#fff;">Cancelado</option>
                        </select>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                        <a href="<?php echo e(route('admin.events.edit', $task->id)); ?>" class="text-blue-500 hover:underline">Editar</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php if($tasks->isEmpty()): ?>
            <div class="text-center text-[hsl(var(--muted-foreground))] mt-6">No hay tareas registradas.</div>
        <?php endif; ?>
    <script>
    document.querySelectorAll('.estado-select').forEach(select => {
        select.addEventListener('change', async function() {
            const taskId = this.getAttribute('data-task-id');
            const estado = this.value;
            try {
                const response = await fetch(`/admin/tasks/${taskId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status: estado })
                });
                if (response.ok) {
                    window.location.reload();
                }
            } catch (error) {
                alert('Error al actualizar el estado');
            }
        });
    });
    </script>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\tasks\list.blade.php ENDPATH**/ ?>