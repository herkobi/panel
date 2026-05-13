<?php

declare(strict_types=1);

namespace App\Services\Panel\Profile;

use App\Events\Panel\Profile\PreferencesUpdatedEvent;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PreferencesService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data): User {
            $user->fill([
                'locale' => $data['locale'],
                'timezone' => $data['timezone'],
            ]);

            $user->save();

            if ($user->wasChanged(['locale', 'timezone'])) {
                PreferencesUpdatedEvent::dispatch($user);
            }

            return $user;
        });
    }
}
