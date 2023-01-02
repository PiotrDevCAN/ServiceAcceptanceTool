<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Services\Contracts\BluePagesServiceInterface;
use App\Services\BluePagesService;

class BluePagesServiceProvider extends ServiceProvider // implements DeferrableProvider
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
        $this->app->singleton(BluePagesServiceInterface::class, function ($app) {
            return new BluePagesService($app->config['bluepages']);
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
        // return [BluePagesService::class];
        return array(BluePagesService::class);
    }

}
