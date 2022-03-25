<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\DriverController;
use App\Http\Controllers\Dashboard\WelcomeController;
use App\Http\Controllers\Dashboard\GlobalSearchController;
use App\Http\Controllers\Dashboard\Setting\ReportController;
use App\Http\Controllers\Dashboard\Setting\SettingController;
use App\Http\Controllers\Dashboard\Setting\AuditLogsController;

Route::get('/', [WelcomeController::class,'index'])->name('welcome');
Route::get('/day', [WelcomeController::class,'day'])->name('day');
Route::get('/month', [WelcomeController::class,'month'])->name('month');

//global-search routes
Route::get('/global-search', GlobalSearchController::class)->name('globalSearch');

Route::middleware('role:super-admin')
    ->prefix('setting/')
    ->name('setting.')
    ->group(function () {

        //settings routes
        Route::view('/', 'dashboard.setting.settings.index')->name('index');
        Route::post('/update', SettingController::class)->name('update');

        //reports routes
        Route::view('reports', 'dashboard.setting.reports.index')->name('reports.index');
        Route::post('reports', ReportController::class)->name('reports.get_data');

        //audit-logs
        Route::resource('audit-logs', AuditLogsController::class)->only(['index', 'show']);
    });

//category routes
Route::resource('categories', CategoryController::class)->except(['show']);

//products routes
Route::resource('products', ProductController::class);

//drivers routes
Route::resource('drivers', DriverController::class)->except(['show']);

//orders routes
Route::resource('orders', OrderController::class)->except(['show']);
Route::prefix('orders')
    ->controller(OrderController::class)
    ->name('orders.')
    ->group(function () {
        Route::get('/{order}/products', 'products')->name('products');
        Route::put('/{order}/update_status', 'update_status')->name('update_status');
        Route::post('offline', 'offline')->name('offline');
    });

//admins routes
Route::resource('admins', AdminController::class);
Route::get('admins/{admin}/day', [AdminController::class, 'day'])->name('admins.day');
Route::get('admins/{admin}/month', [AdminController::class, 'month'])->name('admins.month');

//messenger routes
Route::prefix('messenger')
    ->controller(MessengerController::class)
    ->name('messenger.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'createTopic')->name('createTopic');
        Route::post('/', 'storeTopic')->name('storeTopic');
        Route::get('/inbox', 'showInbox')->name('showInbox');
        Route::get('/outbox', 'showOutbox')->name('showOutbox');
        Route::get('/{topic}', 'showMessages')->name('showMessages');
        Route::delete('/{topic}', 'destroyTopic')->name('destroyTopic');
        Route::post('/{topic}/reply', 'replyToTopic')->name('reply');
        Route::get('/{topic}/reply', 'showReply')->name('showReply');
    });

// profile routes
Route::prefix('profile')
    ->controller(ChangeProfileController::class)
    ->name('profile.')
    ->group(function () {
        Route::view('/', 'dashboard.profile.edit')->name('edit');
        Route::post('/password', 'updatePassword')->name('password.update');
        Route::post('/info', 'updateProfile')->name('info.update');
        Route::delete('/destroy', 'destroy')->name('destroy');
    });
