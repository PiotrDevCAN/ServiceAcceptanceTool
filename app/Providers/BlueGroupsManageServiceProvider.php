<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Services\Contracts\BlueGroupsManageServiceInterface;
use App\Services\BlueGroupsManageExtService;

class BlueGroupsManageServiceProvider extends ServiceProvider // implements DeferrableProvider
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
        $this->app->singleton(BlueGroupsManageServiceInterface::class, function ($app) {
            return new BlueGroupsManageExtService($app->config['bluegroups']);
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
        // return [BlueGroupsManageExtService::class];
        return array(BlueGroupsManageExtService::class);
    }

}

