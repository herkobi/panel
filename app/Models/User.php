<?php

namespace App\Models;

use App\Enums\AccountStatus;
use App\Enums\UserType;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, TwoFactorAuthenticatable;

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
        'title',
        'about',
        'email',
        'email_verified_at',
        'password',
        'settings',
        'created_by',
        'created_by_name',
        'terms',
        'last_login_at',
        'last_login_ip',
        'agent',
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
            'settings' => 'array',
            'agent' => 'array'
        ];
    }

}
