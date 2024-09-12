<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\Settings\{
    PagesController,
    SettingsController,
    UsersController
};
use App\Http\Controllers\Admin\Tools\{
    AuthLogsController,
    CacheController
};
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'auth.session', 'verified', 'adminpanel', 'accountstatus'])->prefix('panel')->name('panel.')->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/passive', 'passive')->name('passive');
    });

    Route::prefix('tools')->name('tools.')->group( function() {
        Route::controller(CacheController::class)->group( function() {
            Route::get('/cache', 'index')->name('cache');
            Route::post('/cache-clear', 'cache')->name('cache.clear');
            Route::post('/optimize-clear', 'optimize')->name('optimize.clear');
            Route::post('/view-clear', 'view')->name('view.clear');
            Route::post('/route-clear', 'route')->name('route.clear');
            Route::post('/config-clear', 'config')->name('config.clear');
        });

        Route::controller(AuthLogsController::class)->group( function() {
            Route::get('/user-auth-logs', 'index')->name('user.authLogs');
            Route::get('/admin-auth-logs', 'admins')->name('admin.authLogs');
        });

        Route::controller(LogViewerController::class)->group( function() {
            Route::get('/logs', 'index')->name('logs');
        });
    });

    Route::prefix('settings')->name('settings.')->group( function() {
        Route::controller(SettingsController::class)->group( function() {
            Route::get('/general', 'index')->name('general');
            Route::post('/general/update', 'update')->name('general.update');
        });

        Route::controller(PagesController::class)->group( function() {
            Route::get('/pages', 'index')->name('pages');
            Route::get('/page/create', 'create')->name('page.create');
            Route::post('/page/store', 'store')->name('page.store');
            Route::get('/page/edit/{page}', 'edit')->name('page.edit');
            Route::post('/page/update/{page}', 'update')->name('page.update');
            Route::delete('/page/delete/{page}', 'destroy')->name('page.delete');
        });

        Route::controller(UsersController::class)->group( function() {
            Route::get('/users', 'index')->name('users');
            Route::get('/user/detail/{user}', 'detail')->name('user.detail');
            Route::get('/user/authlogs/{user}', 'authlogs')->name('user.authlogs');
            Route::get('/user/create', 'create')->name('user.create');
            Route::post('/user/store', 'store')->name('user.store');
            Route::delete('/user/delete/{user}', 'destroy')->name('user.delete');

            Route::post('/user/status-update/{user}', 'statusUpdate')->name('user.status.update');
            Route::post('/user/change-email/{user}', 'changeEmail')->name('user.change.email');
            Route::post('/user/verify-email/{user}', 'verifyEmail')->name('user.verify.email');
            Route::post('/user/check-email/{user}', 'checkEmail')->name('user.check.email');
            Route::post('/user/change-password/{user}', 'changePassword')->name('user.change.password');
            Route::post('/user/reset-password/{user}', 'resetPassword')->name('user.reset.password');
        });
    });

    Route::controller(ProfileController::class)->group( function() {
        Route::get('/profile', 'index')->name('profile');
        Route::get('/profile/password', 'password')->name('profile.password');
    });

});
