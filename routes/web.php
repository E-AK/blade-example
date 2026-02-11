<?php

declare(strict_types=1);

use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('welcome');
});

Route::get('/settings/account', [SettingsController::class, 'account'])
    ->name('settings.account');