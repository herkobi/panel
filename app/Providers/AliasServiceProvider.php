<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\Facades\Agent;

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
        $loader->alias('Helper', \App\Utils\Helper::class);
        $loader->alias('Status', \App\Enums\Status::class);
        $loader->alias('AccountStatus', \App\Enums\AccountStatus::class);
        $loader->alias('UserType', \App\Enums\UserType::class);
        $loader->alias('Carbon', Carbon::class);
        $loader->alias('Agent', Agent::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
