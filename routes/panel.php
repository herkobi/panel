<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Accounts\AccountsController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\Settings\{
    PagesController,
    SettingsController,
    UsersController
};
use App\Http\Controllers\Admin\Tools\{
    ActivitiesController,
    AuthLogsController,
    CacheController,
    CountryController,
    LanguageController
};
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'auth.session', 'verified', 'panel:admin', 'userstatus', 'system.settings'])->prefix('panel')->name('panel.')->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/passive', 'passive')->name('passive');
    });

    Route::controller(AccountsController::class)->group( function() {
        Route::get('/accounts', 'index')->name('accounts');
        Route::get('/account/detail/{user}', 'detail')->name('account.detail');
        Route::get('/account/authlogs/{user}', 'authlogs')->name('account.authlogs');
        Route::get('/account/create', 'create')->name('account.create');
        Route::post('/account/store', 'store')->name('account.store');
        Route::delete('/account/delete/{user}', 'destroy')->name('account.delete');

        Route::post('/account/status-update/{user}', 'statusUpdate')->name('account.status.update');
        Route::post('/account/change-email/{user}', 'changeEmail')->name('account.change.email');
        Route::post('/account/verify-email/{user}', 'verifyEmail')->name('account.verify.email');
        Route::post('/account/check-email/{user}', 'checkEmail')->name('account.check.email');
        Route::post('/account/change-password/{user}', 'changePassword')->name('account.change.password');
        Route::post('/account/reset-password/{user}', 'resetPassword')->name('account.reset.password');

        Route::get('/accounts/latest', 'latest')->name('accounts.latest');
        Route::get('/accounts/unverified', 'unverified')->name('accounts.unverified');
        Route::get('/accounts/inactive', 'inactive')->name('accounts.inactive');

        Route::get('/accounts/draft', 'draft')->name('accounts.draft');
        Route::get('/accounts/passive', 'passive')->name('accounts.passive');
        Route::get('/accounts/deleted', 'deleted')->name('accounts.deleted');
    });

    Route::prefix('tools')->name('tools.')->group( function() {

        Route::prefix('config')->name('config.')->group(function() {
            Route::controller(CountryController::class)->group( function() {
                Route::get('/countries', 'index')->name('countries');
                Route::get('/country/create', 'create')->name('country.create');
                Route::post('/country/store', 'store')->name('country.store');
                Route::get('/country/edit/{country}', 'edit')->name('country.edit');
                Route::post('/country/update/{country}', 'update')->name('country.update');
                Route::delete('/country/delete/{country}', 'destroy')->name('country.delete');
            });

            Route::controller(LanguageController::class)->group( function() {
                Route::get('/languages', 'index')->name('languages');
                Route::get('/language/create', 'create')->name('language.create');
                Route::post('/language/store', 'store')->name('language.store');
                Route::get('/language/edit/{language}', 'edit')->name('language.edit');
                Route::post('/language/update/{language}', 'update')->name('language.update');
                Route::delete('/language/delete/{language}', 'destroy')->name('language.delete');
            });
        });

        Route::controller(CacheController::class)->group( function() {
            Route::get('/cache', 'index')->name('cache');
            Route::post('/cache-clear', 'cache')->name('cache.clear');
            Route::post('/optimize-clear', 'optimize')->name('optimize.clear');
            Route::post('/view-clear', 'view')->name('view.clear');
            Route::post('/route-clear', 'route')->name('route.clear');
            Route::post('/config-clear', 'config')->name('config.clear');
            Route::post('/event-clear', 'event')->name('event.clear');
        });

        Route::controller(ActivitiesController::class)->group( function() {
            Route::get('/users-activities', 'users')->name('users.activities');
            Route::get('/admins-activities', 'admins')->name('admins.activities');
            Route::get('/passwords-activities', 'passwords')->name('passwords.activities');
        });

        Route::controller(AuthLogsController::class)->group( function() {
            Route::get('/users-auth-logs', 'users')->name('users.authLogs');
            Route::get('/admin-auth-logs', 'admins')->name('admins.authLogs');
        });

        Route::controller(LogViewerController::class)->group( function() {
            Route::get('/logs', 'index')->name('logs');
        });
    });

    Route::prefix('settings')->name('settings.')->group( function() {
        Route::controller(SettingsController::class)->group( function() {
            Route::get('/general', 'index')->name('general');
            Route::post('/general/update', 'updateGeneral')->name('general.update');
            Route::get('/system', 'system')->name('system');
            Route::post('/system/update', 'updateSystem')->name('system.update');
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
            Route::post('/user/reset-password/{user}', 'resetPassword')->name('user.reset.password');
        });
    });

    Route::controller(ProfileController::class)->group( function() {
        Route::get('/profile', 'index')->name('profile');
        Route::post('/profile/update/{user}', 'update')->name('profile.update');
        Route::post('/profile/email-update/{user}', 'mailUpdate')->name('profile.email.update');
        Route::post('/profile/password-update/{user}', 'passwordUpdate')->name('profile.password.update');

        Route::get('/profile/activity-logs', 'activitylogs')->name('profile.activitylogs');
        Route::get('/profile/auth-logs', 'authlogs')->name('profile.authlogs');

        Route::get('/profile/2fa', 'twofactor')->name('profile.twofactor');
    });

});
