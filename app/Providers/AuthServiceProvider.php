<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('users.view_all', function ($user) {
            return $user->isAdmin();
        });
        Gate::define('users.view_agency', function ($user) {
            return $user->isAgenciero() && $user->can('users.view.agencia');
        });
        Gate::define('users.edit_all', function ($user) {
            return $user->isAdmin();
        });
        Gate::define('users.edit_agency', function ($user) {
            return $user->isAgenciero();
        });
    }
}
