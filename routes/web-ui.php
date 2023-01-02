<?php

use Illuminate\Support\Facades\Route;
use App\Models\OvertimeRequest;
use App\Http\Controllers\Index;
use App\Http\Controllers\Login;
use App\Http\Controllers\Accounts;
use App\Http\Controllers\Categories;
use App\Http\Controllers\Checklists;
use App\Http\Controllers\Sections;
use App\Http\Controllers\Services;
use App\Models\Account;
use App\Models\Checklist;
use App\Models\Service;

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
Route::match(['get', 'post'], '/', [Index::class, 'index'])
// Route::get('/', [Index::class, 'index'])
    ->middleware('auth')
    ->name('index');

// Route::get('private')
//     ->uses('PrivateController@show')
//     ->middleware('auth:token,session,telepathy,hunch,whatever');

// Route::get('/login', [Login::class, 'showLoginForm'])
//     ->middleware('guest')
//     ->name('login');

// Route::get('/loginCancel', [Login::class, 'cancel'])
//     ->middleware('guest')
//     ->name('loginCancel');

// Route::post('/authenticate', [Login::class, 'authenticate'])
//     ->middleware('guest')
//     ->name('post.authenticate');

// Route::get('/authenticate', function () {
//     return redirect()->route('login');
// })
//     ->name('get.authenticate');

// Route::get('/login', [Login::class, 'showLoginForm'])
//     ->middleware('guest')
//     ->name('login');

// Route::get('/loginCancel', [Login::class, 'cancel'])
//     ->middleware('guest')
//     ->name('loginCancel');

// Route::get('/logout', [Login::class, 'logout'])
//     ->middleware('auth')
//     ->name('logout');

// Route::name('auth.')
//     // ->middleware('guest')
//     ->group(function () {

//         Route::post('/authenticate', [Login::class, 'authenticate'])
//             ->name('post.authenticate');

//         Route::get('/authenticate', function () {
//             return redirect()->route('login');
//         })
//             ->name('get.authenticate');
//     });

// // Checklist
// Route::prefix('checklist')
//     ->middleware('auth')
//     ->name('checklist.')
//     ->group(function () {
//         Route::match(['get', 'post'], 'list', [Checklists::class, 'index'])
//             ->name('list');

//         // Show the form for creating a new resource.
//         Route::get('create', [Checklists::class, 'create'])
//             ->name('create');

//         // Show the form for editing the specified resource.
//         Route::get('edit/{checklist}', [Checklists::class, 'edit'])
//             ->name('edit');

//         Route::get('overview', [Checklists::class, 'serviceOverview'])
//             ->name('overview');

//         Route::get('overview/{checklist}', [Checklists::class, 'serviceOverviewForChecklist'])
//             ->name('overviewForChecklist');
//     });

// // Admin
// Route::prefix('admin')
//     ->middleware('auth')
//     ->name('admin.')
//     ->group(function () {

//         // Accounts
//         Route::prefix('account')->name('account.')->group(function () {
//             Route::match(['get', 'post'], 'list', [Accounts::class, 'index'])
//                 ->name('list');

//             // Show the form for creating a new resource.
//             Route::get('create', [Accounts::class, 'create'])
//                 ->name('create');

//             // Show the form for editing the specified resource.
//             Route::get('edit/{account}', [Accounts::class, 'edit'])
//                 ->name('edit');
//         });

//         // Checklists
//         Route::prefix('checklist')->name('checklist.')->group(function () {
//             Route::match(['get', 'post'], 'list', [Checklists::class, 'index'])
//                 ->name('list');

//             // Show the form for creating a new resource.
//             Route::get('create', [Checklists::class, 'create'])
//                 ->name('create');

//             // Show the form for editing the specified resource.
//             Route::get('edit/{checklist}', [Checklists::class, 'edit'])
//                 ->name('edit');

//             Route::get('overview', [Checklists::class, 'serviceOverviewAdmin'])
//                 ->name('overview');

//             Route::get('overview/{checklist}', [Checklists::class, 'serviceOverviewForChecklistAdmin'])
//                 ->name('overviewForChecklist');
//         });

//         // Categories
//         Route::prefix('category')->name('category.')->group(function () {
//             Route::match(['get', 'post'], 'list', [Categories::class, 'index'])
//                 ->name('list');

//             // Show the form for creating a new resource.
//             Route::get('create', [Categories::class, 'create'])
//                 ->name('create');

//             // Show the form for editing the specified resource.
//             Route::get('edit/{category}', [Categories::class, 'edit'])
//                 ->name('edit');
//         });

//         // Section
//         Route::prefix('section')->name('section.')->group(function () {
//             Route::match(['get', 'post'], 'list', [Sections::class, 'index'])
//                 ->name('list');

//             // Show the form for creating a new resource.
//             Route::get('create', [Sections::class, 'create'])
//                 ->name('create');

//             // Show the form for editing the specified resource.
//             Route::get('edit/{section}', [Sections::class, 'edit'])
//                 ->name('edit');
//         });

//         // Service
//         Route::prefix('service')->name('service.')->group(function () {
//             Route::match(['get', 'post'], 'list', [Services::class, 'index'])
//                 ->name('list');

//             // Show the form for creating a new resource.
//             Route::get('create', [Services::class, 'create'])
//                 ->name('create');

//             // Show the form for editing the specified resource.
//             Route::get('edit/{service}', [Services::class, 'edit'])
//                 ->name('edit');
//         });
//     });

// // Access
// Route::prefix('access')
//     ->middleware('auth')
//     ->name('access.')
//     ->group(function () {
//         Route::get('my', [Index::class, 'access'])
//             ->name('my');
//     });


// // Mailable
// Route::prefix('mailable')
//     // ->middleware('auth')
//     ->name('mailable.')
//     ->group(function () {

//         Route::prefix('request')
//             // ->middleware('auth')
//             ->name('request.')
//             ->group(function () {

//                 Route::get('retrieved/{overtimeRequest}', function (OvertimeRequest $overtimeRequest) {
//                     return new App\Mail\Request\OvertimeRequestRetrieved($overtimeRequest);
//                 })
//                 ->name('retrieved');

//                 Route::get('created/{overtimeRequest}', function (OvertimeRequest $overtimeRequest) {
//                     return new App\Mail\Request\OvertimeRequestCreated($overtimeRequest);
//                 })
//                 ->name('created');

//                 Route::get('updated/{overtimeRequest}', function (OvertimeRequest $overtimeRequest) {
//                     return new App\Mail\Request\OvertimeRequestUpdated($overtimeRequest);
//                 })
//                 ->name('updated');

//                 Route::get('deleted/{overtimeRequest}', function (OvertimeRequest $overtimeRequest) {
//                     return new App\Mail\Request\OvertimeRequestDeleted($overtimeRequest);
//                 })
//                 ->name('deleted');

//                 // Route::get('submitted/{overtimeRequest}', function (OvertimeRequest $overtimeRequest) {
//                 //     return new App\Mail\Request\OvertimeRequestSubmitted($overtimeRequest);
//                 // })
//                 // ->name('submitted');

//                 // Route::get('approved/{overtimeRequest}', function (OvertimeRequest $overtimeRequest) {
//                 //     return new App\Mail\Request\OvertimeRequestApproved($overtimeRequest);
//                 // })
//                 // ->name('approved');

//                 // Route::get('rejected/{overtimeRequest}', function (OvertimeRequest $overtimeRequest) {
//                 //     return new App\Mail\Request\OvertimeRequestRejected($overtimeRequest);
//                 // })
//                 // ->name('rejected');

//                 // Route::get('flowChanged/{overtimeRequest}', function (OvertimeRequest $overtimeRequest) {
//                 //     return new App\Mail\Request\OvertimeRequestFlowChanged($overtimeRequest);
//                 // })
//                 // ->name('flowChanged');

//             });

//         Route::prefix('account')
//             // ->middleware('auth')
//             ->name('account.')
//             ->group(function () {

//                 Route::get('retrieved/{account}', function (Account $account) {
//                     return new App\Mail\Account\Retrieved($account);
//                 })
//                 ->name('retrieved');

//                 Route::get('created/{account}', function (Account $account) {
//                     return new App\Mail\Account\Created($account);
//                 })
//                 ->name('created');

//                 Route::get('updated/{account}', function (Account $account) {
//                     return new App\Mail\Account\Updated($account);
//                 })
//                 ->name('updated');

//                 Route::get('deleted/{account}', function (Account $account) {
//                     return new App\Mail\Account\Deleted($account);
//                 })
//                 ->name('deleted');

//             });
//     });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
