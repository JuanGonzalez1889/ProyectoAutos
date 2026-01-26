@extends('layouts.admin')

@section('title', 'Mis Tareas')
@section('page-title', 'Mis Tareas')

@section('content')
<div class="space-y-6">
    <!-- Header con stats -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-white">Tablero de Tareas</h2>
            <p class="text-sm text-[hsl(var(--muted-foreground))] mt-1">Organiza tu trabajo tipo Kanban</p>
        </div>
        <button onclick="document.getElementById('taskModal').classList.remove('hidden')" 
                class="h-10 px-5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-semibold transition-opacity flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nueva Tarea
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="p-4 bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500/20 rounded-lg">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Total</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-gradient-to-br from-gray-500/10 to-gray-600/10 border border-gray-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-gray-500/20 rounded-lg">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Por Hacer</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['todo'] }}</p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-gradient-to-br from-yellow-500/10 to-yellow-600/10 border border-yellow-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-yellow-500/20 rounded-lg">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">En Proceso</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['in_progress'] }}</p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-green-500/20 rounded-lg">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Completadas</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['done'] }}</p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-gradient-to-br from-red-500/10 to-red-600/10 border border-red-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-red-500/20 rounded-lg">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Alta Prioridad</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['high_priority'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="kanban()">
        <!-- Por Hacer -->
        <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-gray-500"></div>
                    <h3 class="font-semibold text-white">Por Hacer</h3>
                    <span class="px-2 py-0.5 text-xs font-medium rounded bg-gray-500/20 text-gray-500">{{ count($tasks['todo']) }}</span>
                </div>
            </div>

            <div class="space-y-3 min-h-[400px]">
                @forelse($tasks['todo'] as $task)
                <div class="card hover:border-[hsl(var(--primary))]/50 transition-colors cursor-move" 
                     draggable="true"
                     data-task-id="{{ $task->id }}">
                    <div class="flex items-start justify-between mb-2">
                        <h4 class="font-semibold text-white text-sm">{{ $task->title }}</h4>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false"
                                    class="p-1 hover:bg-[hsl(var(--muted))] rounded transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                                </svg>
                            </button>
                            <div x-show="open" x-transition style="display: none;"
                                 class="absolute right-0 mt-2 w-36 bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg shadow-lg z-50">
                                <a href="#" @click.prevent="editTask({{ $task->id }})" 
                                   class="block px-3 py-2 text-sm hover:bg-[hsl(var(--muted))] transition-colors">Editar</a>
                                <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" 
                                      onsubmit="return confirm('¿Eliminar esta tarea?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-500 hover:bg-[hsl(var(--muted))] transition-colors">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    @if($task->description)
                    <p class="text-xs text-[hsl(var(--muted-foreground))] mb-3 line-clamp-2">{{ $task->description }}</p>
                    @endif

                    <div class="flex items-center justify-between">
                        <span class="px-2 py-0.5 text-xs font-medium rounded 
                            @if($task->priority === 'high') bg-red-500/20 text-red-500
                            @elseif($task->priority === 'medium') bg-yellow-500/20 text-yellow-500
                            @else bg-green-500/20 text-green-500 @endif">
                            @if($task->priority === 'high') Alta
                            @elseif($task->priority === 'medium') Media
                            @else Baja @endif
                        </span>
                        
                        @if($task->due_date)
                        <span class="text-xs text-[hsl(var(--muted-foreground))]">
                            {{ $task->due_date->format('d/m/Y') }}
                        </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="card text-center py-12">
                    <p class="text-sm text-[hsl(var(--muted-foreground))]">No hay tareas</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- En Proceso -->
        <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                    <h3 class="font-semibold text-white">En Proceso</h3>
                    <span class="px-2 py-0.5 text-xs font-medium rounded bg-yellow-500/20 text-yellow-500">{{ count($tasks['in_progress']) }}</span>
                </div>
            </div>

            <div class="space-y-3 min-h-[400px]">
                @forelse($tasks['in_progress'] as $task)
                <div class="card hover:border-[hsl(var(--primary))]/50 transition-colors cursor-move" 
                     draggable="true"
                     data-task-id="{{ $task->id }}">
                    <div class="flex items-start justify-between mb-2">
                        <h4 class="font-semibold text-white text-sm">{{ $task->title }}</h4>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false"
                                    class="p-1 hover:bg-[hsl(var(--muted))] rounded transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                                </svg>
                            </button>
                            <div x-show="open" x-transition style="display: none;"
                                 class="absolute right-0 mt-2 w-36 bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg shadow-lg z-50">
                                <a href="#" @click.prevent="editTask({{ $task->id }})" 
                                   class="block px-3 py-2 text-sm hover:bg-[hsl(var(--muted))] transition-colors">Editar</a>
                                <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" 
                                      onsubmit="return confirm('¿Eliminar esta tarea?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-500 hover:bg-[hsl(var(--muted))] transition-colors">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    @if($task->description)
                    <p class="text-xs text-[hsl(var(--muted-foreground))] mb-3 line-clamp-2">{{ $task->description }}</p>
                    @endif

                    <div class="flex items-center justify-between">
                        <span class="px-2 py-0.5 text-xs font-medium rounded 
                            @if($task->priority === 'high') bg-red-500/20 text-red-500
                            @elseif($task->priority === 'medium') bg-yellow-500/20 text-yellow-500
                            @else bg-green-500/20 text-green-500 @endif">
                            @if($task->priority === 'high') Alta
                            @elseif($task->priority === 'medium') Media
                            @else Baja @endif
                        </span>
                        
                        @if($task->due_date)
                        <span class="text-xs text-[hsl(var(--muted-foreground))]">
                            {{ $task->due_date->format('d/m/Y') }}
                        </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="card text-center py-12">
                    <p class="text-sm text-[hsl(var(--muted-foreground))]">No hay tareas</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Completadas -->
        <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <h3 class="font-semibold text-white">Completadas</h3>
                    <span class="px-2 py-0.5 text-xs font-medium rounded bg-green-500/20 text-green-500">{{ count($tasks['done']) }}</span>
                </div>
            </div>

            <div class="space-y-3 min-h-[400px]">
                @forelse($tasks['done'] as $task)
                <div class="card opacity-75 hover:opacity-100 hover:border-[hsl(var(--primary))]/50 transition-all cursor-move" 
                     draggable="true"
                     data-task-id="{{ $task->id }}">
                    <div class="flex items-start justify-between mb-2">
                        <h4 class="font-semibold text-white text-sm line-through">{{ $task->title }}</h4>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false"
                                    class="p-1 hover:bg-[hsl(var(--muted))] rounded transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                                </svg>
                            </button>
                            <div x-show="open" x-transition style="display: none;"
                                 class="absolute right-0 mt-2 w-36 bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg shadow-lg z-50">
                                <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" 
                                      onsubmit="return confirm('¿Eliminar esta tarea?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-500 hover:bg-[hsl(var(--muted))] transition-colors">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    @if($task->description)
                    <p class="text-xs text-[hsl(var(--muted-foreground))] mb-3 line-clamp-2">{{ $task->description }}</p>
                    @endif

                    <div class="flex items-center justify-between">
                        <span class="px-2 py-0.5 text-xs font-medium rounded bg-green-500/20 text-green-500">
                            <svg class="w-3 h-3 inline" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Completada
                        </span>
                        
                        <span class="text-xs text-[hsl(var(--muted-foreground))]">
                            {{ $task->updated_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="card text-center py-12">
                    <p class="text-sm text-[hsl(var(--muted-foreground))]">No hay tareas completadas</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal para crear/editar tarea -->
<div id="taskModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/50" onclick="document.getElementById('taskModal').classList.add('hidden')"></div>
        
        <div class="relative bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6 max-w-lg w-full">
            <h3 class="text-lg font-semibold mb-4">Nueva Tarea</h3>
            
            <form action="{{ route('admin.tasks.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium mb-2">Título</label>
                    <input type="text" name="title" required
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Descripción</label>
                    <textarea name="description" rows="3"
                              class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Prioridad</label>
                        <select name="priority" required
                                class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                            <option value="low">Baja</option>
                            <option value="medium" selected>Media</option>
                            <option value="high">Alta</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Fecha de vencimiento</label>
                        <input type="date" name="due_date"
                               class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('taskModal').classList.add('hidden')" 
                            class="px-4 py-2 text-sm text-[hsl(var(--muted-foreground))] hover:text-white transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-semibold text-sm transition-opacity">
                        Crear Tarea
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function kanban() {
    return {
        draggedTask: null,
        
        init() {
            this.setupDragAndDrop();
        },
        
        setupDragAndDrop() {
            document.addEventListener('dragstart', (e) => {
                if (e.target.hasAttribute('data-task-id')) {
                    this.draggedTask = e.target.getAttribute('data-task-id');
                    e.target.style.opacity = '0.5';
                }
            });
            
            document.addEventListener('dragend', (e) => {
                if (e.target.hasAttribute('data-task-id')) {
                    e.target.style.opacity = '1';
                }
            });
            
            // Permitir drop en las columnas
            const columns = document.querySelectorAll('.space-y-3');
            columns.forEach((column, index) => {
                column.addEventListener('dragover', (e) => {
                    e.preventDefault();
                });
                
                column.addEventListener('drop', async (e) => {
                    e.preventDefault();
                    
                    if (!this.draggedTask) return;
                    
                    const statuses = ['todo', 'in_progress', 'done'];
                    const newStatus = statuses[index];
                    
                    try {
                        const response = await fetch(`/tasks/${this.draggedTask}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ status: newStatus })
                        });
                        
                        if (response.ok) {
                            window.location.reload();
                        }
                    } catch (error) {
                        console.error('Error updating task:', error);
                    }
                });
            });
        },
        
        editTask(taskId) {
            // Implementar edición
            console.log('Edit task:', taskId);
        }
    }
}
</script>
@endsection
