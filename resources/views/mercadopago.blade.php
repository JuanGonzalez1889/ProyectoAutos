@extends('layouts.public')

@section('content')
<div class="container">
    <h2>Pagar con MercadoPago</h2>
    @if(Auth::check())
        <p>Usuario logueado: {{ Auth::user()->email }}</p>
        @if(isset($preferenceId) && isset($publicKey))
            <!-- Checkout PRO Botón clásico -->
            <script src="https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js"
                data-preference-id="{{ $preferenceId }}"
                data-button-label="Pagar con MercadoPago"
                data-public-key="{{ $publicKey }}">
            </script>
        @else
            <!-- Botón de pago MercadoPago -->
            <form action="/mercadopago/checkout" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Pagar con MercadoPago</button>
            </form>
        @endif
        @if(isset($mpError) && $mpError)
            <div class="alert alert-danger mt-3">
                <strong>Error MercadoPago:</strong><br>
                <pre>{{ $mpError }}</pre>
            </div>
        @endif
    @else
        <p>Debes iniciar sesión para pagar.</p>
    @endif
</div>
@endsection
