<?php

declare(strict_types=1);

namespace App\Events\Panel\Tools\Definitions\District;

use App\Models\District;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DistrictForceDeletedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly District $district,
        public readonly User $causer,
    ) {}
}
