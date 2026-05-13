<?php

declare(strict_types=1);

namespace App\Events\Panel\Tools\Definitions\Language;

use App\Models\Language;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class LanguageCreatedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly Language $language,
        public readonly User $causer,
    ) {}
}
