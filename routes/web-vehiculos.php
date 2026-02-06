<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\VehiculoController;

Route::get('/vehiculos', [VehiculoController::class, 'index'])->name('public.vehiculos');
Route::get('/vehiculos/{vehicle}', [VehiculoController::class, 'show'])->name('public.vehiculos.show');
