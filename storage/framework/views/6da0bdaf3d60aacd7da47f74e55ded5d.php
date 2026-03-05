

<?php $__env->startSection('title', 'Vehículos'); ?>
<?php $__env->startSection('page-title', 'Gestión de Vehículos'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-semibold text-white mb-1">Inventario de Vehículos</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Administra todos los vehículos disponibles</p>
        </div>
        
        <a href="<?php echo e(route('admin.vehicles.create')); ?>" 
           class="h-10 px-5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Agregar Vehículo
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="p-4 bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500/20 rounded-lg">
                    <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"></path>
                        <circle cx="7" cy="17" r="2"></circle>
                        <circle cx="17" cy="17" r="2"></circle>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Total</p>
                    <p class="text-2xl font-bold text-white"><?php echo e($vehicles->total()); ?></p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-green-500/20 rounded-lg">
                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Publicados</p>
                    <p class="text-2xl font-bold text-green-500"><?php echo e($vehicles->where('status', 'published')->count()); ?></p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-gradient-to-br from-yellow-500/10 to-yellow-600/10 border border-yellow-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-yellow-500/20 rounded-lg">
                    <svg class="h-5 w-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Borradores</p>
                    <p class="text-2xl font-bold text-yellow-500"><?php echo e($vehicles->where('status', 'draft')->count()); ?></p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-gradient-to-br from-red-500/10 to-red-600/10 border border-red-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-red-500/20 rounded-lg">
                    <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Vendidos</p>
                    <p class="text-2xl font-bold text-red-500"><?php echo e($vehicles->where('status', 'sold')->count()); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid de vehículos -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card p-0 overflow-hidden group max-w-xs">
            <!-- Imagen -->
            <div class="relative bg-gradient-to-br from-gray-700 to-gray-900 overflow-hidden" style="height: 140px;">
                <img src="<?php echo e($vehicle->main_image); ?>" 
                     alt="<?php echo e($vehicle->title); ?>" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                
                <!-- Badges -->
                <div class="absolute top-3 left-3 flex gap-2">
                    <?php if($vehicle->status === 'published'): ?>
                        <span class="px-2 py-1 text-xs font-medium rounded bg-green-500 text-white">Publicado</span>
                    <?php elseif($vehicle->status === 'draft'): ?>
                        <span class="px-2 py-1 text-xs font-medium rounded bg-yellow-500 text-white">Borrador</span>
                    <?php else: ?>
                        <span class="px-2 py-1 text-xs font-medium rounded bg-red-500 text-white">Vendido</span>
                    <?php endif; ?>
                    
                    <?php if($vehicle->featured): ?>
                        <span class="px-2 py-1 text-xs font-medium rounded bg-[hsl(var(--primary))] text-[#0a0f14]">⭐ Destacado</span>
                    <?php endif; ?>
                </div>

                <!-- Contador de imágenes -->
                <?php if($vehicle->images && count($vehicle->images) > 1): ?>
                <div class="absolute bottom-3 right-3 px-2 py-1 text-xs font-medium rounded bg-black/60 text-white flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <?php echo e(count($vehicle->images)); ?>

                </div>
                <?php endif; ?>
            </div>

            <!-- Contenido -->
            <div class="p-3">
                <h3 class="font-semibold text-sm text-white mb-0.5 truncate"><?php echo e($vehicle->title); ?></h3>
                <p class="text-[11px] text-[hsl(var(--muted-foreground))] mb-2">
                    <?php echo e($vehicle->year); ?> • <?php echo e(number_format($vehicle->kilometers)); ?> km • <?php echo e($vehicle->fuel_type); ?>

                </p>
                
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <?php if($vehicle->price_original && $vehicle->price_original > $vehicle->price): ?>
                            <p class="text-[10px] text-[hsl(var(--muted-foreground))] line-through">$<?php echo e(number_format($vehicle->price_original)); ?></p>
                        <?php endif; ?>
                        <p class="text-lg font-bold text-[hsl(var(--primary))]">$<?php echo e(number_format($vehicle->price)); ?></p>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="pt-2 border-t border-[hsl(var(--border))]">
                    <div class="flex gap-2 w-full mb-2">
                        <a href="<?php echo e(route('admin.vehicles.edit', $vehicle)); ?>" 
                           class="flex-1 h-8 px-2 bg-blue-500/20 hover:bg-blue-500/30 text-blue-500 rounded-md text-xs font-medium transition-colors flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar
                        </a>
                        <form action="<?php echo e(route('admin.vehicles.destroy', $vehicle)); ?>" method="POST" class="flex-1"
                              onsubmit="return confirm('¿Estás seguro de eliminar este vehículo?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" 
                                    class="w-full h-8 px-2 bg-red-500/20 hover:bg-red-500/30 text-red-500 rounded-md text-xs font-medium transition-colors flex items-center justify-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Eliminar
                            </button>
                        </form>
                    </div>
                    <?php if($vehicle->status === 'sold'): ?>
                        <button type="button" class="w-full h-9 mt-2 px-2 bg-gray-400 text-white rounded-md text-xs font-medium flex items-center justify-center gap-2 cursor-not-allowed opacity-60" disabled>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Marcar como vendido
                        </button>
                    <?php else: ?>
                        <button type="button"
                            class="w-full h-9 mt-2 px-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-xs font-medium transition-colors flex items-center justify-center gap-2"
                            data-mark-sold-btn data-vehicle-id="<?php echo e($vehicle->id); ?>">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Marcar como vendido
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full py-16 text-center">
            <svg class="mx-auto h-16 w-16 text-[hsl(var(--muted-foreground))]/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <p class="text-[hsl(var(--muted-foreground))] mb-4">No hay vehículos registrados</p>
            <a href="<?php echo e(route('admin.vehicles.create')); ?>" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Agregar primer vehículo
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Paginación -->
    <?php if($vehicles->hasPages()): ?>
    <div class="flex justify-center">
        <?php echo e($vehicles->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<!-- Modal HTML puro -->
<div id="soldPriceModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.6); align-items:center; justify-content:center;">
    <div style="background:#000427; border-radius:10px; box-shadow:0 8px 32px #0003; padding:2rem; max-width:350px; width:90vw; margin:auto;">
        <h2 style="font-size:1.3rem; font-weight:bold; margin-bottom:1rem; color:#ffffff;">Registrar valor de venta</h2>
        <form id="soldPriceForm">
            <label style="font-size:0.95rem; font-weight:500; color:#ffffff; margin-bottom:0.5rem; display:block;">¿A qué valor se vendió el vehículo?</label>
            <input type="text" id="soldPriceInput" required placeholder="Ej: 2.500.000" style="width:100%; height:2.5rem; padding:0 1rem; border:1px solid #ccc; border-radius:6px; margin-bottom:1rem; font-size:1rem; color:#333; background:#fff;" oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');">
            <div style="display:flex; justify-content:flex-end; gap:0.5rem;">
                <button type="button" id="cancelSoldPriceBtn" style="padding:0.5rem 1.2rem; border-radius:5px; background:#eee; color:#333; border:none;">Cancelar</button>
                <button type="submit" style="padding:0.5rem 1.2rem; border-radius:5px; background:rgb(22 163 74 / var(--tw-bg-opacity, 1)); color:white; border:none;">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentVehicleId = null;
    document.querySelectorAll('[data-mark-sold-btn]').forEach(btn => {
        btn.addEventListener('click', function() {
            currentVehicleId = this.getAttribute('data-vehicle-id');
            document.getElementById('soldPriceModal').style.display = 'flex';
            document.getElementById('soldPriceInput').value = '';
            document.getElementById('soldPriceInput').focus();
        });
    });
    document.getElementById('cancelSoldPriceBtn').onclick = function() {
        document.getElementById('soldPriceModal').style.display = 'none';
    };
    document.getElementById('soldPriceForm').onsubmit = async function(e) {
        e.preventDefault();
        const soldPriceRaw = document.getElementById('soldPriceInput').value.replace(/\./g, '');
        if (!soldPriceRaw || !currentVehicleId) return;
        const soldPrice = parseInt(soldPriceRaw, 10);
        try {
            const resp = await fetch(`/admin/vehicles/${currentVehicleId}/mark-as-sold`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ sold_price: soldPrice })
            });
            if (resp.ok) {
                window.location.reload();
            } else {
                const data = await resp.json();
                alert(data.message || 'Error al guardar el precio de venta.');
            }
        } catch (err) {
            alert('Error de red o servidor.');
        }
        document.getElementById('soldPriceModal').style.display = 'none';
    };
});
</script>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views/admin/vehicles/index.blade.php ENDPATH**/ ?>