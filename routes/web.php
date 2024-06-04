<?php

use Illuminate\Support\Facades\Route;
//use App\Models\OvertimeRequest;
use App\Http\Controllers\Login;
use App\Http\Controllers\Index;
use App\Http\Controllers\Accounts;
use App\Http\Controllers\Checklists;
use App\Http\Controllers\Categories;
use App\Http\Controllers\Sections;
use App\Http\Controllers\Services;
use App\Http\Controllers\AccessRequests;

use App\Http\Controllers\API\Accounts as AccountsAPI;
use App\Http\Controllers\API\Checklists as ChecklistsAPI;
use App\Http\Controllers\API\Categories as CategoriesAPI;
use App\Http\Controllers\API\Sections as SectionsAPI;
use App\Http\Controllers\API\Services as ServicesAPI;
use App\Http\Controllers\API\ChecklistCategories as ChecklistCategoriesAPI;
use App\Http\Controllers\API\ChecklistServices as ChecklistServicesAPI;
use App\Http\Controllers\API\AccessRequests as AccessRequestsAPI;

use App\Models\Account;
use App\Models\Checklist;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceSection;
use App\Models\ChecklistCategory;
use App\Models\ChecklistService;

use App\Mail\Account\Saved as AccountSavedMail;
use App\Mail\Account\Updated as AccountUpdatedMail;
use App\Mail\Account\Created as AccountCreatedMail;
use App\Mail\Account\Deleted as AccountDeletedMail;

use App\Mail\Checklist\Saved as ChecklistSavedMail;
use App\Mail\Checklist\Updated as ChecklistUpdatedMail;
use App\Mail\Checklist\Created as ChecklistCreatedMail;
use App\Mail\Checklist\Deleted as ChecklistDeletedMail;

use App\Mail\Service\Saved as ServiceSavedMail;
use App\Mail\Service\Updated as ServiceUpdatedMail;
use App\Mail\Service\Created as ServiceCreatedMail;
use App\Mail\Service\Deleted as ServiceDeletedMail;

use App\Mail\ServiceCategory\Saved as ServiceCategorySavedMail;
use App\Mail\ServiceCategory\Updated as ServiceCategoryUpdatedMail;
use App\Mail\ServiceCategory\Created as ServiceCategoryCreatedMail;
use App\Mail\ServiceCategory\Deleted as ServiceCategoryDeletedMail;

use App\Mail\ServiceSection\Saved as ServiceSectionSavedMail;
use App\Mail\ServiceSection\Updated as ServiceSectionUpdatedMail;
use App\Mail\ServiceSection\Created as ServiceSectionCreatedMail;
use App\Mail\ServiceSection\Deleted as ServiceSectionDeletedMail;

use App\Mail\ChecklistCategory\Saved as ChecklistCategorySavedMail;
use App\Mail\ChecklistCategory\Updated as ChecklistCategoryUpdatedMail;
use App\Mail\ChecklistCategory\Created as ChecklistCategoryCreatedMail;
use App\Mail\ChecklistCategory\Deleted as ChecklistCategoryDeletedMail;

use App\Mail\ChecklistService\Saved as ChecklistServiceSavedMail;
use App\Mail\ChecklistService\Updated as ChecklistServiceUpdatedMail;
use App\Mail\ChecklistService\Created as ChecklistServiceCreatedMail;
use App\Mail\ChecklistService\Deleted as ChecklistServiceDeletedMail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home
Route::get('/', [Index::class, 'index'])
    // ->middleware('auth:web,guest,admin')
    // ->middleware('auth:bluepages,auth:guest,auth:admin')
    // ->middleware('auth:bluepages')
    // ->middleware('auth:guest')
    // ->middleware('auth:admin')
    // ->middleware('auth:guest,auth:admin')
    ->middleware('auth')
    ->name('home');

Route::get('/login', [Login::class, 'showLoginForm'])
    ->middleware('guest')
    ->name('login');

Route::get('/loginCancel', [Login::class, 'cancel'])
    ->middleware('guest')
    ->name('loginCancel');

Route::get('/logout', [Login::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::name('auth.')
    ->middleware('guest')
    ->group(function () {

        // Route::post('/authenticate', [Login::class, 'authenticate'])
        Route::post('/authenticate', [Login::class, 'authenticateWithValidation'])
            ->name('post.authenticate');

        Route::get('/authenticate', function () {
            return redirect()->route('login');
        })
            ->name('get.authenticate');
    });


// Checklist
Route::prefix('checklist')
    ->middleware('auth')
    ->name('checklist.')
    ->group(function () {
        Route::match(['get', 'post'], 'list', [Checklists::class, 'index'])
            ->name('list');

        // Show the form for creating a new resource.
        Route::get('create', [Checklists::class, 'create'])
            ->name('create');

        // Show the form for editing the specified resource.
        Route::get('edit/{checklist}', [Checklists::class, 'edit'])
            ->name('edit');

        Route::get('edit/{checklist}/overview/export', [Checklists::class, 'serviceOverviewExport'])
            ->name('overviewExport');

        Route::get('edit/{checklist}/pending/export', [Checklists::class, 'pendingExport'])
            ->name('pendingExport');

        Route::get('overview', [Checklists::class, 'serviceOverview'])
            ->name('overview');

        Route::get('account/{account}', [Checklists::class, 'checklistForAccount'])
            ->name('checklistForAccount');

        Route::get('overview/{checklist}', [Checklists::class, 'serviceOverviewForChecklist'])
            ->name('overviewForChecklist');

        Route::get('overview/{checklist}/export', [Checklists::class, 'serviceOverviewForChecklistExport'])
            ->name('overviewForChecklistExport');

        Route::get('export', [Checklists::class, 'exportList'])
            ->name('export');
    });

// Access Control for Users
Route::prefix('access')
    ->middleware('auth')
    ->name('access.')
    ->group(function () {

        Route::get('request', [AccessRequests::class, 'requestForAccess'])
            ->name('request');
    });

// Admin
Route::prefix('admin')
    ->middleware(['auth', 'isAdmin'])
    // ->middleware('isAdmin')
    ->name('admin.')
    ->group(function () {

        // Accounts
        Route::prefix('account')->name('account.')->group(function () {
            Route::match(['get', 'post'], 'list', [Accounts::class, 'index'])
                ->name('list');

            // Show the form for creating a new resource.
            Route::get('create', [Accounts::class, 'create'])
                ->name('create');

            // Show the form for editing the specified resource.
            Route::get('edit/{account}', [Accounts::class, 'edit'])
                ->name('edit');

            Route::get('export', [Accounts::class, 'exportList'])
                ->name('export');
        });

        // Checklists
        Route::prefix('checklist')->name('checklist.')->group(function () {
            Route::match(['get', 'post'], 'list', [Checklists::class, 'indexAdmin'])
                ->name('list');

            // Show the form for creating a new resource.
            Route::get('create', [Checklists::class, 'create'])
                ->name('create');

            // Show the form for editing the specified resource.
            Route::get('edit/{checklist}', [Checklists::class, 'edit'])
                ->name('edit');

            Route::get('overview', [Checklists::class, 'serviceOverviewAdmin'])
                ->name('overview');

            Route::get('account/{account}', [Checklists::class, 'checklistForAccount'])
                ->name('checklistForAccount');

            Route::get('overview/{checklist}', [Checklists::class, 'serviceOverviewForChecklistAdmin'])
                ->name('overviewForChecklist');

            Route::get('overview/{checklist}/export', [Checklists::class, 'serviceOverviewForChecklistExportAdmin'])
                ->name('overviewForChecklistExport');

            Route::get('export', [Checklists::class, 'exportList'])
                ->name('export');
        });

        // Checklists Categories
        Route::prefix('checklistCategory')->name('checklistCategory.')->group(function () {
            Route::match(['get', 'post'], 'list', [ChecklistCategory::class, 'index'])
                ->name('list');

            // Show the form for creating a new resource.
            Route::get('create', [ChecklistCategory::class, 'create'])
                ->name('create');

            // Show the form for editing the specified resource.
            // Route::get('edit/{checklistCategory}', [ChecklistCategory::class, 'edit'])
            //     ->name('edit');
        });

        // Checklists Services
        Route::prefix('checklistService')->name('checklistService.')->group(function () {
            Route::match(['get', 'post'], 'list', [ChecklistService::class, 'index'])
                ->name('list');

            // Show the form for creating a new resource.
            Route::get('create', [ChecklistService::class, 'create'])
                ->name('create');

            // Show the form for editing the specified resource.
            // Route::get('edit/{checklistService}', [ChecklistService::class, 'edit'])
            //     ->name('edit');
        });

        // Categories
        Route::prefix('category')->name('category.')->group(function () {
            Route::match(['get', 'post'], 'list', [Categories::class, 'index'])
                ->name('list');

            // Show the form for creating a new resource.
            Route::get('create', [Categories::class, 'create'])
                ->name('create');

            // Show the form for editing the specified resource.
            Route::get('edit/{category}', [Categories::class, 'edit'])
                ->name('edit');

            Route::get('export', [Categories::class, 'exportList'])
                ->name('export');
        });

        // Section
        Route::prefix('section')->name('section.')->group(function () {
            Route::match(['get', 'post'], 'list', [Sections::class, 'index'])
                ->name('list');

            // Show the form for creating a new resource.
            Route::get('create', [Sections::class, 'create'])
                ->name('create');

            // Show the form for editing the specified resource.
            Route::get('edit/{section}', [Sections::class, 'edit'])
                ->name('edit');

            Route::get('export', [Sections::class, 'exportList'])
                ->name('export');
        });

        // Service
        Route::prefix('service')->name('service.')->group(function () {
            Route::match(['get', 'post'], 'list', [Services::class, 'index'])
                ->name('list');

            // Show the form for creating a new resource.
            Route::get('create', [Services::class, 'create'])
                ->name('create');

            // Show the form for editing the specified resource.
            Route::get('edit/{service}', [Services::class, 'edit'])
                ->name('edit');

            Route::get('export', [Services::class, 'exportList'])
                ->name('export');
        });

        // Access Control
        Route::prefix('access')->name('access.')->group(function () {
            Route::get('users', [AccessRequests::class, 'users'])
                ->name('users');

            Route::get('administrators', [AccessRequests::class, 'admins'])
                ->name('admins');

            Route::get('request', [AccessRequests::class, 'requestForAccess'])
                ->name('request');

            Route::get('pending', [AccessRequests::class, 'pendingRequests'])
                ->name('pending');

            // Show the form for creating a new resource.
            Route::get('create', [AccessRequests::class, 'create'])
                ->name('create');

            // Show the form for editing the specified resource.
            Route::get('edit/{access}', [AccessRequests::class, 'edit'])
                ->name('edit');

            Route::get('export', [AccessRequests::class, 'pendingRequests'])
                ->name('export');
        });
    });

// Access
Route::prefix('access')
    ->middleware('auth')
    ->name('access.')
    ->group(function () {
        Route::get('my', [Index::class, 'access'])
            ->name('my');
    });


// Mailable
Route::prefix('mailable')
    ->middleware('guest')
    ->name('mailable.')
    ->group(function () {

        // Accounts
        Route::prefix('account')
            ->name('account.')
            ->group(function () {

                Route::get('saved/{account}', function (Account $account) {
                    return new AccountSavedMail($account);
                })
                    ->name('saved');

                Route::get('created/{account}', function (Account $account) {
                    return new AccountCreatedMail($account);
                })
                    ->name('created');

                Route::get('updated/{account}', function (Account $account) {
                    return new AccountUpdatedMail($account);
                })
                    ->name('updated');

                Route::get('deleted/{account}', function (Account $account) {
                    return new AccountDeletedMail($account);
                })
                    ->name('deleted');

            });

        // Checklists
        Route::prefix('checklist')
            ->name('checklist.')
            ->group(function () {

                Route::get('saved/{checklist}', function (Checklist $checklist) {
                    return new ChecklistSavedMail($checklist);
                })
                    ->name('saved');

                Route::get('created/{checklist}', function (Checklist $checklist) {
                    return new ChecklistCreatedMail($checklist);
                })
                    ->name('created');

                Route::get('updated/{checklist}', function (Checklist $checklist) {
                    return new ChecklistUpdatedMail($checklist);
                })
                    ->name('updated');

                Route::get('deleted/{checklist}', function (Checklist $checklist) {
                    return new ChecklistDeletedMail($checklist);
                })
                    ->name('deleted');

            });

        // Services
        Route::prefix('service')
            ->name('service.')
            ->group(function () {

                Route::get('saved/{service}', function (Service $service) {
                    return new ServiceSavedMail($service);
                })
                    ->name('saved');

                Route::get('created/{service}', function (Service $service) {
                    return new ServiceCreatedMail($service);
                })
                    ->name('created');

                Route::get('updated/{service}', function (Service $service) {
                    return new ServiceUpdatedMail($service);
                })
                    ->name('updated');

                Route::get('deleted/{service}', function (Service $service) {
                    return new ServiceDeletedMail($service);
                })
                    ->name('deleted');

            });

        // Service Categories
        Route::prefix('serviceCategory')
            ->name('serviceCategory.')
            ->group(function () {

                Route::get('saved/{serviceCategory}', function (ServiceCategory $serviceCategory) {
                    return new ServiceCategorySavedMail($serviceCategory);
                })
                    ->name('saved');

                Route::get('created/{serviceCategory}', function (ServiceCategory $serviceCategory) {
                    return new ServiceCategoryCreatedMail($serviceCategory);
                })
                    ->name('created');

                Route::get('updated/{serviceCategory}', function (ServiceCategory $serviceCategory) {
                    return new ServiceCategoryUpdatedMail($serviceCategory);
                })
                    ->name('updated');

                Route::get('deleted/{serviceCategory}', function (ServiceCategory $serviceCategory) {
                    return new ServiceCategoryDeletedMail($serviceCategory);
                })
                    ->name('deleted');

            });

        // Service Sections
        Route::prefix('serviceSection')
            ->name('serviceSection.')
            ->group(function () {

                Route::get('saved/{serviceSection}', function (ServiceSection $serviceSection) {
                    return new ServiceSectionSavedMail($serviceSection);
                })
                    ->name('saved');

                Route::get('created/{serviceSection}', function (ServiceSection $serviceSection) {
                    return new ServiceSectionCreatedMail($serviceSection);
                })
                    ->name('created');

                Route::get('updated/{serviceSection}', function (ServiceSection $serviceSection) {
                    return new ServiceSectionUpdatedMail($serviceSection);
                })
                    ->name('updated');

                Route::get('deleted/{serviceSection}', function (ServiceSection $serviceSection) {
                    return new ServiceSectionDeletedMail($serviceSection);
                })
                    ->name('deleted');

            });

        // Checklist Categories
        Route::prefix('checklistCategory')
            ->name('checklistCategory.')
            ->group(function () {

                Route::get('saved/{checklistCategory}', function (ChecklistCategory $checklistCategory) {
                    return new ChecklistCategorySavedMail($checklistCategory);
                })
                    ->name('saved');

                Route::get('created/{checklistCategory}', function (ChecklistCategory $checklistCategory) {
                    return new ChecklistCategoryCreatedMail($checklistCategory);
                })
                    ->name('created');

                Route::get('updated/{checklistCategory}', function (ChecklistCategory $checklistCategory) {
                    return new ChecklistCategoryUpdatedMail($checklistCategory);
                })
                    ->name('updated');

                Route::get('deleted/{checklistCategory}', function (ChecklistCategory $checklistCategory) {
                    return new ChecklistCategoryDeletedMail($checklistCategory);
                })
                    ->name('deleted');

            });

        // Checklist Services
        Route::prefix('checklistService')
            ->name('checklistService.')
            ->group(function () {

                Route::get('saved/{checklistService}', function (ChecklistService $checklistService) {
                    return new ChecklistServiceSavedMail($checklistService);
                })
                    ->name('saved');

                Route::get('created/{checklistService}', function (ChecklistService $checklistService) {
                    return new ChecklistServiceCreatedMail($checklistService);
                })
                    ->name('created');

                Route::get('updated/{checklistService}', function (ChecklistService $checklistService) {
                    return new ChecklistServiceUpdatedMail($checklistService);
                })
                    ->name('updated');

                Route::get('deleted/{checklistService}', function (ChecklistService $checklistService) {
                    return new ChecklistServiceDeletedMail($checklistService);
                })
                    ->name('deleted');

            });
    });

/*
|--------------------------------------------------------------------------
| Fake API routes
|--------------------------------------------------------------------------
*/

// Accounts
Route::prefix('api/account')
    ->name('api.account.')
    ->group(function () {

        Route::post('store', [AccountsAPI::class, 'store'])
            ->name('store');

        Route::post('show/{account}', [AccountsAPI::class, 'show'])
            ->name('show');

        Route::post('update/{account}', [AccountsAPI::class, 'update'])
            ->name('update');

        Route::post('destroy/{account}', [AccountsAPI::class, 'destroy'])
            ->name('destroy');

        Route::post('duplicate/{account}', [AccountsAPI::class, 'duplicate'])
            ->name('duplicate');

        Route::get('list', [AccountsAPI::class, 'list'])
            ->name('list');
    });

// Section
Route::prefix('api/section')
    ->name('api.section.')
    ->group(function () {

        Route::post('store', [SectionsAPI::class, 'store'])
            ->name('store');

        Route::post('show/{section}', [SectionsAPI::class, 'show'])
            ->name('show');

        Route::post('update/{section}', [SectionsAPI::class, 'update'])
            ->name('update');

        Route::post('destroy/{section}', [SectionsAPI::class, 'destroy'])
            ->name('destroy');

        Route::post('duplicate/{section}', [SectionsAPI::class, 'duplicate'])
            ->name('duplicate');

        Route::get('list', [SectionsAPI::class, 'list'])
            ->name('list');

        Route::post('mass-update', [SectionsAPI::class, 'massUpdate'])
            ->name('mass-update');
});

// Categories
Route::prefix('api/category')
    ->name('api.category.')
    ->group(function () {

        Route::post('store', [CategoriesAPI::class, 'store'])
            ->name('store');

        Route::post('show/{category}', [CategoriesAPI::class, 'show'])
            ->name('show');

        Route::post('update/{category}', [CategoriesAPI::class, 'update'])
            ->name('update');

        Route::post('destroy/{category}', [CategoriesAPI::class, 'destroy'])
            ->name('destroy');

        Route::post('duplicate/{category}', [CategoriesAPI::class, 'duplicate'])
            ->name('duplicate');

        Route::get('list', [CategoriesAPI::class, 'list'])
            ->name('list');

        Route::get('show/{category}/services', [CategoriesAPI::class, 'servicesList'])
            ->name('servicesList');

        Route::post('mass-update', [CategoriesAPI::class, 'massUpdate'])
            ->name('mass-update');
});

// Services
Route::prefix('api/service')
    ->name('api.service.')
    ->group(function () {

        Route::post('store', [ServicesAPI::class, 'store'])
            ->name('store');

        Route::post('show/{service}', [ServicesAPI::class, 'show'])
            ->name('show');

        Route::post('update/{service}', [ServicesAPI::class, 'update'])
            ->name('update');

        Route::post('destroy/{service}', [ServicesAPI::class, 'destroy'])
            ->name('destroy');

        Route::post('duplicate/{service}', [ServicesAPI::class, 'duplicate'])
            ->name('duplicate');

        Route::get('list', [ServicesAPI::class, 'list'])
            ->name('list');

        Route::post('mass-update', [ServicesAPI::class, 'massUpdate'])
            ->name('mass-update');
});

// Checklists
Route::prefix('api/checklist')
    ->name('api.checklist.')
    ->group(function () {

        Route::post('store', [ChecklistsAPI::class, 'store'])
            ->name('store');

        Route::post('show/{checklist}', [ChecklistsAPI::class, 'show'])
            ->name('show');

        Route::post('update/{checklist}', [ChecklistsAPI::class, 'update'])
            ->name('update');

        Route::post('destroy/{checklist}', [ChecklistsAPI::class, 'destroy'])
            ->name('destroy');

        Route::match(['get', 'post'], 'calculation/{checklist}', [ChecklistsAPI::class, 'calculation'])
            ->name('calculation');

        // Route::get('calculation/{checklist}', [ChecklistsAPI::class, 'calculation'])
            // ->name('calculation');

        Route::post('duplicate/{checklist}', [ChecklistsAPI::class, 'duplicate'])
            ->name('duplicate');

        Route::get('list', [ChecklistsAPI::class, 'list'])
            ->name('list');

        Route::get('{checklist}/categories', [ChecklistsAPI::class, 'categoriesList'])
            ->name('categoriesList');

        Route::get('{checklist}/services', [ChecklistsAPI::class, 'servicesList'])
            ->name('servicesList');

        Route::get('{checklist}/category/{category}/services', [ChecklistsAPI::class, 'servicesByCategoryList'])
            ->name('servicesByCategoryList');

        Route::get('{checklist}/category/{category}/summary', [ChecklistsAPI::class, 'servicesSummary'])
            ->name('servicesSummary');
});

// Checklists Categories
Route::prefix('api/checklist-category')
    ->name('api.checklist-category.')
    ->group(function () {

        Route::post('store', [ChecklistCategoriesAPI::class, 'store'])
            ->name('store');

        Route::post('show/{category}', [ChecklistCategoriesAPI::class, 'show'])
            ->name('show');

        Route::post('update/{category}', [ChecklistCategoriesAPI::class, 'update'])
            ->name('update');

        Route::post('destroy/{category}', [ChecklistCategoriesAPI::class, 'destroy'])
            ->name('destroy');

        Route::post('mass-update', [ChecklistCategoriesAPI::class, 'massUpdate'])
            ->name('mass-update');
});

// Checklists Services
Route::prefix('api/checklist-service')
    ->name('api.checklist-service.')
    ->group(function () {

        Route::post('store', [ChecklistServicesAPI::class, 'store'])
            ->name('store');

        Route::post('show/{service}', [ChecklistServicesAPI::class, 'show'])
            ->name('show');

        Route::post('update/{service}', [ChecklistServicesAPI::class, 'update'])
            ->name('update');

        Route::post('destroy/{service}', [ChecklistServicesAPI::class, 'destroy'])
            ->name('destroy');

        Route::post('mass-update', [ChecklistServicesAPI::class, 'massUpdate'])
            ->name('mass-update');
});

// Access Requests
Route::prefix('api/access')
    ->name('api.access')
    ->group(function () {

        Route::post('store', [AccessRequestsAPI::class, 'store'])
            ->name('store');

        Route::post('show/{access}', [AccessRequestsAPI::class, 'show'])
            ->name('show');

        Route::post('update/{access}', [AccessRequestsAPI::class, 'update'])
            ->name('update');

        Route::post('destroy/{access}', [AccessRequestsAPI::class, 'destroy'])
            ->name('destroy');

        Route::post('approve/{access}', [AccessRequestsAPI::class, 'approve'])
            ->name('approve');

        Route::post('reject/{access}', [AccessRequestsAPI::class, 'reject'])
            ->name('reject');

        Route::get('list', [AccessRequestsAPI::class, 'list'])
            ->name('list');
});
