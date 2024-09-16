<?php

namespace App\Models;

use App\Enums\AccountStatus;
use App\Enums\UserType;
use App\Traits\HasDefaultPagination;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasUuids, HasDefaultPagination, TwoFactorAuthenticatable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'status',
        'name',
        'surname',
        'email',
        'email_verified_at',
        'password',
        'terms',
        'last_login_at',
        'last_login_ip',
        'agent',
        'created_by',
        'created_by_name',
        'terms'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'last_login_at' => 'datetime',
            'status' => AccountStatus::class,
            'type' => UserType::class,
            'agent' => 'array',
            'terms' => 'boolean'
        ];
    }

    public function meta()
    {
        return $this->hasOne(UserMeta::class);
    }

    public function authlogs()
    {
        return $this->hasMany(Authlog::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'user_id');
    }
}
