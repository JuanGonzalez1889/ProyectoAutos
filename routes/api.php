<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Aplicar rate limiting a todas las rutas de API
Route::middleware(['throttle:api'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
    
    // Aquí se agregarán más rutas de API en el futuro
    // Ejemplo: endpoints para vehículos, leads, analytics, etc.
});
