@extends('layouts.admin')

@section('title', 'Detalles del Dominio - ' . $domain->domain)
@section('page-title', 'Detalles del Dominio')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.domains.index') }}" 
           class="p-2 hover:bg-[hsl(var(--muted))] rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h3 class="text-xl font-semibold text-white">{{ $domain->domain }}</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Detalles y configuración del dominio</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información Principal -->
        <div class="lg:col-span-2 space-y-6">
            <div class="card">
                <h2 class="text-lg font-semibold text-white mb-4">Información del Dominio</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase">Dominio</label>
                        <p class="mt-2 text-white font-mono text-sm font-medium bg-[hsl(var(--muted))]/50 px-3 py-2 rounded">{{ $domain->domain }}</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase mb-2">Tipo</label>
                        <div>
                            @if($domain->type === 'new')
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-xs font-semibold border border-green-500/30">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    🆕 Dominio Nuevo
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-xs font-semibold border border-blue-500/30">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    📎 Dominio Existente
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase">Registrado</label>
                            <p class="mt-2 text-white">{{ $domain->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase">Hora</label>
                            <p class="mt-2 text-white">{{ $domain->created_at->format('H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Instrucciones según tipo -->
                <div class="mt-8 pt-8 border-t border-[hsl(var(--border))]">
                    @if($domain->type === 'new')
                        <div class="card border-l-4 border-l-green-500 bg-green-500/5">
                            <h3 class="font-semibold text-green-400 mb-3">📝 Próximos Pasos para Dominio Nuevo</h3>
                            <ol class="text-xs text-[hsl(var(--muted-foreground))] space-y-2 list-decimal list-inside">
                                <li>Contacta con nosotros para registrar el dominio</li>
                                <li>Proporciona el nombre deseado: <code class="bg-[hsl(var(--muted))] px-2 py-1 rounded text-white">{{ $domain->domain }}</code></li>
                                <li>Una vez registrado, configuraremos los DNS automáticamente</li>
                                <li>Tu dominio estará listo en 24-48 horas</li>
                            </ol>
                        </div>
                    @else
                        <div class="card border-l-4 border-l-blue-500 bg-blue-500/5">
                            <h3 class="font-semibold text-blue-400 mb-3">🔧 Configuración para Dominio Existente</h3>
                            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-4">Debes actualizar la configuración de tu dominio en tu proveedor actual:</p>
                            
                            <div class="bg-[hsl(var(--muted))]/50 rounded p-3 mb-4 font-mono text-xs space-y-2">
                                <p class="text-blue-400 font-semibold">Opción 1: CNAME (Recomendado)</p>
                                <p class="text-[hsl(var(--muted-foreground))]">Crea un registro CNAME:</p>
                                <p class="text-white"><code>{{ $domain->domain }} → www.proyectoautos.com</code></p>
                            </div>

                            <div class="bg-[hsl(var(--muted))]/50 rounded p-3 font-mono text-xs space-y-2">
                                <p class="text-blue-400 font-semibold">Opción 2: Nameservers</p>
                                <p class="text-[hsl(var(--muted-foreground))]">Reemplaza los nameservers con:</p>
                                <p class="text-white"><code>ns1.proyectoautos.com</code></p>
                                <p class="text-white"><code>ns2.proyectoautos.com</code></p>
                            </div>

                            <p class="text-xs text-blue-400 mt-4">
                                <strong>⏱️ Los cambios pueden tardar 24-48 horas en propagarse.</strong>
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Botones de acción -->
                <div class="mt-8 pt-8 border-t border-[hsl(var(--border))] flex gap-3">
                    <a href="{{ route('admin.domains.edit', $domain) }}" 
                       class="px-4 py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg transition font-semibold">
                        ✏️ Editar
                    </a>
                    <form action="{{ route('admin.domains.destroy', $domain) }}" method="POST" class="inline" 
                          onsubmit="return confirm('¿Estás seguro de que deseas eliminar este dominio?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500/20 hover:bg-red-500/30 text-red-400 rounded-lg transition font-semibold border border-red-500/30">
                            🗑️ Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Estado -->
            <div class="card">
                <h3 class="text-lg font-semibold text-white mb-4">Estado</h3>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-[hsl(var(--muted-foreground))] uppercase font-semibold">Estado</p>
                        <p class="text-lg font-semibold text-green-400 mt-1">✓ Activo</p>
                    </div>

                    <div class="pt-3 border-t border-[hsl(var(--border))]">
                        <p class="text-xs text-[hsl(var(--muted-foreground))] uppercase font-semibold">Agencia</p>
                        <p class="text-white font-medium mt-1">{{ $tenant->name }}</p>
                    </div>
                </div>
            </div>

            <!-- Contacto -->
            <div class="card">
                <h3 class="text-lg font-semibold text-white mb-4">¿Necesitas Ayuda?</h3>
                
                <p class="text-xs text-[hsl(var(--muted-foreground))] mb-4">
                    Si tienes problemas con la configuración del dominio, contacta con nuestro equipo de soporte.
                
                <a href="mailto:soporte@proyectoautos.com" 
                   class="w-full px-4 py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg transition font-semibold text-center text-sm">
                    📧 Contactar Soporte
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
