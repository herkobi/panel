<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Profile\{
    ProfileController,
    TwoFactorAuthenticationController
};
use App\Http\Controllers\Admin\Gateways\{
    GatewayController,
    BacController,
    PaytrController,
};
use App\Http\Controllers\Admin\Roles\{
    PermissionController,
    RoleController
};
use App\Http\Controllers\Admin\Settings\{
    AppSettingsController,
    CountryController,
    CurrencyController,
    LanguageController,
    PaymentController,
    SystemSettingsController,
    StateController,
    TaxController,
};
use App\Http\Controllers\Admin\Accounts\{
    AccountsController,
    AccountDetailController,
};
use App\Http\Controllers\Admin\Users\{
    UsersController,
    UserDetailController
};
use App\Http\Controllers\Admin\Pages\PagesController;
use App\Http\Controllers\Admin\Tools\{
    ActivitiesController,
    AuthLogsController,
    CacheController
};
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Events\TwoFactorAuthenticationEvent;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

Route::middleware(['auth', 'auth.session', 'system', 'verified', 'adminpanel'])->prefix('panel')->name('panel.')->group(function () {

    /**
     * Admin Başlangıç
     */
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/passive', 'passive')->name('passive');
    });

    /**
     * Kullanıcılar
     */
    Route::controller(AccountsController::class)->group(function () {
        Route::get('/accounts', 'index')->name('accounts');
        Route::get('/account/detail/{user}', 'show')->name('account.detail');
        Route::get('/account/create', 'create')->name('account.create');
        Route::post('/account/create/store', 'store')->name('account.store');
    });

    /**
     * Kullanıcı İşlemleri
     */
    Route::controller(AccountDetailController::class)->group(function () {
        Route::post('/account/update/status/{user}', 'updateStatus')->name('account.update.status');
        Route::get('/account/permissions/{user}', 'permissions')->name('account.permissions');
        Route::post('/account/create/permissions/{user}', 'givePermissions')->name('store.account.permissions');
        Route::post('/account/password/reset/{user}', 'resetPassword')->name('account.reset.password');
        Route::post('/account/password/change/{user}', 'changePassword')->name('account.change.password');
        Route::post('/account/email/change/{user}', 'changeEmail')->name('account.change.email');
        Route::post('/account/email/verify/{user}', 'verifyEmail')->name('account.verify.email');
        Route::post('/account/email/check/{user}', 'checkEmail')->name('account.check.email');
    });

    /**
     * Yöneticiler
     */
    Route::controller(UsersController::class)->group(function () {
        Route::get('/users', 'index')->name('users');
        Route::get('/user/detail/{user}', 'show')->name('user.detail');
        Route::get('/user/create', 'create')->name('user.create');
        Route::post('/user/create/store', 'store')->name('user.store');
    });

    /**
     * Yönetici İşlemleri
     */
    Route::controller(UserDetailController::class)->group(function () {
        Route::post('/user/update/status/{user}', 'updateStatus')->name('user.update.status');
        Route::get('/user/permissions/{user}', 'permissions')->name('user.permissions');
        Route::post('/user/create/permissions/{user}', 'givePermissions')->name('store.user.permissions');
        Route::post('/user/password/reset/{user}', 'resetPassword')->name('user.reset.password');
        Route::post('/user/password/change/{user}', 'changePassword')->name('user.change.password');
        Route::post('/user/email/change/{user}', 'changeEmail')->name('user.change.email');
        Route::post('/user/email/verify/{user}', 'verifyEmail')->name('user.verify.email');
        Route::post('/user/email/check/{user}', 'checkEmail')->name('user.check.email');
    });

    /**
     * Ödeme Yöntemleri
     */
    Route::prefix('gateways')->name('gateways.')->group(function() {

        /**
         * Ödeme Yöntemleri
         */
        Route::controller(GatewayController::class)->group(function(){
            Route::get('/bac/list', 'bac')->name('bac');
            Route::get('/cc/list', 'cc')->name('cc');
        });

        /**
         * Eft/Havale İle Ödeme
         */
        Route::controller(BacController::class)->group(function(){
            Route::get('/bac/edit/{bac}', 'edit')->name('bac.edit');
            Route::post('/bac/edit/update/{bac}', 'update')->name('bac.update');
            Route::get('/bac/create', 'create')->name('bac.create');
            Route::post('/bac/create/store', 'store')->name('bac.create.store');
            Route::delete('/bac/destroy/{bac}', 'destroy')->name('bac.destroy');
        });

        /**
         * PayTR İle Ödeme
         */
        Route::controller(PaytrController::class)->group(function(){
            Route::get('/paytr/edit/{paytr}', 'edit')->name('paytr.edit');
            Route::post('/paytr/edit/update/{paytr}', 'update')->name('paytr.update');
        });
    });

    /**
     * Araçlar
     */
    Route::prefix('tools')->name('tools.')->group(function () {
        Route::get('/health', HealthCheckResultsController::class)->name('health');
        Route::get('/health?fresh', HealthCheckResultsController::class)->name('fresh');

        Route::controller(LogViewerController::class)->group(function () {
            Route::get('/logs', 'index')->name('logs');
        });

        Route::controller(AuthLogsController::class)->group(function () {
            Route::get('/accounts-auth-logs', 'index')->name('accounts.auth.logs');
            Route::get('/users-auth-logs', 'users')->name('users.auth.logs');
            Route::get('/auth-logs/detail/{user}', 'authLogs')->name('logs.detail');
        });

        Route::controller(ActivitiesController::class)->group(function () {
            Route::get('/accounts-activities', 'index')->name('accounts.activities');
            Route::get('/users-activities', 'users')->name('users.activities');
        });

        Route::prefix('cache')->name('cache.')->group(function () {
            Route::controller(CacheController::class)->group(function () {
                Route::get('/cache-management', 'index')->name('cache');
                Route::post('/clear-cache', 'cache')->name('clear.cache');
                Route::post('/clear-optimize-cache', 'optimize')->name('clear.optimize.cache');
                Route::post('/clear-view-cache', 'view')->name('clear.view.cache');
                Route::post('/clear-route-cache', 'route')->name('clear.route.cache');
                Route::post('/clear-config-cache', 'config')->name('clear.config.cache');
            });
        });
    });

    /**
     * Ayarlar
     */
    Route::prefix('settings')->name('settings.')->group(function () {

        /**
         * Uygulama Ayarları
         */
        Route::controller(AppSettingsController::class)->group(function () {
            Route::get('/app-settings', 'app')->name('app');
            Route::post('/app/update', 'update')->name('update.app');
        });

        /**
         * Sistem Ayarları
         */
        Route::controller(SystemSettingsController::class)->group(function () {
            Route::get('/system-settings', 'system')->name('system');
            Route::post('/system/update', 'update')->name('update.system');
        });

        /**
         * Bölgeler
         */
        Route::prefix('locations')->name('locations.')->group(function () {

            Route::controller(CountryController::class)->group(function(){
                Route::get('/countries', 'index')->name('countries');
                Route::get('/country/create', 'create')->name('country.create');
                Route::post('/country/create/store', 'store')->name('country.create.store');
                Route::get('/country/edit/{country}', 'edit')->name('country.edit');
                Route::post('/country/update/{id}', 'update')->name('country.update');
                Route::delete('/country/destroy/{country}', 'destroy')->name('country.destroy');
            });

            Route::controller(StateController::class)->group(function(){
                Route::get('/states/{country}', 'index')->name('states');
                Route::get('/state/{country}/create', 'create')->name('state.create');
                Route::post('/state/{country}/create/store', 'store')->name('state.create.store');
                Route::get('/state/edit/{state}', 'edit')->name('state.edit');
                Route::post('/state/update/{state}', 'update')->name('state.update');
                Route::delete('/state/destroy/{state}', 'destroy')->name('state.destroy');
            });
        });

        /**
         * Vergi Oranları
         */
        Route::controller(TaxController::class)->group(function(){
            Route::get('/taxes', 'index')->name('taxes');
            Route::get('/tax/create', 'create')->name('tax.create');
            Route::post('/tax/create/store', 'store')->name('tax.create.store');
            Route::get('/tax/edit/{tax}', 'edit')->name('tax.edit');
            Route::post('/tax/update/{tax}', 'update')->name('tax.update');
            Route::delete('/tax/destroy/{tax}', 'destroy')->name('tax.destroy');
        });

        /**
         * Para Birimleri
         */
        Route::controller(CurrencyController::class)->group(function(){
            Route::get('/currencies', 'index')->name('currencies');
            Route::get('/currency/create', 'create')->name('currency.create');
            Route::post('/currency/create/store', 'store')->name('currency.create.store');
            Route::get('/currency/edit/{currency}', 'edit')->name('currency.edit');
            Route::post('/currency/update/{currency}', 'update')->name('currency.update');
            Route::delete('/currency/destroy/{currency}', 'destroy')->name('currency.destroy');
        });

        /**
         * Ödeme Sistemleri
         */
        Route::controller(PaymentController::class)->group(function(){
            Route::get('/payment-systems', 'index')->name('payments');
        });

        /**
         * Diller
         */
        Route::controller(LanguageController::class)->group(function(){
            Route::get('/languages', 'index')->name('languages');
            Route::get('/language/edit/{language}', 'edit')->name('language.edit');
            Route::post('/language/update/{language}', 'update')->name('language.update');
            Route::get('/language/create', 'create')->name('language.create');
            Route::post('/language/create/store', 'store')->name('language.create.store');
            Route::delete('/language/destroy/{language}', 'destroy')->name('language.destroy');
        });

    });

    /**
     * Sabit Sayfalar &amp; Sözleşmeler
     */
    Route::controller(PagesController::class)->group(function(){
        Route::get('/pages', 'index')->name('pages');
        Route::get('/page/create', 'create')->name('page.create');
        Route::post('/page/create/store', 'store')->name('page.create.store');
        Route::get('/page/edit/{page}', 'edit')->name('page.edit');
        Route::post('/page/update/{page}', 'update')->name('page.update');
        Route::delete('/page/destroy/{page}', 'destroy')->name('page.destroy');
    });

    /**
     * Yetki Yönetimi
     */
    Route::controller(RoleController::class)->group(function(){
        Route::get('/roles', 'index')->name('roles');
        Route::get('/role/create', 'create')->name('role.create');
        Route::post('/role/create/store', 'store')->name('role.create.store');
        Route::get('/role/edit/{role}', 'edit')->name('role.edit');
        Route::post('/role/update/{role}', 'update')->name('role.update');
        Route::delete('/role/destroy/{role}', 'destroy')->name('role.destroy');

        Route::get('/role/detail/{role}', 'detail')->name('role.detail');
        Route::post('/role/permissions/{role}', 'permissions')->name('role.permissions');

    });

    /**
     * İzin Yönetimi
     */
    Route::controller(PermissionController::class)->group(function(){
        Route::get('/permissions', 'index')->name('permissions');
    });

    /**
     * Profil Yönetimi
     */
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile');
        Route::get('/profile/settings', 'settings')->name('profile.settings');
        Route::get('/profile/two-factor-authentication', 'twofactor')->name('profile.twofactor');
        Route::get('/profile/activity', 'activity')->name('profile.activity');
        Route::get('/profile/auth-logs', 'authlogs')->name('profile.authlogs');

        Route::post('/profile/update', 'updateProfile')->name('profile.update');
        Route::post('/profile/email', 'updateEmail')->name('profile.email.update');
        Route::post('/profile/password', 'updatePassword')->name('profile.password.update');
    });

    /**
     * İki Faktörlü Doğrulama
     */
    Route::controller(TwoFactorAuthenticationController::class)->group(function () {
    });

});
