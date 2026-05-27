<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Events\Auth\EmailVerificationNotificationRequestedEvent;
use App\Events\Auth\PasswordResetNotificationRequestedEvent;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;
use Yadahan\AuthenticationLog\AuthenticationLogable;

#[Fillable(['name', 'email', 'password', 'status', 'user_type', 'locale', 'timezone', 'media_directory', 'account_id'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use AuthenticationLogable, HasFactory, HasRoles, HasUuids, Notifiable, SoftDeletes, TwoFactorAuthenticatable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => UserStatus::class,
            'user_type' => UserType::class,
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'last_login_at' => 'datetime',
        ];
    }

    public function sendEmailVerificationNotification(): void
    {
        EmailVerificationNotificationRequestedEvent::dispatch($this);
    }

    public function sendPasswordResetNotification($token): void
    {
        PasswordResetNotificationRequestedEvent::dispatch($this, $token);
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', UserStatus::Active->value);
    }

    #[Scope]
    protected function passive(Builder $query): void
    {
        $query->where('status', UserStatus::Passive->value);
    }

    #[Scope]
    protected function draft(Builder $query): void
    {
        $query->where('status', UserStatus::Draft->value);
    }

    #[Scope]
    protected function verified(Builder $query): void
    {
        $query->whereNotNull('email_verified_at');
    }

    #[Scope]
    protected function admin(Builder $query): void
    {
        $query->where('user_type', UserType::Admin->value);
    }

    #[Scope]
    protected function member(Builder $query): void
    {
        $query->where('user_type', UserType::Member->value);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'locale', 'code');
    }
}
