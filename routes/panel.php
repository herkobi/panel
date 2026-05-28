<?php

declare(strict_types=1);

use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Panel\Members\MembersController;
use App\Http\Controllers\Panel\Profile\NotificationsController;
use App\Http\Controllers\Panel\Profile\PreferencesController;
use App\Http\Controllers\Panel\Profile\ProfileController;
use App\Http\Controllers\Panel\Profile\SecurityController;
use App\Http\Controllers\Panel\Profile\SessionsController;
use App\Http\Controllers\Panel\Settings\General\SettingsController;
use App\Http\Controllers\Panel\Settings\Permissions\PermissionsController;
use App\Http\Controllers\Panel\Settings\Roles\RolesController;
use App\Http\Controllers\Panel\Settings\User\UsersController;
use App\Http\Controllers\Panel\Tools\Activity\ActivityController;
use App\Http\Controllers\Panel\Tools\Cache\CacheController;
use App\Http\Controllers\Panel\Tools\Definitions\CityController;
use App\Http\Controllers\Panel\Tools\Definitions\CountryController;
use App\Http\Controllers\Panel\Tools\Definitions\CurrencyController;
use App\Http\Controllers\Panel\Tools\Definitions\DistrictController;
use App\Http\Controllers\Panel\Tools\Definitions\LanguageController;
use App\Http\Controllers\Panel\Tools\Definitions\TaxController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'user_type:admin', 'active_user', 'write_access', 'route_permission'])->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });

    Route::controller(MembersController::class)->prefix('members')->name('members.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::post('/{user}/email/verify', 'verifyEmail')->name('email.verify');
        Route::post('/{user}/email/change', 'requestEmailChange')->name('email.change');
        Route::patch('/{user}/status', 'updateStatus')->name('status');
        Route::get('/{user}', 'show')->name('show');
    });

    Route::prefix('tools')->name('tools.')->group(function () {
        Route::controller(ActivityController::class)->group(function () {
            Route::get('activity', 'index')->name('activity');
        });

        Route::controller(CacheController::class)->group(function () {
            Route::get('cache', 'index')->name('cache');
            Route::post('cache/clear/{type}', 'clear')->name('cache.clear');
        });

        Route::prefix('definitions')->name('definitions.')->group(function () {

            Route::controller(LanguageController::class)->prefix('languages')->name('languages.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/deleted', 'deleted')->name('deleted');
                Route::post('/', 'store')->name('store');
                Route::put('/{language}', 'update')->name('update');
                Route::patch('/{language}/status', 'status')->name('status');
                Route::delete('/{language}', 'destroy')->name('destroy');
                Route::patch('/deleted/{language}', 'restore')->name('restore');
                Route::delete('/deleted/{language}', 'forceDelete')->name('force-delete');
            });

            Route::controller(CurrencyController::class)->prefix('currencies')->name('currencies.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/deleted', 'deleted')->name('deleted');
                Route::post('/', 'store')->name('store');
                Route::put('/{currency}', 'update')->name('update');
                Route::patch('/{currency}/status', 'status')->name('status');
                Route::delete('/{currency}', 'destroy')->name('destroy');
                Route::patch('/deleted/{currency}', 'restore')->name('restore');
                Route::delete('/deleted/{currency}', 'forceDelete')->name('force-delete');
            });

            Route::controller(CountryController::class)->prefix('countries')->name('countries.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/deleted', 'deleted')->name('deleted');
                Route::post('/', 'store')->name('store');
                Route::put('/{country}', 'update')->name('update');
                Route::patch('/{country}/status', 'status')->name('status');
                Route::delete('/{country}', 'destroy')->name('destroy');
                Route::patch('/deleted/{country}', 'restore')->name('restore');
                Route::delete('/deleted/{country}', 'forceDelete')->name('force-delete');
            });

            Route::scopeBindings()->controller(CityController::class)->prefix('countries/{country:slug}/cities')->name('countries.cities.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/deleted', 'deleted')->name('deleted');
                Route::post('/', 'store')->name('store');
                Route::put('/{city:code}', 'update')->name('update');
                Route::patch('/{city:code}/status', 'status')->name('status');
                Route::delete('/{city:code}', 'destroy')->name('destroy');
                Route::patch('/deleted/{city}', 'restore')->name('restore');
                Route::delete('/deleted/{city}', 'forceDelete')->name('force-delete');
            });

            Route::scopeBindings()->controller(DistrictController::class)->prefix('countries/{country:slug}/cities/{city:code}/districts')->name('countries.cities.districts.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/deleted', 'deleted')->name('deleted');
                Route::post('/', 'store')->name('store');
                Route::put('/{district}', 'update')->name('update');
                Route::patch('/{district}/status', 'status')->name('status');
                Route::delete('/{district}', 'destroy')->name('destroy');
                Route::patch('/deleted/{district}', 'restore')->name('restore');
                Route::delete('/deleted/{district}', 'forceDelete')->name('force-delete');
            });

            Route::controller(TaxController::class)->prefix('taxes')->name('taxes.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/deleted', 'deleted')->name('deleted');
                Route::post('/', 'store')->name('store');
                Route::put('/{tax}', 'update')->name('update');
                Route::patch('/{tax}/status', 'status')->name('status');
                Route::delete('/{tax}', 'destroy')->name('destroy');
                Route::patch('/deleted/{tax}', 'restore')->name('restore');
                Route::delete('/deleted/{tax}', 'forceDelete')->name('force-delete');
            });
        });

    });

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::controller(SettingsController::class)->prefix('general')->name('general.')->group(function () {
            Route::get('/', 'edit')->name('edit');
            Route::post('/', 'update')->name('update');
            Route::post('/asset', 'uploadAsset')->name('asset.upload');
            Route::delete('/asset', 'destroyAsset')->name('asset.destroy');
        });

        Route::controller(UsersController::class)->prefix('users')->name('users.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::post('/{user}/email/verify', 'verifyEmail')->name('email.verify');
            Route::post('/{user}/email/change', 'requestEmailChange')->name('email.change');
            Route::patch('/{user}/status', 'updateStatus')->name('status');
            Route::patch('/{user}/role', 'updateRole')->name('role');
            Route::get('/{user}', 'show')->name('show');
        });

        Route::controller(PermissionsController::class)->prefix('permissions')->name('permissions.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/discover', 'discover')->name('discover');
            Route::post('/discover', 'bulkStore')->name('bulk-store');
            Route::put('/{permission}', 'update')->name('update');
            Route::delete('/{permission}', 'destroy')->name('destroy');
        });

        Route::controller(RolesController::class)->prefix('roles')->name('roles.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{role}', 'show')->name('show');
            Route::patch('/{role}', 'update')->name('update');
            Route::delete('/{role}', 'destroy')->name('destroy');
        });
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
