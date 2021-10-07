<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
 */

Artisan::command('project:init', function () {
    Artisan::call('migrate:refresh');
    Artisan::call('db:seed');
    Artisan::call('storage:link');
    Artisan::call('debugbar:clear');
    Artisan::call('optimize:clear');
})->describe('Running commands');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');
