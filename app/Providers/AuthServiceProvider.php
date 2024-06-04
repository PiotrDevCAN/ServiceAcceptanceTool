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
use App\Ldap\User;
use App\Models\AccessRequest;
use App\Models\Account;
use App\Models\Checklist;
use App\Models\ServiceCategory;
use App\Models\ServiceSection;
use App\Models\Service;
use App\Policies\AccessRequestPolicy;
use App\Policies\AccountPolicy;
use App\Policies\ChecklistPolicy;
use App\Policies\ServiceCategoryPolicy;
use App\Policies\ServicePolicy;
use App\Policies\ServiceSectionPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        // AccessRequest::class => AccessRequestPolicy::class,
        // Account::class => AccountPolicy::class,
        // Checklist::class => ChecklistPolicy::class,
        // ServiceCategory::class => ServiceCategoryPolicy::class,
        // ServiceSection::class => ServiceSectionPolicy::class,
        // Service::class => ServicePolicy::class,
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

        // Gate::define('update-account', function (User $user, Account $account) {
        //     return $user->mail === $account->user_id;
        // });

        // Gate::define('update-account', [PostPolicy::class, 'update']);

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
