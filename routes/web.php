<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Profile\TwoFactorAuthenticationController;
use App\Http\Controllers\Setting\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Events\TwoFactorAuthenticationEvent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'login');

Route::middleware(['auth', 'auth.session', 'verified', 'panel_settings'])->prefix('panel')->name('panel.')->group(function () {

    Route::group(['middleware' => ['role:User']], function () {
        Route::controller(Dashboard::class)->group(function () {
            Route::get('/', 'index')->name('home');
            Route::get('/passive', 'passive')->name('passive');
        });
    });

    Route::controller(SettingController::class)->group(function () {
        Route::get('/settings/general', 'index')->name('app.settings');
        Route::post('/settings/user', 'user')->name('system.update.user.settings');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile');
    });

    Route::controller(TwoFactorAuthenticationController::class)->group(function () {
        Route::get('/two-factor-authentication', 'index')->name('twofactor');
    });
});
