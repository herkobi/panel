<?php

namespace App\Providers;

use App\Listeners\Admin\Tools\PasswordResetRequest;
use App\Services\SettingService;
use Illuminate\Auth\Events\PasswordResetLinkSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('setting', function ($app) {
            return $app->make(SettingService::class);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(PasswordResetLinkSent::class, PasswordResetRequest::class);
    }
}
