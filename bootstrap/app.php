<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


$app = Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        \App\Providers\RouteServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Trust proxies (CloudFlare, AWS ELB, Nginx)
        $middleware->trustProxies(at: '*');

        // Middleware global para identificar tenant
        $middleware->append(\App\Http\Middleware\IdentifyTenant::class);
        $middleware->append(\App\Http\Middleware\ResolveTenantFromDomain::class);
        $middleware->append(\App\Http\Middleware\InitializeTenancyByUser::class);

        // Validar suscripción en rutas autenticadas
        $middleware->append(\App\Http\Middleware\ValidateSubscription::class);

        // Security headers en todas las respuestas
        $middleware->append(\App\Http\Middleware\SecurityHeadersMiddleware::class);

        // Force HTTPS en producción
        $middleware->append(\App\Http\Middleware\ForceHttps::class);

        // Restaurar el grupo 'web' con todos los middleware estándar y el CSRF personalizado
        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'check_permission' => \App\Http\Middleware\CheckPermission::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'impersonate_admin' => \App\Http\Middleware\ImpersonateBypassPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->reportable(function (Throwable $e) {
            //
        });
    })
    ->create();

return $app;
