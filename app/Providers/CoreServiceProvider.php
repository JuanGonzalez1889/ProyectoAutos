<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cookie\CookieJar;
use Illuminate\Session\SessionManager;
use Illuminate\View\ViewServiceProvider as BaseViewServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Config - cargar TODOS los archivos de configuración
        $this->app->singleton('config', function ($app) {
            $items = [];
            $configPath = $app->basePath('config');
            
            foreach (glob($configPath . '/*.php') as $file) {
                $key = basename($file, '.php');
                $items[$key] = require $file;
            }
            
            return new \Illuminate\Config\Repository($items);
        });
        
        // Database
        $this->app->singleton('db.factory', function ($app) {
            return new \Illuminate\Database\Connectors\ConnectionFactory($app);
        });
        
        $this->app->singleton('db', function ($app) {
            return new \Illuminate\Database\DatabaseManager($app, $app['db.factory']);
        });
        
        $this->app->singleton('db.connection', function ($app) {
            return $app['db']->connection();
        });
        
        // Validator con PresenceVerifier
        $this->app->singleton('validator', function ($app) {
            $validator = new \Illuminate\Validation\Factory($app['translator'], $app);
            
            if (isset($app['db'])) {
                $verifier = new \Illuminate\Validation\DatabasePresenceVerifier($app['db']);
                $validator->setPresenceVerifier($verifier);
            }
            
            return $validator;
        });
        
        // Cookie
        $this->app->singleton('cookie', function ($app) {
            $config = $app->make('config')->get('session');
            return (new CookieJar)->setDefaultPathAndDomain(
                $config['path'],
                $config['domain'],
                $config['secure'],
                $config['same_site'] ?? null
            );
        });
        
        // Session
        $this->app->singleton('session', function ($app) {
            return new SessionManager($app);
        });
        
        $this->app->singleton('session.store', function ($app) {
            return $app->make('session')->driver();
        });
        
        // Events
        $this->app->singleton('events', function ($app) {
            return new \Illuminate\Events\Dispatcher($app);
        });
        
        // URL Generator
        $this->app->singleton('url', function ($app) {
            $routes = $app['router']->getRoutes();
            $app->instance('routes', $routes);
            return new \Illuminate\Routing\UrlGenerator(
                $routes,
                $app->rebinding('request', function ($app, $request) {
                    $app['url']->setRequest($request);
                }),
                $app['config']['app.asset_url']
            );
        });
        
        // View
        $this->app->singleton('view.finder', function ($app) {
            $paths = $app['config']['view.paths'] ?? [resource_path('views')];
            return new \Illuminate\View\FileViewFinder($app['files'], $paths);
        });
        
        $this->app->singleton('view.engine.resolver', function ($app) {
            $resolver = new \Illuminate\View\Engines\EngineResolver;
            
            // Blade Engine
            $resolver->register('blade', function () use ($app) {
                $compiler = new \Illuminate\View\Compilers\BladeCompiler(
                    $app['files'],
                    $app['config']['view.compiled'] ?? storage_path('framework/views')
                );
                return new \Illuminate\View\Engines\CompilerEngine($compiler);
            });
            
            // PHP Engine
            $resolver->register('php', function () use ($app) {
                return new \Illuminate\View\Engines\PhpEngine($app['files']);
            });
            
            return $resolver;
        });
        
        $this->app->singleton('view', function ($app) {
            $resolver = $app['view.engine.resolver'];
            $finder = $app['view.finder'];
            $env = new \Illuminate\View\Factory($resolver, $finder, $app['events']);
            $env->setContainer($app);
            $env->share('app', $app);
            return $env;
        });
        
        $this->app->singleton('blade.compiler', function ($app) {
            return new \Illuminate\View\Compilers\BladeCompiler(
                $app['files'],
                $app['config']['view.compiled'] ?? storage_path('framework/views')
            );
        });
    }
}
