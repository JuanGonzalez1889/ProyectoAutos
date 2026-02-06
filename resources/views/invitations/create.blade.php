@extends('layouts.admin')

@section('title', 'Invitar Colaborador')
@section('page-title', 'Invitar Colaborador')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg shadow-lg p-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-[hsl(var(--foreground))] mb-2">Invitar Colaborador</h2>
            <p class="text-[hsl(var(--muted-foreground))]">Envía una invitación para que otros usuarios se unan a tu agencia</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-lg">
                <p class="text-red-500 font-semibold mb-2">Errores encontrados:</p>
                <ul class="text-red-400 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-lg">
                <p class="text-green-400">✓ {{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('admin.invitations.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold text-[hsl(var(--foreground))] mb-2">
                    Email del Colaborador
                </label>
                <input 
                    type="email" 
                    name="email" 
                    required
                    class="w-full px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                    placeholder="colaborador@empresa.com"
                    value="{{ old('email') }}">
                <p class="mt-1 text-xs text-[hsl(var(--muted-foreground))]">
                    Se enviará una invitación a este email con un link para registrarse
                </p>
            </div>

            <!-- Rol -->
            <div>
                <label class="block text-sm font-semibold text-[hsl(var(--foreground))] mb-2">
                    Rol Asignado
                </label>
                <select 
                    name="role" 
                    required
                    class="w-full px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                    onchange="updatePermissionsDisplay(this.value)">
                    <option value="">Seleccionar rol...</option>
                    <option value="collaborator" {{ old('role') === 'collaborator' ? 'selected' : '' }}>
                        Colaborador - Acceso limitado a vehículos y leads
                    </option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                        Administrador - Acceso completo a la agencia
                    </option>
                </select>
            </div>

            <!-- Permisos específicos (solo si es collaborator) -->
            <div id="permissionsDiv" style="display: none;">
                <label class="block text-sm font-semibold text-[hsl(var(--foreground))] mb-3">
                    Permisos Específicos
                </label>
                <div class="space-y-3 bg-[hsl(var(--background))] p-4 rounded-lg border border-[hsl(var(--border))]">
                    <div class="flex items-center">
                        <input type="checkbox" name="permissions[]" value="vehicles.view" id="perm_vehicles_view" class="w-4 h-4">
                        <label for="perm_vehicles_view" class="ml-3 text-sm text-[hsl(var(--foreground))]">
                            Ver vehículos
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="permissions[]" value="vehicles.create" id="perm_vehicles_create" class="w-4 h-4">
                        <label for="perm_vehicles_create" class="ml-3 text-sm text-[hsl(var(--foreground))]">
                            Crear/Editar vehículos
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="permissions[]" value="leads.view" id="perm_leads_view" class="w-4 h-4">
                        <label for="perm_leads_view" class="ml-3 text-sm text-[hsl(var(--foreground))]">
                            Ver leads
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="permissions[]" value="leads.edit" id="perm_leads_edit" class="w-4 h-4">
                        <label for="perm_leads_edit" class="ml-3 text-sm text-[hsl(var(--foreground))]">
                            Editar leads
                        </label>
                    </div>
                </div>
                <p class="mt-2 text-xs text-[hsl(var(--muted-foreground))]">
                    Los administradores tienen todos los permisos automáticamente
                </p>
            </div>

            <!-- Botones -->
            <div class="flex gap-3 pt-4 border-t border-[hsl(var(--border))]">
                <button 
                    type="submit" 
                    class="flex-1 px-6 py-2.5 bg-[hsl(var(--primary))] hover:bg-[hsl(var(--primary))]/80 text-[hsl(var(--primary-foreground))] rounded-lg font-semibold transition">
                    Enviar Invitación
                </button>
                <a 
                    href="{{ route('admin.invitations.index') }}" 
                    class="flex-1 px-6 py-2.5 bg-[hsl(var(--secondary))] hover:bg-[hsl(var(--secondary))]/80 text-[hsl(var(--foreground))] rounded-lg font-semibold transition text-center">
                    Ver Invitaciones
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function updatePermissionsDisplay(role) {
    const permissionsDiv = document.getElementById('permissionsDiv');
    if (role === 'collaborator') {
        permissionsDiv.style.display = 'block';
    } else {
        permissionsDiv.style.display = 'none';
    }
}

// Inicializar en caso de que haya un valor previo
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.querySelector('select[name="role"]');
    updatePermissionsDisplay(roleSelect.value);
});
</script>
@endsection
