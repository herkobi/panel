<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Account;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Account ownership for member-scoped models. Data hangs off `account_id`
 * (not `user_id`) so multiple member users of the same Account can share it.
 *
 * When a "current account" is bound (see BindCurrentAccount middleware, active
 * only in the member/app area), all queries auto-filter by it and new records
 * get `account_id` auto-filled. Outside that context (panel/admin, seeders,
 * jobs) nothing is bound → no scope, no auto-fill, so admins stay cross-account
 * and ownership is set explicitly via the relation.
 */
trait BelongsToAccount
{
    protected static function bootBelongsToAccount(): void
    {
        static::addGlobalScope('account', function (Builder $builder): void {
            $account = static::currentAccount();

            if ($account !== null) {
                $builder->where(
                    $builder->getModel()->qualifyColumn('account_id'),
                    $account->getKey(),
                );
            }
        });

        static::creating(function (Model $model): void {
            if ($model->getAttribute('account_id') !== null) {
                return;
            }

            $account = static::currentAccount();

            if ($account !== null) {
                $model->setAttribute('account_id', $account->getKey());
            }
        });
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * The account bound for the current request, or null when none is active.
     */
    protected static function currentAccount(): ?Account
    {
        if (! app()->bound('account.current')) {
            return null;
        }

        $account = app('account.current');

        return $account instanceof Account ? $account : null;
    }
}
