<?php

declare(strict_types=1);

use App\Http\Controllers\App\Account\AccountController;
use App\Http\Controllers\App\DashboardController;
use App\Http\Controllers\App\Profile\NotificationsController;
use App\Http\Controllers\App\Profile\PreferencesController;
use App\Http\Controllers\App\Profile\ProfileController;
use App\Http\Controllers\App\Profile\SecurityController;
use App\Http\Controllers\App\Profile\SessionsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'user_type:member', 'active_user', 'write_access'])->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });

    Route::controller(AccountController::class)->group(function () {
        Route::get('account', 'index')->name('account');
        Route::patch('account', 'update')->name('account.update');
    });

    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::put('email', 'updateEmail')->middleware('throttle:6,1')->name('email.update');

        Route::controller(SecurityController::class)->group(function () {
            Route::get('security', 'edit')->name('security');
            Route::put('password', 'update')->middleware('throttle:6,1')->name('password.update');
        });

        Route::controller(NotificationsController::class)->group(function () {
            Route::get('notifications', 'index')->name('notifications');
            Route::patch('notifications/{notification}/read', 'markAsRead')->name('notifications.read');
        });

        Route::controller(SessionsController::class)->group(function () {
            Route::get('sessions', 'index')->name('sessions');
            Route::delete('sessions/{session}', 'destroy')->name('sessions.destroy');
        });

        Route::controller(PreferencesController::class)->prefix('appearance')->name('appearance.')->group(function () {
            Route::get('/', 'edit')->name('edit');
            Route::put('/', 'update')->name('update');
        });
    });
});
