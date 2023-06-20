<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Login::class => ['App\Listeners\LoginSuccesful'],
        Logout::class => ['App\Listeners\LogoutSuccesful'],

        // 'Illuminate\Auth\Events\Attempting' => [
        //     'App\Listeners\LogAuthenticationAttempt',
        // ],

        // 'Illuminate\Auth\Events\Authenticated' => [
        //     'App\Listeners\LogAuthenticated',
        // ],

        // 'Illuminate\Auth\Events\Login' => [
        //     'App\Listeners\LogSuccessfulLogin',
        // ],

        // 'Illuminate\Auth\Events\Failed' => [
        //     'App\Listeners\LogFailedLogin',
        // ],

        // 'Illuminate\Auth\Events\Validated' => [
        //     'App\Listeners\LogValidated',
        // ],

        // 'Illuminate\Auth\Events\Verified' => [
        //     'App\Listeners\LogVerified',
        // ],

        // 'Illuminate\Auth\Events\Logout' => [
        //     'App\Listeners\LogSuccessfulLogout',
        // ],

        // 'Illuminate\Auth\Events\CurrentDeviceLogout' => [
        //     'App\Listeners\LogCurrentDeviceLogout',
        // ],

        // 'Illuminate\Auth\Events\OtherDeviceLogout' => [
        //     'App\Listeners\LogOtherDeviceLogout',
        // ],

        // 'Illuminate\Auth\Events\Lockout' => [
        //     'App\Listeners\LogLockout',
        // ],

        // 'Illuminate\Auth\Events\PasswordReset' => [
        //     'App\Listeners\LogPasswordReset',
        // ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
