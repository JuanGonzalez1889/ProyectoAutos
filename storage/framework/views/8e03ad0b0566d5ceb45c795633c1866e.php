

<?php $__env->startSection('title', 'Calendario'); ?>
<?php $__env->startSection('page-title', 'Calendario de Eventos'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header con opciones -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Gestiona tus citas, entregas y reuniones</p>
        </div>
        <a href="<?php echo e(route('admin.events.create')); ?>" class="px-4 py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-medium transition-opacity">
            + Nuevo Evento
        </a>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-4">
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Eventos Totales</p>
            <p class="text-2xl font-bold text-[hsl(var(--foreground))]"><?php echo e($stats['total']); ?></p>
        </div>
        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-4">
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Hoy</p>
            <p class="text-2xl font-bold text-green-500"><?php echo e($stats['today']); ?></p>
        </div>
        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-4">
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Próximos</p>
            <p class="text-2xl font-bold text-orange-500"><?php echo e($stats['upcoming']); ?></p>
        </div>
    </div>

    <!-- Vista de Calendario -->
    <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold">Mis Eventos</h3>
            <div class="flex items-center gap-4">
                <!-- Selector de vista -->
                <div class="flex gap-2 bg-[hsl(var(--secondary))] rounded-lg p-1">
                    <button onclick="toggleView('grid')" id="gridBtn" class="view-toggle px-3 py-1 text-sm rounded transition-colors bg-[hsl(var(--primary))] text-[#0a0f14] font-medium">
                        📅 Cuadrícula
                    </button>
                    <button onclick="toggleView('list')" id="listBtn" class="view-toggle px-3 py-1 text-sm rounded transition-colors text-[hsl(var(--muted-foreground))]">
                        📋 Lista
                    </button>
                </div>
            </div>
        </div>

        <!-- VISTA DE CUADRÍCULA (calendario mes) -->
        <div id="gridView" class="view-content">
            <div class="space-y-6">
                <div class="text-center mb-6">
                    <h4 class="text-2xl font-semibold">Febrero 2026</h4>
                </div>

                <!-- Cabecera de días de la semana -->
                <div class="grid grid-cols-7 gap-1">
                    <div class="text-center font-semibold text-[hsl(var(--muted-foreground))] text-sm py-3 border-b border-[hsl(var(--border))]">Lunes</div>
                    <div class="text-center font-semibold text-[hsl(var(--muted-foreground))] text-sm py-3 border-b border-[hsl(var(--border))]">Martes</div>
                    <div class="text-center font-semibold text-[hsl(var(--muted-foreground))] text-sm py-3 border-b border-[hsl(var(--border))]">Miércoles</div>
                    <div class="text-center font-semibold text-[hsl(var(--muted-foreground))] text-sm py-3 border-b border-[hsl(var(--border))]">Jueves</div>
                    <div class="text-center font-semibold text-[hsl(var(--muted-foreground))] text-sm py-3 border-b border-[hsl(var(--border))]">Viernes</div>
                    <div class="text-center font-semibold text-[hsl(var(--muted-foreground))] text-sm py-3 border-b border-[hsl(var(--border))]">Sábado</div>
                    <div class="text-center font-semibold text-[hsl(var(--muted-foreground))] text-sm py-3 border-b border-[hsl(var(--border))]">Domingo</div>
                </div>

                <!-- Calendario grid 7 columnas -->
                <div class="grid grid-cols-7 gap-1">
                    <!-- Día vacío antes del 1ro (domingo 1ro) -->
                    <div class="bg-[hsl(var(--secondary))] rounded-lg min-h-32 opacity-30"></div>

                    <!-- Días del mes (1-28) -->
                    <?php for($day = 1; $day <= 28; $day++): ?>
                        <?php
                            $date = \Carbon\Carbon::create(2026, 2, $day);
                            $isToday = $date->isToday();
                            $dayEvents = [];
                            
                            // Buscar eventos para este día
                            foreach($allEvents as $event) {
                                if ($event->start_time->day == $day) {
                                    $dayEvents[] = $event;
                                }
                            }
                        ?>
                        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg min-h-32 p-2 <?php echo e($isToday ? 'ring-2 ring-[hsl(var(--primary))] ring-offset-1 ring-offset-[hsl(var(--background))]' : ''); ?>">
                            <div class="text-sm font-bold <?php echo e($isToday ? 'text-[hsl(var(--primary))]' : 'text-[hsl(var(--muted-foreground))]'); ?> mb-1.5">
                                <?php echo e($day); ?>

                            </div>
                            <div class="space-y-0.5">
                                <?php $__empty_1 = true; $__currentLoopData = $dayEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <a href="<?php echo e(route('admin.events.edit', $event->id)); ?>" class="block text-xs bg-[hsl(var(--primary))] text-[#0a0f14] rounded px-1 py-0.5 truncate hover:opacity-80 transition-opacity" title="<?php echo e($event->title); ?>">
                                        <?php echo e($event->start_time->format('H:i')); ?> <?php echo e($event->title); ?>

                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endfor; ?>

                    <!-- Días restantes (29, 1 de marzo) -->
                    <?php for($day = 29; $day <= 29; $day++): ?>
                        <div class="bg-[hsl(var(--secondary))] rounded-lg min-h-32 opacity-30"></div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <!-- VISTA DE LISTA -->
        <div id="listView" class="view-content hidden">
            <?php if($allEvents->count() > 0): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $eventsByDate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $events): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border-l-4 border-[hsl(var(--primary))] pl-4 py-2">
                            <h4 class="font-semibold text-[hsl(var(--foreground))] mb-2">
                                <?php echo e(\Carbon\Carbon::parse($date)->locale('es')->format('l, d \\d\\e F')); ?>

                            </h4>
                            <div class="space-y-2">
                                <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-start gap-3 p-3 bg-[hsl(var(--secondary))] rounded-lg hover:bg-[hsl(var(--border))] transition-colors">
                                        <div class="flex-1">
                                            <p class="font-medium text-[hsl(var(--foreground))]"><?php echo e($task->title); ?></p>
                                            <div class="flex gap-2 mt-1 text-xs text-[hsl(var(--muted-foreground))]">
                                                <span>🕐 <?php echo e($task->due_date ? $task->due_date->format('H:i') : ''); ?></span>
                                            </div>
                                            <?php if($task->description): ?>
                                                <p class="text-xs text-[hsl(var(--muted-foreground))] mt-1"><?php echo e($task->description); ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex gap-2">
                                            <!-- Aquí podrías agregar edición/eliminación de tarea si lo deseas -->
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-[hsl(var(--muted-foreground))] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">No hay eventos programados</p>
                    <a href="<?php echo e(route('admin.events.create')); ?>" class="px-4 py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-medium transition-opacity inline-block">
                        Crear tu primer evento
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function toggleView(view) {
    // Ocultar todas las vistas
    document.querySelectorAll('.view-content').forEach(el => el.classList.add('hidden'));
    
    // Mostrar vista seleccionada
    document.getElementById(view + 'View').classList.remove('hidden');
    
    // Actualizar botones
    document.querySelectorAll('.view-toggle').forEach(btn => {
        btn.classList.remove('bg-[hsl(var(--primary))]', 'text-[#0a0f14]', 'font-medium');
        btn.classList.add('text-[hsl(var(--muted-foreground))]');
    });
    
    if (view === 'grid') {
        document.getElementById('gridBtn').classList.add('bg-[hsl(var(--primary))]', 'text-[#0a0f14]', 'font-medium');
        document.getElementById('gridBtn').classList.remove('text-[hsl(var(--muted-foreground))]');
    } else {
        document.getElementById('listBtn').classList.add('bg-[hsl(var(--primary))]', 'text-[#0a0f14]', 'font-medium');
        document.getElementById('listBtn').classList.remove('text-[hsl(var(--muted-foreground))]');
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\events\calendar.blade.php ENDPATH**/ ?>