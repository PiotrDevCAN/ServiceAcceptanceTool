<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\View\Components\IbmV18Form\Input;
use App\View\Components\IbmV18Form\Select;
use App\View\Components\IbmV18Form\Textarea;
use Illuminate\Support\Facades\Blade;
use App\View\Components\IbmV18Form\Button;

use App\Models\Account;
use App\Models\Checklist;
use App\Models\ChecklistCategory;
use App\Models\ChecklistService;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceSection;

use App\Observers\AccountObserver;
use App\Observers\ChecklistCategoryObserver;
use App\Observers\ChecklistObserver;
use App\Observers\ChecklistServiceObserver;
use App\Observers\ServiceCategoryObserver;
use App\Observers\ServiceObserver;
use App\Observers\ServiceSectionObserver;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Account::observe(AccountObserver::class);
        Checklist::observe(ChecklistObserver::class);
        ChecklistCategory::observe(ChecklistCategoryObserver::class);
        ChecklistService::observe(ChecklistServiceObserver::class);
        Service::observe(ServiceObserver::class);
        ServiceCategory::observe(ServiceCategoryObserver::class);
        ServiceSection::observe(ServiceSectionObserver::class);

        Blade::component('ibmv18form-input', Input::class);
        Blade::component('ibmv18form-select', Select::class);
        Blade::component('ibmv18form-textarea', Textarea::class);
        Blade::component('ibmv18form-button', Button::class);
    }
}
