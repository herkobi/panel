<?php

use App\Http\Controllers\User\{
    DashboardController,
    Profile\ProfileController,
    Profile\TwoFactorAuthenticationController,
};
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Events\TwoFactorAuthenticationEvent;

Route::middleware(['auth', 'auth.session', 'system', 'verified', 'userpanel', 'accountstatus'])->prefix('app')->name('app.')->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/passive', 'passive')->name('passive');
    });

    /**
     * Profil Yönetimi
     */
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile');
        Route::get('/profile/two-factor-authentication', 'twofactor')->name('profile.twofactor');
        Route::get('/profile/activity', 'activity')->name('profile.activity');
        Route::get('/profile/auth-logs', 'authlogs')->name('profile.authlogs');

        Route::post('/profile/update', 'updateProfile')->name('profile.update');
        Route::post('/profile/email', 'updateEmail')->name('profile.email.update');
        Route::post('/profile/password', 'updatePassword')->name('profile.password.update');
    });

});
