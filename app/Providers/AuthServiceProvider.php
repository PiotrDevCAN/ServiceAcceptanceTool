<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Auth\Providers\BluepagesUserProvider;
use App\Auth\Providers\BluegroupsGuestUserProvider;
use App\Auth\Providers\BluegroupsAdminUserProvider;
use App\Auth\Guards\BluepagesUserGuard;
use App\Auth\Guards\BluegroupsGuestUserGuard;
use App\Auth\Guards\BluegroupsAdminUserGuard;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // add custom guard provider
        /*
        Auth::provider('custom', function ($app, array $config) {
            return new CustomerAuthProvider($app->make('App\User'));
        });

        // add custom guard
        Auth::extend('custom', function ($app, $name, array $config) {
            return new CustomAuthGuard(Auth::createUserProvider($config['provider']), $app->make('request'));
        });
        */

        /*
        'guards' => [
            'api' => [
                'driver' => 'jwt',      // CUSTOM GUARD
                'provider' => 'users',  // CUSTOM USER PROVIDER
            ],
        ],
        */

        /*
         * Adding Custom Guards instead of Session
        */
        Auth::extend('bluepages', function ($app, $name, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\Guard...

            // return new JWTGuard(Auth::createUserProvider($config['provider']));
            return new BluepagesUserGuard(Auth::createUserProvider($config['provider']));
        });

        Auth::extend('bluegroups-guest', function ($app, $name, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\Guard...

            // return new JwtGuard(Auth::createUserProvider($config['provider']));
            return new BluegroupsGuestUserGuard(Auth::createUserProvider($config['provider']));
        });

        Auth::extend('bluegroups-admin', function ($app, $name, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\Guard...

            // return new JwtGuard(Auth::createUserProvider($config['provider']));
            return new BluegroupsAdminUserGuard(Auth::createUserProvider($config['provider']));
        });

        /*
         * Adding Custom User Providers
        */
        Auth::provider('bluepages', function ($app, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...

            return $app->make(BluepagesUserProvider::class, [
                'hasher' => $app['hash'],
            ]);
        });

        Auth::provider('bluegroups-guest', function ($app, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...

            return $app->make(BluegroupsGuestUserProvider::class, [
                'hasher' => $app['hash'],
            ]);
        });

        Auth::provider('bluegroups-admin', function ($app, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...

            return $app->make(BluegroupsAdminUserProvider::class, [
                'hasher' => $app['hash'],
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Since the Auth Manager doesn't have to be called in every Request, we will just
        // set a callback before the application resolves it and passes it where it was
        // called.

        // Auth::extend('bluepages-user', function ($app, $name, array $config) {
        //     return $app->make(BluepagesUserGuard::class, [
        //         'name' => $name,
        //         'provider' => $app['auth']->createUserProvider(
        //             $config['provider'] ?? null
        //             ),
        //         'session' => $app['session.store']
        //     ]);
        // });

        // Auth::provider('bluepages-provider', function ($app, array $config) {
        //     // Return an instance of Illuminate\Contracts\Auth\UserProvider...

        //     return $app->make(BluepagesUserProvider::class, [
        //         'hasher' => $app['hash'],
        //     ]);
        // });

        // Auth::extend('bluegroups-guest', function ($app, $name, array $config) {
        //     return $app->make(BluegroupsGuestUserGuard::class);
        // });

        // Auth::provider('bluegroups-guest-provider', function ($app, array $config) {
        //     // Return an instance of Illuminate\Contracts\Auth\UserProvider...

        //     return $app->make(BluegroupsGuestUserProvider::class, [
        //         'hasher' => $app['hash'],
        //     ]);
        // });

        // Auth::extend('bluegroups-admin', function ($app, $name, array $config) {
        //     return $app->make(BluegroupsAdminUserGuard::class);
        // });

        // Auth::provider('bluegroups-admin-provider', function ($app, array $config) {
        //     // Return an instance of Illuminate\Contracts\Auth\UserProvider...

        //     return $app->make(BluegroupsAdminUserProvider::class, [
        //         'hasher' => $app['hash'],
        //     ]);
        // });
    }
}
