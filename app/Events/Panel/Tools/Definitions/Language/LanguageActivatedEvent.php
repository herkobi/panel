<?php

declare(strict_types=1);

namespace App\Events\Panel\Tools\Definitions\Language;

use App\Models\Language;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LanguageActivatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Language $language,
        public readonly User $causer,
    ) {}
}
