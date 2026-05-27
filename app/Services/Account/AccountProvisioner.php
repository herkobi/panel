<?php

declare(strict_types=1);

namespace App\Services\Account;

use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccountProvisioner
{
    /**
     * Ensure the given member user owns an Account, creating one (with a unique
     * code) and linking it on first call. Idempotent: returns the existing
     * account on subsequent calls and never provisions for non-member users.
     */
    public function ensureForUser(User $user): ?Account
    {
        if (! $user->user_type->isMember()) {
            return null;
        }

        if ($user->account_id !== null) {
            return $user->account;
        }

        return DB::transaction(function () use ($user): Account {
            $account = Account::query()->create([
                'code' => $this->uniqueCode(),
            ]);

            $user->forceFill(['account_id' => $account->getKey()])->save();

            return $account;
        });
    }

    private function uniqueCode(): string
    {
        do {
            $code = Str::lower(Str::random(10));
        } while (Account::query()->where('code', $code)->exists());

        return $code;
    }
}
