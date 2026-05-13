<?php

declare(strict_types=1);

namespace App\Services\Panel\Members;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Events\Panel\Members\MemberCreatedEvent;
use App\Events\Panel\Members\MemberEmailChangeConfirmedEvent;
use App\Events\Panel\Members\MemberEmailChangeRequestedEvent;
use App\Events\Panel\Members\MemberEmailVerifiedEvent;
use App\Events\Panel\Members\MemberStatusUpdatedEvent;
use App\Events\Panel\Members\MemberWelcomeAcceptedEvent;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yadahan\AuthenticationLog\AuthenticationLog;

class MemberService
{
    /**
     * @param  array{q?: string}  $filters
     */
    public function paginate(array $filters): LengthAwarePaginator
    {
        $search = $filters['q'] ?? '';
        $escaped = addcslashes($search, '%_\\');

        return User::query()
            ->where('user_type', UserType::Member->value)
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
     * @param  array{name: string, email: string, status: string, email_verified?: bool}  $data
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
                'user_type' => UserType::Member,
                'locale' => $causer->locale ?? config('app.locale'),
                'timezone' => $causer->timezone ?? config('app.timezone'),
            ]);

            if ($emailVerified) {
                $user->forceFill(['email_verified_at' => now()])->save();
            }

            MemberCreatedEvent::dispatch($user, $causer, $emailVerified);

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

            MemberEmailVerifiedEvent::dispatch($user, $causer);

            return $user;
        });
    }

    public function requestEmailChange(User $user, User $causer, string $email): void
    {
        DB::transaction(function () use ($user, $causer, $email): void {
            $this->logoutUserFromAllSessions($user);

            MemberEmailChangeRequestedEvent::dispatch($user, $causer, $email);
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

            MemberEmailChangeConfirmedEvent::dispatch($user, $oldEmail, $email);

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

            MemberStatusUpdatedEvent::dispatch($user, $causer, $oldStatus, $status);

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

            MemberWelcomeAcceptedEvent::dispatch($user, $emailVerified);

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
