@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <a href="{{ route('admin.domains.index') }}" class="text-blue-600 hover:text-blue-900">← Volver</a>
                <h1 class="mt-2 text-3xl font-bold text-gray-900">{{ $domain->domain }}</h1>
                <p class="mt-1 text-gray-600">Detalles y configuración del dominio</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.domains.edit', $domain) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Editar
                </a>
                <form action="{{ route('admin.domains.destroy', $domain) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700" onclick="return confirm('¿Estás seguro?')">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>

        <!-- Status Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Tipo</p>
                        <p class="text-lg font-medium text-gray-900">{{ ucfirst($domain->type) }}</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                        :class="@js($domain->type === 'new' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')">
                        {{ $domain->type }}
                    </span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Registro</p>
                        <p class="text-lg font-medium text-gray-900">{{ $domainReport['format_valid'] ? '✓ Válido' : '✗ Inválido' }}</p>
                    </div>
                    <span class="text-2xl">{{ $domainReport['format_valid'] ? '✓' : '✗' }}</span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">DNS</p>
                        <p class="text-lg font-medium text-gray-900">{{ $domain->dns_configured ? 'Configurado' : 'Pendiente' }}</p>
                    </div>
                    <span class="text-2xl">{{ $domain->dns_configured ? '✓' : '⏳' }}</span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">SSL</p>
                        <p class="text-lg font-medium text-gray-900">{{ $domain->ssl_verified ? 'Verificado' : 'Pendiente' }}</p>
                    </div>
                    <span class="text-2xl">{{ $domain->ssl_verified ? '✓' : '⏳' }}</span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- DNS Configuration -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-900">Configuración DNS</h2>
                        @if (!$domain->dns_configured)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                Pendiente
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Configurado
                            </span>
                        @endif
                    </div>

                    @if (count($domainReport['dns_records']) > 0)
                        <div class="space-y-4">
                            @foreach ($domainReport['dns_records'] as $type => $records)
                                @if (!empty($records))
                                    <div class="border rounded-lg p-4">
                                        <h3 class="font-medium text-gray-900 mb-2">Registros {{ $type }}</h3>
                                        <div class="space-y-2">
                                            @foreach ($records as $record)
                                                <div class="text-sm font-mono text-gray-600 bg-gray-50 p-2 rounded">
                                                    {{ json_encode($record, JSON_PRETTY_PRINT) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-sm text-yellow-700">
                                <strong>Aún no hay registros DNS configurados.</strong> Consulta la sección de sugerencias para saber qué registros necesitas.
                            </p>
                        </div>
                    @endif
                </div>

                <!-- SSL Certificate -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-900">Certificado SSL</h2>
                        @if ($domainReport['ssl_certificate']['valid'])
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Válido
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                No verificado
                            </span>
                        @endif
                    </div>

                    @if ($domainReport['ssl_certificate']['valid'])
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-600">Nombre Común</p>
                                <p class="font-mono text-gray-900">{{ $domainReport['ssl_certificate']['common_name'] }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Emisor</p>
                                <p class="font-mono text-gray-900">{{ $domainReport['ssl_certificate']['issuer'] }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Expira el</p>
                                <p class="font-mono text-gray-900">{{ $domainReport['ssl_certificate']['expires_at'] }}</p>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-sm text-yellow-700">
                                <strong>{{ $domainReport['ssl_certificate']['error'] }}</strong>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Suggestions & Next Steps -->
            <div>
                <!-- DNS Suggestions -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Sugerencias DNS</h3>
                    <div class="space-y-4">
                        @foreach ($domainReport['dns_suggestions'] as $suggestion)
                            <div class="border rounded-lg p-3 {{ $suggestion['required'] ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="font-medium text-sm text-gray-900">{{ $suggestion['name'] }}</p>
                                        <p class="text-xs text-gray-600 mt-1">{{ $suggestion['description'] }}</p>
                                        <p class="font-mono text-xs text-gray-500 mt-2 break-words">{{ $suggestion['example'] }}</p>
                                    </div>
                                    @if ($suggestion['required'])
                                        <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded">Requerido</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Próximos Pasos</h3>
                    <ol class="space-y-3">
                        @if ($domainReport['format_valid'] && $domain->registration_status === 'available')
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-blue-100 text-blue-700 text-sm font-medium">1</span>
                                <p class="text-sm text-gray-700">Registra el dominio en tu registrador</p>
                            </li>
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-gray-200 text-gray-400 text-sm font-medium">2</span>
                                <p class="text-sm text-gray-500">Configura los registros DNS</p>
                            </li>
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-gray-200 text-gray-400 text-sm font-medium">3</span>
                                <p class="text-sm text-gray-500">Instala un certificado SSL</p>
                            </li>
                        @elseif (!$domain->dns_configured)
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-blue-100 text-blue-700 text-sm font-medium">1</span>
                                <p class="text-sm text-gray-700">Configura los registros DNS</p>
                            </li>
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-gray-200 text-gray-400 text-sm font-medium">2</span>
                                <p class="text-sm text-gray-500">Instala un certificado SSL</p>
                            </li>
                        @elseif (!$domain->ssl_verified)
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-blue-100 text-blue-700 text-sm font-medium">1</span>
                                <p class="text-sm text-gray-700">Instala un certificado SSL</p>
                            </li>
                        @else
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-green-100 text-green-700 text-sm font-medium">✓</span>
                                <p class="text-sm text-gray-700"><strong>El dominio está completamente configurado</strong></p>
                            </li>
                        @endif
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
