<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'WelcomeController@index')->name('welcome');
Route::get('/day', 'WelcomeController@day')->name('day');
Route::get('/month', 'WelcomeController@month')->name('month');
Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');

//settings routes
Route::resource('settings', 'Setting\SettingController');

Route::middleware('role:super_admin')->prefix('setting/')->name('setting.')->namespace('Setting')->group(function () {
    //reports routes
    Route::get('reports', 'ReportController@index')->name('reports.index');
    Route::post('reports', 'ReportController@reports')->name('reports.post');

    //Audit Logs
    Route::resource('audit-logs', 'AuditLogsController')->only(['index', 'show']);

    //backups routes
    Route::get('backups', 'BackupController@index')->name('backups.index');
    Route::post('backups/create', 'BackupController@create')->name('backups.create');
    Route::post('backups/delete', 'BackupController@delete')->name('backups.delete');
});

//category routes
Route::resource('categories', 'CategoryController')->except(['show']);

//products routes
Route::resource('products', 'ProductController')->except(['show']);

//drivers routes
Route::resource('drivers', 'DriverController')->except(['show']);

//order routes
Route::resource('orders', 'OrderController')->except(['show']);
Route::get('/orders/{order}/products', 'OrderController@products')->name('orders.products');
Route::put('/orders/{order}/update_status', 'OrderController@update_status')->name('orders.update_status');
Route::post('orders/offline', 'OrderController@offline')->name('orders.offline');

//user routes
Route::resource('users', 'UserController');
Route::get('users/{user}/day', 'UserController@day')->name('users.day');
Route::get('users/{user}/month', 'UserController@month')->name('users.month');

//messenger routes
Route::prefix('messenger')->name('messenger.')->group(function () {
    Route::get('/', 'MessengerController@index')->name('index');
    Route::get('/create', 'MessengerController@createTopic')->name('createTopic');
    Route::post('/', 'MessengerController@storeTopic')->name('storeTopic');
    Route::get('/inbox', 'MessengerController@showInbox')->name('showInbox');
    Route::get('/outbox', 'MessengerController@showOutbox')->name('showOutbox');
    Route::get('/{topic}', 'MessengerController@showMessages')->name('showMessages');
    Route::delete('/{topic}', 'MessengerController@destroyTopic')->name('destroyTopic');
    Route::post('/{topic}/reply', 'MessengerController@replyToTopic')->name('reply');
    Route::get('/{topic}/reply', 'MessengerController@showReply')->name('showReply');
});

// profile routes
Route::prefix('profile')->name('profile.')->group(function () {
    Route::view('/', 'dashboard.profile.edit')->name('edit');
    Route::post('/password', 'ChangeProfileController@updatePassword')->name('password.update');
    Route::post('/info', 'ChangeProfileController@updateProfile')->name('info.update');
    Route::delete('/destroy', 'ChangeProfileController@destroy')->name('destroy');
});
