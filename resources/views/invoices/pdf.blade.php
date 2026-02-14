@extends('layouts.pdf')

@section('content')
    <div style="display: flex; align-items: center; margin-bottom: 24px;">
        <img src="https://autowebpro.com.ar/logo-autowebpro.png" alt="AutoWebPro" style="height: 48px; margin-right: 20px;">
        <div>
            <h1 style="margin: 0; font-size: 26px;">Factura #{{ $invoice->invoice_number }}</h1>
            <div style="font-size: 13px; color: #888;">{{ $domain ? $domain->domain : '' }}</div>
        </div>
    </div>
    <div class="info">
        <span class="label">Fecha:</span> {{ $invoice->created_at->format('d/m/Y') }}<br>
        <span class="label">Monto:</span> ${{ number_format($invoice->total, 2) }} {{ strtoupper($invoice->currency) }}<br>
        <span class="label">Método de pago:</span> {{ ucfirst($invoice->payment_method) }}<br>
        <span class="label">Estado:</span> {{ ucfirst($invoice->status) }}<br>
    </div>
    <hr>
    <div class="info">
        <span class="label">Cliente:</span> 
        @if(isset($tenant))
            {{ $tenant->name }}<br>
            @if($tenant->billing_address)
                <span class="label">Dirección:</span> {{ $tenant->billing_address }}<br>
            @elseif($tenant->address)
                <span class="label">Dirección:</span> {{ $tenant->address }}<br>
            @endif
            @if($tenant->email)
                <span class="label">Email:</span> {{ $tenant->email }}<br>
            @endif
            @if($tenant->phone)
                <span class="label">Teléfono:</span> {{ $tenant->phone }}<br>
            @endif
        @else
            N/A<br>
        @endif
        <span class="label">Descripción:</span> {{ $invoice->description ?? 'N/A' }}
    </div>
@endsection
