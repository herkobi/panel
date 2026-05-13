<?php

declare(strict_types=1);

namespace App\Events\Panel\Tools\Definitions\Country;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class CountryDeactivatedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly Country $country,
        public readonly User $causer,
    ) {}
}
