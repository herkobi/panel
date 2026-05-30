<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use App\Providers\FortifyServiceProvider;
use App\Providers\ModuleServiceProvider;

return [
    ModuleServiceProvider::class,
    AppServiceProvider::class,
    FortifyServiceProvider::class,
];
