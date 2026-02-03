<?php

declare(strict_types=1);

use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('welcome');
})->name('home');

Route::get('/settings', [SettingsController::class, 'index'])
    ->name('settings.index');

Route::get('/settings/account', [SettingsController::class, 'account'])
    ->name('settings.account');
