<?php

use App\Http\Controllers\Activity\AdminActivity;
use App\Http\Controllers\Activity\UserActivity;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Profile\TwoFactorAuthenticationController;
use App\Http\Controllers\Role\PermissionController;
use App\Http\Controllers\Role\PermissiongroupController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserDetailController;
use App\Http\Controllers\User\UsertagController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCreateController;
use App\Http\Controllers\Admin\AdminDetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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

Route::middleware(['auth', 'auth.session', 'verified', 'adminonly', 'panel_settings'])->prefix('panel')->name('panel.')->group(function () {

    Route::middleware(['adminonly'])->group(function(){

        Route::controller(Admin::class)->group(function () {
            Route::get('/admin', 'index')->name('admin');
            Route::get('/admin/passive', 'passive')->name('admin.passive');

        });

        Route::controller(UserController::class)->group(function () {
            Route::get('/users', 'index')->name('users');
            Route::get('/user/modal/data', 'userModelData')->name('user.modal.data');
            Route::post('/role/update', 'updateRole')->name('user.role.update');
            Route::get('/user/filter', 'filter')->name('user.filter');
            Route::get('/user/search', 'search')->name('user.search');
            Route::get('/users/list/tag/{usertag}', 'tags')->name('user.tag.list');
        });

        Route::controller(UserDetailController::class)->group(function () {
            Route::get('/user/detail/{user}', 'show')->name('user.detail');
            Route::post('/user/update/status/{user}', 'status')->name('user.update.status');
            Route::post('/user/synctags/{user}', 'tags')->name('user.synctags');
            Route::post('/user/password/reset/{user}', 'passwordReset')->name('user.password.reset');
            Route::post('/user/email/change/{user}', 'changeEmail')->name('user.change.email');
            Route::post('/user/email/verify/{user}', 'verifyEmail')->name('user.email.verify');
            Route::get('/user/permissions/{user}', 'permissions')->name('user.permissions');
            Route::post('/user/create/permissions/{user}', 'givePermissions')->name('store.user.permissions');

        });

        Route::controller(UsertagController::class)->group(function () {
            Route::get('/user/tags', 'index')->name('user.tags');
            Route::post('/user/tag/store', 'store')->name('user.tag.store');
            Route::get('/user/tag/{usertag}', 'edit')->name('user.tag.edit');
            Route::post('/user/tag/edit/{usertag}', 'update')->name('user.tag.update');
            Route::post('/user/tag/destroy/{usertag}', 'destroy')->name('user.tag.destroy');
            Route::post('user/tag/store', 'store')->name('user.tag.store');
        });

        Route::controller(AdminController::class)->group(function () {
            Route::get('/admins', 'index')->name('admins');
            Route::post('/admin/update/role/{user}', 'updateRole')->name('admin.update.role');
            Route::get('/admin/filter', 'filter')->name('admin.filter');
            Route::get('/admin/search', 'search')->name('admin.search');

        });

        Route::controller(AdminDetailController::class)->group(function () {
            Route::get('/admin/detail/{user}', 'show')->name('admin.detail');
            Route::post('/admin/update/status/{user}', 'status')->name('admin.update.status');
            Route::get('/admin/permissions/{user}', 'permissions')->name('admin.permissions');
            Route::post('/admin/create/permissions/{user}', 'givePermissions')->name('store.admin.permissions');
            Route::post('/admin/password/reset/{user}', 'passwordReset')->name('admin.password.reset');
            Route::post('/admin/email/verify/{user}', 'verifyEmail')->name('admin.email.verify');
            Route::post('/admin/email/change/{user}', 'changeEmail')->name('admin.change.email');
        });

        Route::controller(AdminCreateController::class)->group(function () {
            Route::get('/admin/create', 'create')->name('create.admin');
            Route::post('/admin/create/store', 'admin')->name('store.admin');
        });

        Route::controller(SettingController::class)->group(function () {
            Route::get('/settings/general', 'index')->name('general.user.settings');
            Route::post('/settings/user', 'user')->name('update.user.settings');
            Route::get('/settings/system', 'system')->name('system.settings');
            Route::post('/settings/update', 'update')->name('update.system.settings');
        });

        Route::controller(RoleController::class)->group(function () {
            Route::get('/roles', 'index')->name('roles');
            Route::get('/role/detail/{role}', 'show')->name('role.show');
            Route::get('/role/create', 'create')->name('role.create');
            Route::post('/role/permissions/', 'permissions')->name('role.permissions');
            Route::get('/role/permissions/create/{role}', 'permissionsstore')->name('role.permissions.store');
            Route::post('/role/store/{role}', 'store')->name('role.store');
            Route::get('/role/{role}', 'edit')->name('role.edit');
            Route::post('/role/edit/{role}', 'update')->name('role.update');
            Route::post('/role/destroy/{role}', 'destroy')->name('role.destroy');
        });

        Route::controller(PermissionController::class)->group(function () {
            Route::get('/permissions', 'index')->name('permissions');
            Route::post('/permission/store', 'store')->name('permission.store');
            Route::get('/permission/{permission}', 'edit')->name('permission.edit');
            Route::post('/permission/edit/{permission}', 'update')->name('permission.update');
            Route::post('/permission/destroy/{permission}', 'destroy')->name('permission.destroy');
            Route::get('/autocomplete', 'autocomplete')->name('permission.autocomplete');
        });

        Route::controller(PermissiongroupController::class)->group(function () {
            Route::get('/permission-groups', 'index')->name('permission.groups');
            Route::post('/permission-group/store', 'store')->name('permission.group.store');
            Route::get('/permission-group/{permissiongroup}', 'edit')->name('permission.group.edit');
            Route::post('/permission-group/edit/{permissiongroup}', 'update')->name('permission.group.update');
            Route::post('/permission-group/destroy/{permissiongroup}', 'destroy')->name('permission.group.destroy');
        });

        Route::controller(AdminActivity::class)->group(function () {
            Route::get('/activity/admin', 'index')->name('admin.activity');
        });

        Route::controller(UserActivity::class)->group(function () {
            Route::get('/activity/user', 'index')->name('user.activity');
        });

        Route::redirect('/panel/log-viewer', '/panel/log-viewer')->name('system-logs');

        Route::get('/health', \Spatie\Health\Http\Controllers\HealthCheckResultsController::class);

        Route::prefix('cache')->name('cache.')->group(function () {
            Route::get('/clear/all', function() {
                Artisan::call('optimize:clear');
                return "Cleared!";
            })->name('clear.all');

            Route::get('/clear/cache', function() {
                Artisan::call('cache:clear');
                return "Cleared!";
            })->name('clear.cache');

            Route::get('/clear/config', function() {
                Artisan::call('config:clear');
                return "Cleared!";
            })->name('clear.config');

            Route::get('/clear/route', function() {
                Artisan::call('route:clear');
                return "Cleared!";
            })->name('clear.route');

            Route::get('/clear/view', function() {
                Artisan::call('view:clear');
                return "Cleared!";
            })->name('clear.view');
        });

    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile');
    });

    Route::controller(TwoFactorAuthenticationController::class)->group(function () {
        Route::get('/two-factor-authentication', 'index')->name('twofactor');
    });

});
