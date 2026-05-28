<?php

declare(strict_types=1);

namespace App\Events\Panel\Tools\Definitions\Tax;

use App\Models\Tax;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaxActivatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Tax $tax,
        public readonly User $causer,
    ) {}
}
