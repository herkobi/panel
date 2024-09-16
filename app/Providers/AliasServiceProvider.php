<?php

namespace App\Providers;

use App\Enums\AccountStatus;
use App\Enums\Status;
use App\Enums\UserType;
use App\Facades\Setting;
use Carbon\Carbon;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AliasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Get the AliasLoader instance
        $loader = AliasLoader::getInstance();

        // Add your aliases
        $loader->alias('Status', Status::class);
        $loader->alias('UserType', UserType::class);
        $loader->alias('AccountStatus', AccountStatus::class);
        $loader->alias('Carbon', Carbon::class);
        $loader->alias('Setting', Setting::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
