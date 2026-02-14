@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    <h1 class="text-danger">¡Pago rechazado!</h1>
    <p>Tu pago no pudo ser procesado. Por favor, intenta nuevamente o utiliza otro método de pago.</p>
    <a href="{{ route('subscriptions.index') }}" class="btn btn-primary mt-3">Volver a las suscripciones</a>
</div>
@endsection
