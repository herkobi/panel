<?php

declare(strict_types=1);

namespace App\Events\Panel\Tools\Definitions\City;

use App\Models\City;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class CityForceDeletedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly City $city,
        public readonly User $causer,
    ) {}
}
