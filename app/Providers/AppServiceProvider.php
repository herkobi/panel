<?php

namespace App\Providers;

use App\Models\Settings;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Settings tablosundaki değerlere direk erişmeyi sağlıyor.
         * Kullanımı config('settings.userrole')
         * Kaynak: https://darkghosthunter.medium.com/laravel-loading-the-settings-from-the-database-or-file-9b4a3df5db75
         */
        config([
            'global' => Settings::all(['key', 'value'])
                ->keyBy('key') // key every setting by its name
                ->transform(function ($setting) {
                    return $setting->value; // return only the value
                })->toArray() // make it an array
        ]);

        /**
         * Bootstrap 5 Stilinde Sayfalama
         * $item->links() şeklinde kullanılıyor
         */
        Paginator::useBootstrapFive();
    }
}
