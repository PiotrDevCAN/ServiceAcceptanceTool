<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Accounts;
use App\Http\Controllers\API\Checklists;
use App\Http\Controllers\API\Categories;
use App\Http\Controllers\API\Sections;
use App\Http\Controllers\API\Services;
use App\Http\Controllers\API\ChecklistCategories;
use App\Http\Controllers\API\ChecklistServices;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// // Accounts
// Route::prefix('account')
//     ->name('api.account.')
//     ->group(function () {

//         Route::post('store', [Accounts::class, 'store'])
//             ->name('store');

//         Route::post('show/{account}', [Accounts::class, 'show'])
//             ->name('show');

//         Route::post('update/{account}', [Accounts::class, 'update'])
//             ->name('update');

//         Route::post('destroy/{account}', [Accounts::class, 'destroy'])
//             ->name('destroy');
//     });

// // Section
// Route::prefix('section')
//     ->name('api.section.')
//     ->group(function () {

//         Route::post('store', [Sections::class, 'store'])
//             ->name('store');

//         Route::post('show/{section}', [Sections::class, 'show'])
//             ->name('show');

//         Route::post('update/{section}', [Sections::class, 'update'])
//             ->name('update');

//         Route::post('destroy/{section}', [Sections::class, 'destroy'])
//             ->name('destroy');
// });

// // Categories
// Route::prefix('category')
//     ->name('api.category.')
//     ->group(function () {

//         Route::post('store', [Categories::class, 'store'])
//             ->name('store');

//         Route::post('show/{category}', [Categories::class, 'show'])
//             ->name('show');

//         Route::post('update/{category}', [Categories::class, 'update'])
//             ->name('update');

//         Route::post('destroy/{category}', [Categories::class, 'destroy'])
//             ->name('destroy');
// });

// // Services
// Route::prefix('service')
//     ->name('api.service.')
//     ->group(function () {

//         Route::post('store', [Services::class, 'store'])
//             ->name('store');

//         Route::post('show/{service}', [Services::class, 'show'])
//             ->name('show');

//         Route::post('update/{service}', [Services::class, 'update'])
//             ->name('update');

//         Route::post('destroy/{service}', [Services::class, 'destroy'])
//             ->name('destroy');
// });

// // Checklists
// Route::prefix('checklist')
//     ->name('api.checklist.')
//     ->group(function () {

//         Route::post('store', [Checklists::class, 'store'])
//             ->name('store');

//         Route::post('show/{checklist}', [Checklists::class, 'show'])
//             ->name('show');

//         Route::post('update/{checklist}', [Checklists::class, 'update'])
//             ->name('update');

//         Route::post('destroy/{checklist}', [Checklists::class, 'destroy'])
//             ->name('destroy');

//         Route::match(['get', 'post'], 'calculation/{checklist}', [Checklists::class, 'calculation'])
//             ->name('calculation');

//         // Route::get('calculation/{checklist}', [Checklists::class, 'calculation'])
//             // ->name('calculation');
// });

// // Checklists Categories
// Route::prefix('checklist-category')
//     ->name('api.checklist-category.')
//     ->group(function () {

//         Route::post('store', [ChecklistCategories::class, 'store'])
//             ->name('store');

//         Route::post('show/{category}', [ChecklistCategories::class, 'show'])
//             ->name('show');

//         Route::post('update/{category}', [ChecklistCategories::class, 'update'])
//             ->name('update');

//         Route::post('destroy/{category}', [ChecklistCategories::class, 'destroy'])
//             ->name('destroy');
// });

// // Checklists Services
// Route::prefix('checklist-service')
//     ->name('api.checklist-service.')
//     ->group(function () {

//         Route::post('store', [ChecklistServices::class, 'store'])
//             ->name('store');

//         Route::post('show/{service}', [ChecklistServices::class, 'show'])
//             ->name('show');

//         Route::post('update/{service}', [ChecklistServices::class, 'update'])
//             ->name('update');

//         Route::post('destroy/{service}', [ChecklistServices::class, 'destroy'])
//             ->name('destroy');
// });
