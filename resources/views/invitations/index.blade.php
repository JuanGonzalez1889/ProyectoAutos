@extends('layouts.admin')

@section('title', 'Invitaciones Pendientes')
@section('page-title', 'Invitaciones Pendientes')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-[hsl(var(--foreground))]">Invitaciones Pendientes</h2>
            <p class="text-[hsl(var(--muted-foreground))] text-sm mt-1">
                Gestiona las invitaciones enviadas a colaboradores
            </p>
        </div>
        <a 
            href="{{ route('admin.invitations.create') }}"
            class="px-6 py-2.5 bg-[hsl(var(--primary))] hover:bg-[hsl(var(--primary))]/80 text-[hsl(var(--primary-foreground))] rounded-lg font-semibold transition">
            + Nueva Invitación
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-lg">
            <p class="text-green-400">✓ {{ session('success') }}</p>
        </div>
    @endif

    @if ($invitations->isEmpty())
        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-12 text-center">
            <div class="text-6xl mb-4">📧</div>
            <h3 class="text-lg font-semibold text-[hsl(var(--foreground))] mb-2">Sin invitaciones pendientes</h3>
            <p class="text-[hsl(var(--muted-foreground))] mb-6">
                Invita a colaboradores para que se unan a tu agencia
            </p>
            <a 
                href="{{ route('admin.invitations.create') }}"
                class="inline-block px-6 py-2.5 bg-[hsl(var(--primary))] hover:bg-[hsl(var(--primary))]/80 text-[hsl(var(--primary-foreground))] rounded-lg font-semibold transition">
                Enviar Primera Invitación
            </a>
        </div>
    @else
        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-[hsl(var(--border))] bg-[hsl(var(--muted))]/30">
                        <th class="px-6 py-3 text-left text-sm font-semibold text-[hsl(var(--foreground))]">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-[hsl(var(--foreground))]">Rol</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-[hsl(var(--foreground))]">Enviado</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-[hsl(var(--foreground))]">Expira</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-[hsl(var(--foreground))]">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invitations as $invitation)
                        <tr class="border-b border-[hsl(var(--border))] last:border-b-0 hover:bg-[hsl(var(--muted))]/10 transition">
                            <td class="px-6 py-4 text-sm text-[hsl(var(--foreground))]">
                                {{ $invitation->email }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $invitation->role === 'admin' ? 'bg-purple-500/20 text-purple-400' : 'bg-blue-500/20 text-blue-400' }}">
                                    {{ ucfirst($invitation->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-[hsl(var(--muted-foreground))]">
                                {{ $invitation->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="
                                    {{ $invitation->expires_at->isFuture() ? 'text-green-400' : 'text-red-400' }}
                                ">
                                    {{ $invitation->expires_at->format('d/m/Y') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Copiar link -->
                                    <button 
                                        onclick="copyLink('{{ route('invitations.accept-form', $invitation->token) }}')"
                                        class="p-2 hover:bg-[hsl(var(--muted))]/50 rounded text-[hsl(var(--muted-foreground))] hover:text-[hsl(var(--foreground))] transition"
                                        title="Copiar link de invitación">
                                        📋
                                    </button>
                                    
                                    <!-- Cancelar -->
                                    <form 
                                        action="{{ route('admin.invitations.destroy', $invitation->id) }}" 
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('¿Cancelar esta invitación?')">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit"
                                            class="p-2 hover:bg-red-500/20 rounded text-red-400 hover:text-red-300 transition">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 p-4 bg-blue-500/10 border border-blue-500/20 rounded-lg">
            <p class="text-sm text-blue-400">
                <strong>💡 Tip:</strong> Las invitaciones expiran en 7 días. Los colaboradores pueden aceptarla desde el link de invitación.
            </p>
        </div>
    @endif
</div>

<script>
function copyLink(link) {
    navigator.clipboard.writeText(link).then(() => {
        alert('Link de invitación copiado al portapapeles ✓');
    }).catch(() => {
        alert('Error al copiar. Link: ' + link);
    });
}
</script>
@endsection
