<?php

Route::get('/', 'WelcomeController@index')->name('welcome');
Route::get('/day', 'WelcomeController@day')->name('day');
Route::get('/month', 'WelcomeController@month')->name('month');


Route::get('/reports', 'ReportController@index')->name('reports.index');
Route::post('/reports', 'ReportController@reports')->name('reports.post');
Route::get('setting', 'SettingController@index')->name('setting.index');
Route::post('setting', 'SettingController@post')->name('setting.post');
Route::get('backups', 'BackupController@index')->name('backups.index');
Route::post('backups/create', 'BackupController@create')->name('backups.create');
Route::post('backups/process', 'BackupController@process')->name('backups.process');

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

//user routes
Route::resource('users', 'UserController')->except(['show']);


Route::post('orders/offline', 'OrderController@offline')->name('orders.offline');
