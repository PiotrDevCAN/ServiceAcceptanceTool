<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Services\Contracts\BlueGroupsServiceInterface;
use App\Services\BlueGroupsService;
use LdapRecord\Container;

class BlueGroupsServiceProvider extends ServiceProvider // implements DeferrableProvider
{
    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BlueGroupsServiceInterface::class, function ($app) {
            $connection = Container::getConnection('bluepages');
            return new BlueGroupsService($connection);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        // return [BlueGroupsService::class];
        return array(BlueGroupsService::class);
    }

}
