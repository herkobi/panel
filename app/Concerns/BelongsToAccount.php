<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Account;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Adds the Account ownership relationship for member-scoped models.
 *
 * Member-scoped data hangs off `account_id` (not `user_id`), so multiple
 * member users belonging to the same Account can share the same records.
 */
trait BelongsToAccount
{
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
