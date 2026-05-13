<?php

declare(strict_types=1);

use App\Http\Controllers\Panel\Members\MembersController;
use App\Http\Controllers\Panel\Settings\User\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login')->name('home');

Route::get('/panel/settings/users/{user}/email/change/confirm', [UsersController::class, 'confirmEmailChange'])
    ->middleware('signed')
    ->name('panel.settings.users.email.confirm');

Route::get('/panel/settings/users/{user}/welcome', [UsersController::class, 'acceptWelcome'])
    ->middleware('signed')
    ->name('panel.settings.users.welcome');

Route::get('/panel/members/{user}/email/change/confirm', [MembersController::class, 'confirmEmailChange'])
    ->middleware('signed')
    ->name('panel.members.email.confirm');

Route::get('/panel/members/{user}/welcome', [MembersController::class, 'acceptWelcome'])
    ->middleware('signed')
    ->name('panel.members.welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $userType = request()->user()->user_type;

        if ($userType->isAdmin()) {
            return redirect()->route('panel.dashboard');
        }

        if ($userType->isMember()) {
            return redirect()->route('app.dashboard');
        }

        // Supplier or any other type not allowed
        Auth::logout();

        return redirect()->route('login')->with('toast', ['type' => 'error', 'message' => __('auth.must_login')]);
    })->name('dashboard');
});
