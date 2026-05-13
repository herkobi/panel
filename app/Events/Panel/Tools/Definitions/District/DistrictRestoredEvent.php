<?php

declare(strict_types=1);

namespace App\Events\Panel\Tools\Definitions\District;

use App\Models\District;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class DistrictRestoredEvent
{
    use Dispatchable;

    public function __construct(
        public readonly District $district,
        public readonly User $causer,
    ) {}
}
