<?php

use App\Http\Controllers\Admin\AgenciaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\LandingConfigController;
use App\Http\Controllers\Admin\LandingTemplateController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\PublicLandingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas
Route::get('/', [PublicLandingController::class, 'show'])->name('public.landing');
Route::post('/contacto', [PublicLandingController::class, 'submitContact'])->name('public.contact');
Route::get('/landing-preview/{template}', [LandingTemplateController::class, 'preview'])->middleware('auth')->name('landing.preview');

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Google OAuth
    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

// Rutas protegidas
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Panel de administración
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard - Accesible para todos los usuarios autenticados
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Gestión de Agencia - Solo para AGENCIERO
        Route::get('/agencia', [AgenciaController::class, 'show'])->name('agencia.show');
        Route::put('/agencia', [AgenciaController::class, 'update'])->name('agencia.update');
        
        // Gestión de usuarios - Solo para usuarios con permisos
        Route::middleware('permission:users.view')->group(function () {
            Route::resource('users', UserController::class);
            Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
                ->name('users.toggle-status')
                ->middleware('permission:users.edit');
        });
        
        // Gestión de vehículos - Todos los usuarios autenticados
        Route::resource('vehicles', VehicleController::class);
        
        // Gestión de tareas - Todos los usuarios autenticados
        Route::get('/tasks', [\App\Http\Controllers\TaskController::class, 'index'])->name('tasks.index');
        Route::post('/tasks', [\App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
        Route::patch('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'update'])->name('tasks.update');
        Route::patch('/tasks/{task}/status', [\App\Http\Controllers\TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
        Route::delete('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'destroy'])->name('tasks.destroy');
        
        // Gestión de eventos/calendario - Todos los usuarios autenticados
        Route::get('/events', [\App\Http\Controllers\EventController::class, 'index'])->name('events.index');
        Route::post('/events', [\App\Http\Controllers\EventController::class, 'store'])->name('events.store');
        Route::patch('/events/{event}', [\App\Http\Controllers\EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [\App\Http\Controllers\EventController::class, 'destroy'])->name('events.destroy');
        Route::get('/calendar', [\App\Http\Controllers\EventController::class, 'calendar'])->name('events.calendar');
        
        // Gestión de leads - Todos los usuarios autenticados
        Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
        Route::get('/leads/create', [LeadController::class, 'create'])->name('leads.create');
        Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
        Route::get('/leads/{lead}/edit', [LeadController::class, 'edit'])->name('leads.edit');
        Route::patch('/leads/{lead}', [LeadController::class, 'update'])->name('leads.update');
        Route::patch('/leads/{lead}/status', [LeadController::class, 'updateStatus'])->name('leads.updateStatus');
        Route::delete('/leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');

        // Gestión de Dominios - Solo para AGENCIERO
        Route::resource('domains', DomainController::class);

        // Configuración de Landing Page
        Route::get('/landing-config', [LandingConfigController::class, 'show'])->name('landing-config.show');
        Route::patch('/landing-config', [LandingConfigController::class, 'update'])->name('landing-config.update');
        Route::post('/landing-config/upload-image', [LandingConfigController::class, 'uploadImage'])->name('landing-config.upload-image');

        // Plantillas de Landing
        Route::get('/landing-templates', [LandingTemplateController::class, 'select'])->name('landing-template.select');
        Route::post('/landing-templates', [LandingTemplateController::class, 'store'])->name('landing-template.store');
        Route::get('/landing-templates/{template}/edit', [LandingTemplateController::class, 'edit'])->name('landing-template.edit');
        
        // Gestión de Tenants (Solo ADMIN) - Multi-Tenancy
        Route::middleware('role:ADMIN')->group(function () {
            Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
            Route::get('/tenants/{tenant}', [TenantController::class, 'show'])->name('tenants.show');
            Route::get('/tenants/{tenant}/edit', [TenantController::class, 'edit'])->name('tenants.edit');
            Route::patch('/tenants/{tenant}', [TenantController::class, 'update'])->name('tenants.update');
            Route::patch('/tenants/{tenant}/toggle-status', [TenantController::class, 'toggleStatus'])->name('tenants.toggle-status');
            Route::delete('/tenants/{tenant}', [TenantController::class, 'destroy'])->name('tenants.destroy');
        });
    });
});
