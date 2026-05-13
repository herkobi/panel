<?php

declare(strict_types=1);

namespace App\Services\Panel\Profile;

use App\Events\Panel\Profile\PasswordUpdatedEvent;
use App\Events\Panel\Profile\ProfileUpdatedEvent;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProfileService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data): User {
            $user->fill($data);

            $user->save();

            if ($user->wasChanged()) {
                ProfileUpdatedEvent::dispatch($user);
            }

            return $user;
        });
    }

    public function updateEmail(User $user, string $email): User
    {
        return DB::transaction(function () use ($user, $email): User {
            $user->forceFill([
                'email' => $email,
                'email_verified_at' => null,
            ])->save();

            ProfileUpdatedEvent::dispatch($user, emailChanged: true);

            return $user;
        });
    }

    public function updatePassword(User $user, string $password): User
    {
        return DB::transaction(function () use ($user, $password): User {
            $user->update([
                'password' => $password,
            ]);

            PasswordUpdatedEvent::dispatch($user);

            return $user;
        });
    }
}
