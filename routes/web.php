<?php

declare(strict_types=1);

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\Connections\DataStorageController;
use App\Http\Controllers\Connections\SbisController;
use App\Http\Controllers\CustomTablesController;
use App\Http\Controllers\DataShowcasesController;
use App\Http\Controllers\ImportSettingsController;
use App\Http\Controllers\Services\LinkShortenerController;
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

Route::group(['prefix' => 'custom-tables'], static function () {
    Route::get('/', [CustomTablesController::class, 'index'])
        ->name('custom-tables.index');
    Route::get('{custom_table}/edit', [CustomTablesController::class, 'edit'])
        ->name('custom-tables.edit');
    Route::get('{custom_table}', [CustomTablesController::class, 'show'])
        ->name('custom-tables.show');
});

Route::get('import-settings', [ImportSettingsController::class, 'index'])
    ->name('import-settings.index');

Route::get('data-showcases', [DataShowcasesController::class, 'index'])
    ->name('data-showcases.index');

Route::group(['prefix' => 'connections'], static function () {
    Route::get(
        'sbis',
        [SbisController::class, 'index']
    )
        ->name('connections.sbis');
    Route::get(
        'data-storage',
        [DataStorageController::class, 'index']
    )
        ->name('connections.data-storage');
});

Route::get('services/link-shortener', [LinkShortenerController::class, 'index'])
    ->name('services.link-shortener');
