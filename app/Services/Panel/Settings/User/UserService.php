<?php

declare(strict_types=1);

namespace App\Services\Panel\Settings\User;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Events\Panel\Settings\Roles\UserRoleAssignedEvent;
use App\Events\Panel\Settings\User\UserCreatedEvent;
use App\Events\Panel\Settings\User\UserEmailChangeConfirmedEvent;
use App\Events\Panel\Settings\User\UserEmailChangeRequestedEvent;
use App\Events\Panel\Settings\User\UserEmailVerifiedEvent;
use App\Events\Panel\Settings\User\UserStatusUpdatedEvent;
use App\Events\Panel\Settings\User\UserWelcomeAcceptedEvent;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yadahan\AuthenticationLog\AuthenticationLog;

class UserService
{
    /**
     * @param  array{q?: string}  $filters
     */
    public function paginate(array $filters): LengthAwarePaginator
    {
        $search = $filters['q'] ?? '';
        $escaped = addcslashes($search, '%_\\');

        return User::query()
            ->where('user_type', UserType::Admin->value)
            ->when($search !== '', function ($query) use ($escaped) {
                $query->where(function ($q) use ($escaped) {
                    $q->where('name', 'like', '%'.$escaped.'%')
                        ->orWhere('email', 'like', '%'.$escaped.'%');
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();
    }

    /**
     * @return EloquentCollection<int, Activity>
     */
    public function activities(User $user): EloquentCollection
    {
        return Activity::query()
            ->with('causer')
            ->where(function ($query) use ($user) {
                $query->where('causer_id', $user->getKey())
                    ->orWhere(function ($inner) use ($user) {
                        $inner->where('subject_type', User::class)
                            ->where('subject_id', $user->getKey());
                    })
                    ->orWhere('properties->user_id', $user->getKey());
            })
            ->latest()
            ->limit(20)
            ->get();
    }

    /**
     * @return EloquentCollection<int, AuthenticationLog>
     */
    public function authentications(User $user): EloquentCollection
    {
        return $user->authentications()
            ->limit(20)
            ->get();
    }

    /**
     * @param  array{name: string, email: string, status: string, role: string, email_verified?: bool}  $data
     */
    public function create(array $data, User $causer): User
    {
        return DB::transaction(function () use ($data, $causer): User {
            $emailVerified = (bool) ($data['email_verified'] ?? false);

            $user = User::query()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make(Str::random(64)),
                'status' => UserStatus::from($data['status']),
                'user_type' => UserType::Admin,
                'locale' => $causer->locale ?? config('app.locale'),
                'timezone' => $causer->timezone ?? config('app.timezone'),
            ]);

            if ($emailVerified) {
                $user->forceFill(['email_verified_at' => now()])->save();
            }

            $user->syncRoles([$data['role']]);

            UserCreatedEvent::dispatch($user, $causer, $emailVerified);
            UserRoleAssignedEvent::dispatch($user, $causer, $data['role'], null);

            return $user;
        });
    }

    public function verifyEmail(User $user, User $causer): User
    {
        return DB::transaction(function () use ($user, $causer): User {
            if ($user->email_verified_at !== null) {
                return $user;
            }

            $user->forceFill([
                'email_verified_at' => now(),
            ])->save();

            UserEmailVerifiedEvent::dispatch($user, $causer);

            return $user;
        });
    }

    public function requestEmailChange(User $user, User $causer, string $email): void
    {
        DB::transaction(function () use ($user, $causer, $email): void {
            $this->logoutUserFromAllSessions($user);

            UserEmailChangeRequestedEvent::dispatch($user, $causer, $email);
        });
    }

    public function confirmEmailChange(User $user, string $email): User
    {
        return DB::transaction(function () use ($user, $email): User {
            $oldEmail = (string) $user->email;

            $user->forceFill([
                'email' => $email,
                'email_verified_at' => now(),
            ])->save();

            $this->logoutUserFromAllSessions($user);

            UserEmailChangeConfirmedEvent::dispatch($user, $oldEmail, $email);

            return $user;
        });
    }

    public function updateStatus(User $user, User $causer, UserStatus $status): User
    {
        return DB::transaction(function () use ($user, $causer, $status): User {
            $oldStatus = $user->status;

            if ($oldStatus === $status) {
                return $user;
            }

            $user->forceFill([
                'status' => $status,
            ])->save();

            UserStatusUpdatedEvent::dispatch($user, $causer, $oldStatus, $status);

            return $user;
        });
    }

    public function acceptWelcome(User $user): User
    {
        return DB::transaction(function () use ($user): User {
            $emailVerified = false;

            if ($user->email_verified_at === null) {
                $user->forceFill([
                    'email_verified_at' => now(),
                ])->save();

                $emailVerified = true;
            }

            UserWelcomeAcceptedEvent::dispatch($user, $emailVerified);

            return $user;
        });
    }

    private function logoutUserFromAllSessions(User $user): void
    {
        if (config('session.driver') === 'database') {
            DB::table(config('session.table', 'sessions'))
                ->where('user_id', $user->getKey())
                ->delete();
        }

        $user->authentications()
            ->whereNull('logout_at')
            ->update(['logout_at' => now()]);
    }
}
