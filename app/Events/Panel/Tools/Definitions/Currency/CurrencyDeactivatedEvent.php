<?php

declare(strict_types=1);

namespace App\Events\Panel\Tools\Definitions\Currency;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class CurrencyDeactivatedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly Currency $currency,
        public readonly User $causer,
    ) {}
}
