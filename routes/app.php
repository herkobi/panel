<?php

use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\Profile\{
    ProfileController,
    TwoFactorAuthenticationController
};
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Events\TwoFactorAuthenticationEvent;

Route::middleware(['auth', 'auth.session', 'system', 'verified', 'userpanel'])->prefix('app')->name('app.')->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/passive', 'passive')->name('passive');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile');
    });

    Route::controller(TwoFactorAuthenticationController::class)->group(function () {
        Route::get('/two-factor-authentication', 'index')->name('twofactor');
    });
});
