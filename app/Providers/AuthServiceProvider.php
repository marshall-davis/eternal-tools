<?php

namespace App\Providers;

use App\PasswordGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('password', function ($app, $name, array $config) {
            return new PasswordGuard(Auth::createUserProvider($config['provider']));
        });

        Auth::provider('password', function ($app, array $config) {
            return new PasswordUserProvider();
        });
    }
}
