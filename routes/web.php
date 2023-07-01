<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Dashboard;
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

Route::middleware(['auth', 'auth.session', 'verified'])->prefix('panel')->name('panel.')->group(function () {

    Route::controller(Dashboard::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/passive', 'passive')->name('passive');
    });

    Route::controller(Admin::class)->group(function () {
        Route::get('/admin', 'index')->name('admin');
        Route::get('/admin/passive', 'passive')->name('admin.passive');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('users');
        Route::get('/user/detail/{user}', 'show')->name('user.detail');
        Route::get('/user/edit/{user}', 'edit')->name('user.edit');
        Route::get('/user/filter', 'filter')->name('user.filter');
        Route::post('/user/synctags', 'tags')->name('user.synctags');
        Route::post('/user/update/status', 'status')->name('user.update.status');
    });

    Route::controller(UserDetailController::class)->group(function () {
        Route::post('/user/password/reset/{user}', 'passwordReset')->name('user.password.reset');
        Route::post('/user/email/verify/{user}', 'verifyEmail')->name('user.email.verify');
        Route::post('/user/email/change/{user}', 'changeEmail')->name('user.change.email');
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
        Route::get('/admin/detail/{user}', 'show')->name('admin.detail');
        Route::get('/admin/create', 'createAdmin')->name('create.admin');
        Route::get('/admin/permissions/{user}', 'permissionAdmin')->name('admin.permissions');
        Route::get('/admin/filter', 'filter')->name('admin.filter');
        Route::get('/admin/edit/{user}', 'editAdmin')->name('admin.edit');
        Route::post('/admin/update/status', 'status')->name('admin.update.status');
    });

    Route::controller(AdminDetailController::class)->group(function () {
        Route::post('/admin/password/reset/{user}', 'passwordReset')->name('admin.password.reset');
        Route::post('/admin/email/verify/{user}', 'verifyEmail')->name('admin.email.verify');
        Route::post('/admin/email/change/{user}', 'changeEmail')->name('admin.change.email');
    });

    Route::controller(AdminCreateController::class)->group(function () {
        Route::post('/admin/create/store', 'admin')->name('store.admin');
        Route::post('/admin/create/permissions/{user}', 'permissions')->name('store.admin.permissions');
    });

    Route::controller(SettingController::class)->group(function () {
        Route::get('/settings/general', 'index')->name('app.settings');
        Route::get('/settings/system', 'system')->name('system.settings');
        Route::post('/settings/update', 'update')->name('system.settings.update');
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

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile');
    });

    Route::controller(TwoFactorAuthenticationController::class)->group(function () {
        Route::get('/two-factor-authentication', 'index')->name('twofactor');
    });

    Route::redirect('/panel/log-viewer', '/panel/log-viewer')->name('system-logs');
});
