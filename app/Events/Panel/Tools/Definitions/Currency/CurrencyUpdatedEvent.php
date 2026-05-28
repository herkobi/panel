<?php

declare(strict_types=1);

namespace App\Events\Panel\Tools\Definitions\Currency;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CurrencyUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Currency $currency,
        public readonly User $causer,
    ) {}
}
