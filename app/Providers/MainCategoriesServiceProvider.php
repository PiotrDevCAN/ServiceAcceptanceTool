<?php

namespace App\Providers;

use App\Services\Contracts\MainCategoriesServiceInterface;
use App\Services\MainCategoriesService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

// https://farhan.dev/tutorial/laravel-service-container-and-service-providers-explained/#dependency-injection-and-ioc
// dd(app()->make(BluePagesServiceInterface::class));

class MainCategoriesServiceProvider extends ServiceProvider // implements DeferrableProvider
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
    /*
        This is where we will tell Laravel how to instantiate our Service,
        and the place where we will bind the Service into the Service Container.
    */
    /*
        The register() method is used for registering new services to the application.
        This is where you put your bind() and singleton() method calls.
    */
    /*
        Inside providers, you get access to the container by simply writing
        $this->app instead of calling the app() helper function. But you can do that as well.
    */
    public function register()
    {
        $this->app->singleton(MainCategoriesServiceInterface::class, function() {
            return new MainCategoriesService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    /*
       Laravel will call the boot() method after every single Service Provider is registered.
       That means we have access to all of the Services in our app inside the boot() method.
       There are no hard rules on what to put inside the boot() method, but generally,
       we will put things like Event Listener or code that requires other Services.
    */
    /*
        The boot() method is used for the logic necessary to bootstrap the registered service.
        A good example is the BroadcastingServiceProvider class.
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
        // return [MainCategoriesService::class];
        return array(MainCategoriesService::class);
    }

}
