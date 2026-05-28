<?php

declare(strict_types=1);

namespace App\Events\Panel\Settings\Permissions;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class PermissionsBulkAddedEvent
{
    use Dispatchable;

    /**
     * @param  array<int, string>  $names
     */
    public function __construct(
        public readonly array $names,
        public readonly User $causer,
    ) {}
}
