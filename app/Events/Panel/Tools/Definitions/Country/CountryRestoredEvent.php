<?php

declare(strict_types=1);

namespace App\Events\Panel\Tools\Definitions\Country;

use App\Models\Country;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CountryRestoredEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Country $country,
        public readonly User $causer,
    ) {}
}
