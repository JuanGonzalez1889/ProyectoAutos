@extends('layouts.admin')

@section('title', 'Editar Usuario')
@section('page-title', 'Editar Usuario')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre completo *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                       class="input-field @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                       class="input-field @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Nueva Contraseña (dejar en blanco para no cambiar)</label>
                <input type="password" name="password" id="password"
                       class="input-field @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nueva Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="input-field">
            </div>

            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Rol *</label>
                <select name="role" id="role" required
                        class="input-field @error('role') border-red-500 @enderror">
                    <option value="">Seleccionar rol...</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" 
                                {{ old('role', $user->roles->first()->name ?? '') === $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if(auth()->user()->isAdmin())
            <div class="mb-4">
                <label for="agencia_id" class="block text-sm font-medium text-gray-700">Agencia (opcional)</label>
                <select name="agencia_id" id="agencia_id"
                        class="input-field @error('agencia_id') border-red-500 @enderror">
                    <option value="">Sin agencia</option>
                    @foreach($agencias as $agencia)
                        <option value="{{ $agencia->id }}" 
                                {{ old('agencia_id', $user->agencia_id) == $agencia->id ? 'selected' : '' }}>
                            {{ $agencia->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('agencia_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @if($user->agencia)
                    <p class="mt-1 text-xs text-[hsl(var(--muted-foreground))]">Agencia actual: {{ $user->agencia->nombre }}</p>
                @endif
            </div>
            @endif

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" 
                           {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Usuario activo</span>
                </label>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                    Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    Actualizar Usuario
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
