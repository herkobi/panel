<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Facades\Health;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Health::checks([
            OptimizedAppCheck::new(),
            CacheCheck::new()->label("Cache Bilgisi"),
            DatabaseCheck::new(),
            DebugModeCheck::new(),
            EnvironmentCheck::new(),
            UsedDiskSpaceCheck::new()
                ->warnWhenUsedSpaceIsAbovePercentage(90)
                ->failWhenUsedSpaceIsAbovePercentage(95),
            ScheduleCheck::new()->heartbeatMaxAgeInMinutes(2),
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        /**
         * Boostrap 5'e ait sayfalama stilini kullanma
         */
        Paginator::useBootstrapFive();

        /**
         * Settings tablosundaki değerlere direk erişmeyi sağlıyor.
         * Kullanımı config('panel.userrole')
         * Kaynak: https://darkghosthunter.medium.com/laravel-loading-the-settings-from-the-database-or-file-9b4a3df5db75
         */

        // if not cli
        if (php_sapi_name() !== 'cli') {
            $app = Setting::where('key','app')->first();
            $settings = Setting::where('key','settings')->first();

            $appData = json_decode($app->value, true) ? json_decode($app->value, true) : [];
            $settingsData = json_decode($settings->value, true) ? json_decode($settings->value, true) : [];

            $mergedData = array_merge($appData, $settingsData);

            config(['panel' => $mergedData]);
        }

    }
}
