<?php

declare(strict_types=1);

namespace App\Events\Panel\Tools\Definitions\Tax;

use App\Models\Tax;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class TaxRestoredEvent
{
    use Dispatchable;

    public function __construct(
        public readonly Tax $tax,
        public readonly User $causer,
    ) {}
}
