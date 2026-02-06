

<?php $__env->startSection('title', 'Calendario'); ?>
<?php $__env->startSection('page-title', 'Calendario'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-white">Calendario de Eventos</h2>
            <p class="text-sm text-[hsl(var(--muted-foreground))] mt-1">Gestiona tus citas, entregas y reuniones</p>
        </div>
        <button onclick="document.getElementById('eventModal').classList.remove('hidden')" 
                class="h-10 px-5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-semibold transition-opacity flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nuevo Evento
        </button>
    </div>

    <!-- Calendar Navigation -->
    <div class="flex items-center justify-between bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-4">
        <div class="flex items-center gap-4">
            <button id="prevMonth" class="p-2 hover:bg-[hsl(var(--muted))] rounded transition-colors">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <h3 id="monthYear" class="text-lg font-semibold text-white min-w-[200px]"></h3>
            <button id="nextMonth" class="p-2 hover:bg-[hsl(var(--muted))] rounded transition-colors">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>

        <!-- View Toggle -->
        <div class="flex items-center gap-2 bg-[hsl(var(--background))] rounded-lg p-1">
            <button id="gridViewBtn" class="px-4 py-2 rounded transition-colors bg-[hsl(var(--primary))] text-[#0a0f14] font-semibold text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                Mes
            </button>
            <button id="listViewBtn" class="px-4 py-2 rounded transition-colors hover:bg-[hsl(var(--muted))] text-[hsl(var(--foreground))] text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                Lista
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="p-4 bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500/20 rounded-lg">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Eventos Totales</p>
                    <p class="text-2xl font-bold text-white"><?php echo e($stats['total']); ?></p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-green-500/20 rounded-lg">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Hoy</p>
                    <p class="text-2xl font-bold text-white"><?php echo e($stats['today']); ?></p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-purple-500/20 rounded-lg">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Próximos</p>
                    <p class="text-2xl font-bold text-white"><?php echo e($stats['upcoming']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div id="gridViewContainer" class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
        <!-- Calendar days with headers -->
        <div id="calendarGrid" class="grid grid-cols-7 gap-2" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 0.5rem;">
            <!-- This will be populated by JavaScript with both headers and days -->
        </div>
    </div>

    <!-- Calendar List View -->
    <div id="listViewContainer" style="display: none;" class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
        <div id="calendarList" class="space-y-4">
            <!-- This will be populated by JavaScript -->
        </div>
    </div>

    <!-- Events List for selected day -->
    <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
        <h3 id="selectedDayTitle" class="text-lg font-semibold mb-4">Eventos del día</h3>
        
        <div id="eventsList" class="space-y-3">
            <p class="text-[hsl(var(--muted-foreground))]">Selecciona un día para ver los eventos</p>
        </div>
    </div>
</div>

<!-- Modal para crear evento -->
<div id="eventModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/50" onclick="document.getElementById('eventModal').classList.add('hidden')"></div>
        
        <div class="relative bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6 max-w-2xl w-full">
            <h3 class="text-lg font-semibold mb-4">Nuevo Evento</h3>
            
            <form action="<?php echo e(route('admin.events.store')); ?>" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>
                
                <div>
                    <label class="block text-sm font-medium mb-2">Título</label>
                    <input type="text" name="title" required
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Descripción</label>
                    <textarea name="description" rows="2"
                              class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Tipo</label>
                        <select name="type" required
                                class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                            <option value="meeting">Reunión</option>
                            <option value="delivery">Entrega de Unidad</option>
                            <option value="test_drive">Prueba de Manejo</option>
                            <option value="service">Servicio</option>
                            <option value="other">Otro</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Ubicación</label>
                        <input type="text" name="location"
                               class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Fecha y Hora Inicio</label>
                        <input type="datetime-local" name="start_time" required
                               class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Fecha y Hora Fin</label>
                        <input type="datetime-local" name="end_time" required
                               class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Nombre del Cliente (opcional)</label>
                        <input type="text" name="client_name"
                               class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Teléfono del Cliente (opcional)</label>
                        <input type="text" name="client_phone"
                               class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('eventModal').classList.add('hidden')" 
                            class="px-4 py-2 text-sm text-[hsl(var(--muted-foreground))] hover:text-white transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-semibold text-sm transition-opacity">
                        Crear Evento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Datos de eventos del servidor
const eventsData = <?php echo json_encode($allEvents, 15, 512) ?>;
const eventsByDate = <?php echo json_encode($eventsByDate, 15, 512) ?>;

// Convertir eventos a objetos JavaScript
const events = eventsData.map(event => ({
    ...event,
    start_time: new Date(event.start_time),
    end_time: new Date(event.end_time)
}));

let currentDate = new Date();
let currentView = localStorage.getItem('calendarView') || 'grid'; // grid o list

console.log('Current view:', currentView);

function getTypeColor(type) {
    const colors = {
        'meeting': { 
            bg: 'bg-blue-500/5', 
            border: 'border-blue-500/30', 
            text: 'text-blue-500', 
            badge: 'bg-blue-500/20 text-blue-500',
            solid: 'bg-blue-500 text-white'
        },
        'delivery': { 
            bg: 'bg-green-500/5', 
            border: 'border-green-500/30', 
            text: 'text-green-500', 
            badge: 'bg-green-500/20 text-green-500',
            solid: 'bg-green-500 text-white'
        },
        'test_drive': { 
            bg: 'bg-orange-500/5', 
            border: 'border-orange-500/30', 
            text: 'text-orange-500', 
            badge: 'bg-orange-500/20 text-orange-500',
            solid: 'bg-orange-500 text-white'
        },
        'service': { 
            bg: 'bg-purple-500/5', 
            border: 'border-purple-500/30', 
            text: 'text-purple-500', 
            badge: 'bg-purple-500/20 text-purple-500',
            solid: 'bg-purple-500 text-white'
        },
        'other': { 
            bg: 'bg-gray-500/5', 
            border: 'border-gray-500/30', 
            text: 'text-gray-500', 
            badge: 'bg-gray-500/20 text-gray-500',
            solid: 'bg-gray-500 text-white'
        }
    };
    return colors[type] || colors['other'];
}

function getTypeLabel(type) {
    const labels = {
        'meeting': 'Reunión',
        'delivery': 'Entrega',
        'test_drive': 'Prueba de Manejo',
        'service': 'Servicio',
        'other': 'Otro'
    };
    return labels[type] || type;
}

function switchView(view) {
    currentView = view;
    localStorage.setItem('calendarView', view);
    
    const gridBtn = document.getElementById('gridViewBtn');
    const listBtn = document.getElementById('listViewBtn');
    
    // Actualizar estilos de botones
    if (view === 'grid') {
        gridBtn.className = 'px-4 py-2 rounded transition-colors bg-[hsl(var(--primary))] text-[#0a0f14] font-semibold text-sm flex items-center gap-2';
        listBtn.className = 'px-4 py-2 rounded transition-colors hover:bg-[hsl(var(--muted))] text-[hsl(var(--foreground))] text-sm flex items-center gap-2';
    } else {
        gridBtn.className = 'px-4 py-2 rounded transition-colors hover:bg-[hsl(var(--muted))] text-[hsl(var(--foreground))] text-sm flex items-center gap-2';
        listBtn.className = 'px-4 py-2 rounded transition-colors bg-[hsl(var(--primary))] text-[#0a0f14] font-semibold text-sm flex items-center gap-2';
    }
    
    // Mostrar/ocultar vistas
    if (view === 'grid') {
        document.getElementById('gridViewContainer').style.display = 'block';
        document.getElementById('listViewContainer').style.display = 'none';
        renderCalendarGrid();
    } else {
        document.getElementById('gridViewContainer').style.display = 'none';
        document.getElementById('listViewContainer').style.display = 'block';
        renderCalendarList();
    }
}

function renderCalendarGrid() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    // Update month/year display
    const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    document.getElementById('monthYear').textContent = `${monthNames[month]} ${year}`;
    
    // Get first day of month and number of days
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();
    
    // Adjust for Monday start (1 = Monday, 0 = Sunday)
    const adjustedFirstDay = firstDay === 0 ? 6 : firstDay - 1;
    
    const calendarGrid = document.getElementById('calendarGrid');
    calendarGrid.innerHTML = '';
    
    // Add day headers
    const dayNames = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
    dayNames.forEach(day => {
        const header = document.createElement('div');
        header.style.cssText = `
            text-align: center;
            font-weight: 600;
            color: hsl(var(--muted-foreground));
            font-size: 0.875rem;
            padding: 0.5rem;
        `;
        header.textContent = day;
        calendarGrid.appendChild(header);
    });
    
    // Add previous month's days
    for (let i = adjustedFirstDay - 1; i >= 0; i--) {
        const dayNum = daysInPrevMonth - i;
        const cell = createGridDayCell(dayNum, 'opacity-30 cursor-default', null);
        calendarGrid.appendChild(cell);
    }
    
    // Add current month's days
    for (let dayNum = 1; dayNum <= daysInMonth; dayNum++) {
        const date = new Date(year, month, dayNum);
        const dateStr = date.toISOString().split('T')[0];
        const dayEvents = events.filter(e => e.start_time.toISOString().split('T')[0] === dateStr);
        
        const isToday = date.toDateString() === new Date().toDateString();
        const cell = createGridDayCell(dayNum, isToday ? 'ring-2 ring-[hsl(var(--primary))]' : '', dayEvents, dateStr, dayNum);
        calendarGrid.appendChild(cell);
    }
    
    // Add next month's days
    const totalCells = calendarGrid.children.length;
    const remainingCells = 42 - totalCells; // 6 rows × 7 days (42 - 7 headers)
    for (let i = 1; i <= remainingCells; i++) {
        const cell = createGridDayCell(i, 'opacity-30 cursor-default', null);
        calendarGrid.appendChild(cell);
    }
}

function createGridDayCell(dayNum, classes, dayEvents, dateStr, originalDayNum) {
    const cell = document.createElement('div');
    cell.style.cssText = `
        padding: 0.75rem;
        border: 1px solid hsl(var(--border));
        border-radius: 0.5rem;
        min-height: 140px;
        display: flex;
        flex-direction: column;
        cursor: pointer;
        background-color: hsl(var(--card));
        transition: background-color 0.3s;
    `;
    
    cell.addEventListener('mouseenter', () => {
        cell.style.backgroundColor = 'hsl(var(--muted))';
    });
    cell.addEventListener('mouseleave', () => {
        cell.style.backgroundColor = 'hsl(var(--card))';
    });
    
    if (dateStr) {
        cell.addEventListener('click', () => showDayEvents(dateStr, originalDayNum));
    }
    
    // Day number
    const dayHeader = document.createElement('div');
    dayHeader.style.cssText = `
        font-size: 0.875rem;
        font-weight: bold;
        color: white;
        margin-bottom: 0.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid hsl(var(--border));
    `;
    dayHeader.textContent = dayNum;
    cell.appendChild(dayHeader);
    
    // Events
    if (dayEvents && dayEvents.length > 0) {
        const eventContainer = document.createElement('div');
        eventContainer.style.cssText = `
            display: flex;
            flex-direction: column;
            gap: 0.375rem;
            flex: 1;
            overflow: hidden;
        `;
        
        dayEvents.forEach((event, idx) => {
            if (idx < 3) { // Mostrar máximo 3 eventos
                const eventTag = document.createElement('div');
                const color = getTypeColor(event.type);
                eventTag.style.cssText = `
                    font-size: 0.6875rem;
                    padding: 0.375rem 0.5rem;
                    border-radius: 0.25rem;
                    font-weight: 500;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    cursor: pointer;
                    opacity: 0.9;
                    transition: opacity 0.2s;
                `;
                
                // Extraer colores sólidos
                if (event.type === 'meeting') {
                    eventTag.style.backgroundColor = '#3b82f6';
                    eventTag.style.color = 'white';
                } else if (event.type === 'delivery') {
                    eventTag.style.backgroundColor = '#10b981';
                    eventTag.style.color = 'white';
                } else if (event.type === 'test_drive') {
                    eventTag.style.backgroundColor = '#f97316';
                    eventTag.style.color = 'white';
                } else if (event.type === 'service') {
                    eventTag.style.backgroundColor = '#a855f7';
                    eventTag.style.color = 'white';
                } else {
                    eventTag.style.backgroundColor = '#6b7280';
                    eventTag.style.color = 'white';
                }
                
                eventTag.textContent = event.title;
                eventTag.title = event.title;
                eventTag.addEventListener('mouseenter', () => eventTag.style.opacity = '1');
                eventTag.addEventListener('mouseleave', () => eventTag.style.opacity = '0.9');
                eventContainer.appendChild(eventTag);
            }
        });
        
        if (dayEvents.length > 3) {
            const more = document.createElement('div');
            more.style.cssText = `
                font-size: 0.625rem;
                padding: 0.25rem 0.5rem;
                color: hsl(var(--muted-foreground));
                font-weight: 500;
            `;
            more.textContent = `+${dayEvents.length - 3} más`;
            eventContainer.appendChild(more);
        }
        
        cell.appendChild(eventContainer);
    } else if (dateStr) {
        const empty = document.createElement('div');
        empty.style.cssText = `
            font-size: 0.6875rem;
            color: hsl(var(--muted-foreground));
        `;
        empty.textContent = 'Sin eventos';
        cell.appendChild(empty);
    }
    
    return cell;
}

function renderCalendarList() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    document.getElementById('monthYear').textContent = `${monthNames[month]} ${year}`;
    
    const calendarList = document.getElementById('calendarList');
    calendarList.innerHTML = '';
    
    // Get all days in the month
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    
    for (let dayNum = 1; dayNum <= daysInMonth; dayNum++) {
        const date = new Date(year, month, dayNum);
        const dateStr = date.toISOString().split('T')[0];
        const dayEvents = events.filter(e => e.start_time.toISOString().split('T')[0] === dateStr);
        
        if (dayEvents.length > 0 || true) { // Mostrar todos los días
            const daySection = document.createElement('div');
            daySection.className = 'mb-6';
            
            // Day header
            const header = document.createElement('div');
            const dayNames = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
            const isToday = date.toDateString() === new Date().toDateString();
            header.className = `flex items-center gap-3 mb-3 pb-2 border-b border-[hsl(var(--border))] ${isToday ? 'bg-[hsl(var(--primary))]/20 px-3 py-2 rounded' : ''}`;
            header.innerHTML = `
                <div class="font-semibold text-white">
                    ${dayNames[date.getDay()]} ${dayNum} de ${monthNames[month]}
                </div>
                ${isToday ? '<span class="text-xs px-2 py-1 bg-[hsl(var(--primary))] text-[#0a0f14] rounded font-semibold">Hoy</span>' : ''}
                <div class="text-xs text-[hsl(var(--muted-foreground))] ml-auto">${dayEvents.length} evento${dayEvents.length !== 1 ? 's' : ''}</div>
            `;
            daySection.appendChild(header);
            
            // Events for this day
            if (dayEvents.length > 0) {
                const eventsDiv = document.createElement('div');
                eventsDiv.className = 'space-y-2 ml-4';
                
                dayEvents.forEach(event => {
                    const color = getTypeColor(event.type);
                    const startTime = new Date(event.start_time).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
                    
                    const eventDiv = document.createElement('div');
                    eventDiv.className = `flex gap-3 p-3 rounded-lg border ${color.border} ${color.bg} hover:bg-[hsl(var(--muted))] transition-colors cursor-pointer`;
                    eventDiv.innerHTML = `
                        <div class="min-w-[50px] text-center">
                            <div class="text-sm font-bold ${color.text}">${startTime}</div>
                        </div>
                        <div class="flex-1 border-l-2 ${color.text === 'text-blue-500' ? 'border-blue-500' : color.text === 'text-green-500' ? 'border-green-500' : color.text === 'text-orange-500' ? 'border-orange-500' : color.text === 'text-purple-500' ? 'border-purple-500' : 'border-gray-500'} pl-3">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-white">${event.title}</h4>
                                    ${event.description ? `<p class="text-xs text-[hsl(var(--muted-foreground))] mt-1">${event.description}</p>` : ''}
                                </div>
                            </div>
                            <div class="flex items-center gap-3 mt-2 flex-wrap">
                                <span class="px-2 py-0.5 text-xs font-semibold rounded ${color.badge}">${getTypeLabel(event.type)}</span>
                                ${event.client_name ? `<span class="text-xs text-[hsl(var(--muted-foreground))]">👤 ${event.client_name}</span>` : ''}
                                ${event.location ? `<span class="text-xs text-[hsl(var(--muted-foreground))]">📍 ${event.location}</span>` : ''}
                            </div>
                        </div>
                    `;
                    eventsDiv.appendChild(eventDiv);
                });
                
                daySection.appendChild(eventsDiv);
            } else {
                const emptyDiv = document.createElement('div');
                emptyDiv.className = 'text-xs text-[hsl(var(--muted-foreground))] ml-4 italic';
                emptyDiv.textContent = 'Sin eventos programados';
                daySection.appendChild(emptyDiv);
            }
            
            calendarList.appendChild(daySection);
        }
    }
}

function showDayEvents(dateStr, dayNum) {
    const dayEvents = events.filter(e => e.start_time.toISOString().split('T')[0] === dateStr);
    
    const date = new Date(dateStr);
    const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    const dayNames = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    
    document.getElementById('selectedDayTitle').textContent = 
        `${dayNames[date.getDay()]}, ${dayNum} de ${monthNames[date.getMonth()]}`;
    
    const eventsList = document.getElementById('eventsList');
    
    if (dayEvents.length === 0) {
        eventsList.innerHTML = '<p class="text-[hsl(var(--muted-foreground))]">No hay eventos este día</p>';
        return;
    }
    
    eventsList.innerHTML = dayEvents.map(event => {
        const color = getTypeColor(event.type);
        const startTime = new Date(event.start_time).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
        
        return `
            <div class="flex gap-4 p-4 rounded-lg border ${color.border} ${color.bg}">
                <div class="text-center min-w-[60px]">
                    <p class="text-xs ${color.text} font-bold">${startTime}</p>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">${event.start_time.toISOString().split('T')[0]}</p>
                </div>
                
                <div class="flex-1 border-l-2 ${color.text === 'text-blue-500' ? 'border-blue-500' : color.text === 'text-green-500' ? 'border-green-500' : color.text === 'text-orange-500' ? 'border-orange-500' : color.text === 'text-purple-500' ? 'border-purple-500' : 'border-gray-500'} pl-4">
                    <div class="flex items-start justify-between mb-1">
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-white">${event.title}</h4>
                            ${event.description ? `<p class="text-xs text-[hsl(var(--muted-foreground))] mt-1">${event.description}</p>` : ''}
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 mt-2">
                        <span class="px-2 py-0.5 text-xs font-medium rounded ${color.badge}">${getTypeLabel(event.type)}</span>
                        ${event.client_name ? `<span class="text-xs text-[hsl(var(--muted-foreground))]">${event.client_name}</span>` : ''}
                        ${event.location ? `<span class="text-xs text-[hsl(var(--muted-foreground))]">${event.location}</span>` : ''}
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

// Navigation
document.getElementById('prevMonth').addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    if (currentView === 'grid') {
        renderCalendarGrid();
    } else {
        renderCalendarList();
    }
});

document.getElementById('nextMonth').addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    if (currentView === 'grid') {
        renderCalendarGrid();
    } else {
        renderCalendarList();
    }
});

// View toggle
document.getElementById('gridViewBtn').addEventListener('click', () => switchView('grid'));
document.getElementById('listViewBtn').addEventListener('click', () => switchView('list'));

// Initial render
if (currentView === 'grid') {
    renderCalendarGrid();
    document.getElementById('listViewContainer').style.display = 'none';
    document.getElementById('gridViewContainer').style.display = 'block';
    document.getElementById('gridViewBtn').className = 'px-4 py-2 rounded transition-colors bg-[hsl(var(--primary))] text-[#0a0f14] font-semibold text-sm flex items-center gap-2';
    document.getElementById('listViewBtn').className = 'px-4 py-2 rounded transition-colors hover:bg-[hsl(var(--muted))] text-[hsl(var(--foreground))] text-sm flex items-center gap-2';
} else {
    renderCalendarList();
    document.getElementById('gridViewContainer').style.display = 'none';
    document.getElementById('listViewContainer').style.display = 'block';
    document.getElementById('gridViewBtn').className = 'px-4 py-2 rounded transition-colors hover:bg-[hsl(var(--muted))] text-[hsl(var(--foreground))] text-sm flex items-center gap-2';
    document.getElementById('listViewBtn').className = 'px-4 py-2 rounded transition-colors bg-[hsl(var(--primary))] text-[#0a0f14] font-semibold text-sm flex items-center gap-2';
}
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos\resources\views/events/index.blade.php ENDPATH**/ ?>