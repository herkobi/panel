<?php

declare(strict_types=1);

namespace App\Events\Panel\Tools\Definitions\City;

use App\Models\City;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CityForceDeletedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly City $city,
        public readonly User $causer,
    ) {}
}
