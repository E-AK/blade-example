<?php

declare(strict_types=1);

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('welcome');
});

Route::get('/account', [AccountsController::class, 'index'])
    ->name('account');

Route::get('/users', [UsersController::class, 'index'])
    ->name('users');

Route::group(['prefix' => 'settings'], static function () {
    Route::get('account', [App\Http\Controllers\Settings\AccountsController::class, 'index'])
        ->name('settings.account');
});
