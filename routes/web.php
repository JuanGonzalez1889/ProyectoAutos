
<?php
// Impersonate manual (solo para admin)
Route::middleware(['auth', 'role:ADMIN'])->group(function () {
    Route::get('/impersonate/{user}', function ($userId) {
        $user = \App\Models\User::findOrFail($userId);
        if (auth()->id() !== $user->id) {
            session(['impersonate_original_id' => auth()->id()]);
            auth()->login($user);
        }
        return redirect('/admin/users');
    })->name('impersonate.start');
});

// Salir de impersonate (visible para cualquier usuario logueado)
Route::middleware(['auth'])->get('/impersonate/leave', function () {
    if (session()->has('impersonate_original_id')) {
        $originalId = session('impersonate_original_id');
        $original = \App\Models\User::find($originalId);
        if ($original) {
            auth()->login($original);
        }
        session()->forget('impersonate_original_id');
    }
    return redirect('/');
})->name('impersonate.leave');

use App\Http\Controllers\Admin\AgenciaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserPermissionController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\LandingConfigController;
use App\Http\Controllers\Admin\LandingTemplateController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PublicLandingController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Ruta raíz - permite cualquier dominio en desarrollo
Route::get('/', function (Request $request) {
    if (app()->environment('production')) {
        $host = $request->getHost();
        $domain = str_replace('www.', '', $host);
        // Lógica original solo en producción
        if (!in_array($domain, ['localhost', '127.0.0.1', env('APP_DOMAIN', 'proyectoautos.local')])) {
            $domainRecord = \App\Models\Domain::where('domain', $domain)->first();
            if ($domainRecord && $domainRecord->tenant) {
                return (new PublicLandingController())->show($request);
            }
        }
    }
    // En desarrollo, siempre mostrar landing institucional
    return (new LandingController())->home();
})->name('landing.home');
Route::get('/nosotros', [LandingController::class, 'nosotros'])->name('landing.nosotros');
Route::get('/proximamente', [LandingController::class, 'proximamente'])->name('landing.proximamente');

// Páginas legales
Route::view('/legal/terminos', 'legal.terminos')->name('legal.terminos');
Route::view('/legal/privacidad', 'legal.privacidad')->name('legal.privacidad');
Route::view('/legal/cookies', 'legal.cookies')->name('legal.cookies');
Route::view('/legal/seguridad', 'legal.seguridad')->name('legal.seguridad');
Route::get('/precios', [LandingController::class, 'precios'])->name('landing.precios');
Route::post('/newsletter', [LandingController::class, 'submitNewsletter'])->name('landing.newsletter');

// Rutas públicas de agencias (tenants)
Route::get('/agencia/{domain}', [PublicLandingController::class, 'show'])->name('public.landing');
Route::get('/agencia-preview/{tenantId}', [PublicLandingController::class, 'showByTenantId'])->name('public.landing.preview');
Route::post('/agencia/{domain}/contacto', [PublicLandingController::class, 'submitContact'])->name('public.contact');
Route::post('/agencia-preview/{tenantId}/contacto', [PublicLandingController::class, 'submitContactByTenantId'])->name('public.contact.preview');
Route::get('/landing-preview/{template}', [LandingTemplateController::class, 'preview'])->middleware('auth')->name('landing.preview');

// Rutas públicas para dominio directo del tenant (sin parámetro domain porque está en el host)
// Las rutas de /vehiculos ya están en web-vehiculos.php con VehiculoController
Route::post('/contacto', [PublicLandingController::class, 'submitContactDirect'])->name('public.contacto');

// Rutas de invitaciones (públicas)
Route::get('/invitations/{token}/accept', [InvitationController::class, 'acceptForm'])->name('invitations.accept-form');
Route::post('/invitations/{token}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');

// Rutas de registro de nuevas agencias (públicas)
Route::get('/tenants/register', [TenantController::class, 'showRegisterForm'])->name('tenants.register');
Route::post('/tenants/register', [TenantController::class, 'register'])->middleware('throttle:register');

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
    
    // /register SOLO funciona con token de invitación válido
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:register');
    
    // Google OAuth redirect (only for guests)
    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
});

// Google OAuth callback (can be accessed by authenticated or guest users)
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// API pública para validación
Route::get('/api/validate-domain', [TenantController::class, 'validateDomain'])->name('api.validate-domain');

// Webhooks públicos (sin autenticación, validadas por signature)
Route::post('/webhooks/stripe', [WebhookController::class, 'stripe'])->name('webhooks.stripe');
Route::post('/webhooks/mercadopago', [WebhookController::class, 'mercadopago'])
    ->name('webhooks.mercadopago');

// Consolidación de Suscripciones y MercadoPago bajo auth
Route::middleware('auth')->group(function () {
    // Ruta para descargar PDF de factura
    Route::get('/invoices/{id}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    // Suscripciones
    Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
        Route::get('/', [SubscriptionController::class, 'index'])->name('index');
        Route::post('/checkout', [SubscriptionController::class, 'checkout'])->name('checkout');
        Route::get('/cancel', [SubscriptionController::class, 'cancel'])->name('cancel');
        Route::get('/pending', [SubscriptionController::class, 'pending'])->name('pending');
        Route::delete('/cancel-subscription', [SubscriptionController::class, 'destroy'])->name('destroy');
        Route::get('/billing', [SubscriptionController::class, 'billing'])->name('billing');
    });
// Ruta pública para éxito de compra
Route::get('/subscriptions/success', [SubscriptionController::class, 'success'])->name('subscriptions.success');
Route::get('/subscriptions/failure', [SubscriptionController::class, 'failure'])->name('subscriptions.failure');
    // MercadoPago
    Route::get('/mercadopago', [\App\Http\Controllers\MercadoPagoController::class, 'checkout'])->name('mercadopago');
    Route::post('/mercadopago/checkout', [\App\Http\Controllers\MercadoPagoController::class, 'checkout'])->name('mercadopago.checkout');
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');
    // Panel de administración y otras rutas protegidas...
    Route::prefix('admin')->name('admin.')->group(function () {
        // ...existing code...
    });
});
    
    // Rutas protegidas
    // Hacer pública la vista de pago MercadoPago
    Route::get('/mercadopago', [\App\Http\Controllers\MercadoPagoController::class, 'checkout'])->name('mercadopago');
    // Solo el POST requiere autenticación
    Route::middleware('auth')->group(function () {
        Route::post('/mercadopago/checkout', [\App\Http\Controllers\MercadoPagoController::class, 'checkout'])->name('mercadopago.checkout');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');
    
    // Panel de administración
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard - Accesible para todos los usuarios autenticados
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/onboarding', [AgenciaController::class, 'completeOnboarding'])->name('onboarding.complete');
        Route::get('/api/check-domain', [AgenciaController::class, 'checkDomainAvailability'])->name('check-domain');
        
        // Gestión de Agencia - Solo para AGENCIERO
        Route::get('/agencia', [AgenciaController::class, 'show'])->name('agencia.show');
        Route::put('/agencia', [AgenciaController::class, 'update'])->name('agencia.update');
        Route::get('/agencia/advanced-settings', [AgenciaController::class, 'advancedSettings'])
            ->name('agencia.advanced-settings.show');
        Route::patch('/agencia/advanced-settings', [AgenciaController::class, 'updateAdvancedSettings'])
            ->name('agencia.advanced-settings.update');
        
        // Gestión de usuarios - Solo para usuarios con permisos o admin impersonando
        Route::middleware('impersonate_admin:users.view')->group(function () {
            Route::resource('users', UserController::class);
            Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
                ->name('users.toggle-status')
                ->middleware('permission:users.edit');
            
            // User Permissions Management
            Route::get('users/{user}/permissions', [UserPermissionController::class, 'edit'])
                ->name('users.permissions.edit')
                ->middleware('permission:users.change_permissions');
            Route::patch('users/{user}/permissions', [UserPermissionController::class, 'update'])
                ->name('users.permissions.update')
                ->middleware('permission:users.change_permissions');
            Route::get('users/{user}/activity', [UserPermissionController::class, 'activityLog'])
                ->name('users.activity')
                ->middleware('permission:audit.view_logs');
        });

        // Gestión de Invitaciones - Solo para usuarios con permisos
        Route::middleware('permission:users.create')->prefix('invitations')->name('invitations.')->group(function () {
            Route::get('/create', [InvitationController::class, 'create'])->name('create');
            Route::post('/', [InvitationController::class, 'store'])->name('store');
            Route::get('/', [InvitationController::class, 'index'])->name('index');
            Route::delete('/{id}', [InvitationController::class, 'destroy'])->name('destroy');
        });
        
        // Auditoría y Logs de Actividad
        Route::middleware('permission:audit.view_logs')->prefix('audit')->name('audit.')->group(function () {
            Route::get('/activity-logs', [UserPermissionController::class, 'allActivityLogs'])
                ->name('activity-logs');
            Route::get('/activity-logs/export', [UserPermissionController::class, 'exportActivityLogs'])
                ->name('activity-logs.export');
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
        Route::get('/events/create', [\App\Http\Controllers\EventController::class, 'create'])->name('events.create');
        Route::get('/events/{event}/edit', [\App\Http\Controllers\EventController::class, 'edit'])->name('events.edit');
        Route::post('/events', [\App\Http\Controllers\EventController::class, 'store'])->name('events.store');
        Route::patch('/events/{event}', [\App\Http\Controllers\EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [\App\Http\Controllers\EventController::class, 'destroy'])->name('events.destroy');
        Route::get('/calendar', [\App\Http\Controllers\EventController::class, 'index'])->name('events.calendar');
        
        // Gestión de leads - Todos los usuarios autenticados
        Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
        Route::get('/leads/create', [LeadController::class, 'create'])->name('leads.create');
        Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
        Route::get('/leads/{lead}/edit', [LeadController::class, 'edit'])->name('leads.edit');
        Route::patch('/leads/{lead}', [LeadController::class, 'update'])->name('leads.update');
        Route::patch('/leads/{lead}/status', [LeadController::class, 'updateStatus'])->name('leads.updateStatus');
        Route::delete('/leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');

        // Analytics Dashboard
        Route::get('/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics.index');

        // Gestión de Dominios - Solo para AGENCIERO
        Route::resource('domains', DomainController::class);
        
        // Domain validation API endpoints
        Route::get('/domains/api/validate', [DomainController::class, 'validateDomain'])->name('domains.validate');
        Route::get('/domains/{domain}/dns-suggestions', [DomainController::class, 'dnsSuggestions'])->name('domains.dns-suggestions');

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

require __DIR__.'/web-vehiculos.php';
