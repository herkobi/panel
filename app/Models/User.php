<?php

namespace App\Models;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Usertag;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'type',
        'status',
        'name',
        'email',
        'email_verified_at',
        'password',
        'settings',
        'created_by',
        'created_by_name',
        'terms',
        'last_login_at',
        'last_login_ip',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'status' => UserStatus::class,
        'type' => UserType::class,
        'settings' => 'array',
    ];

    // /**
    //  * Get the user's first name.
    //  *
    //  * @return \Illuminate\Database\Eloquent\Casts\Attribute
    //  */
    // protected function settings(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => json_decode($value, true),
    //         set: fn ($value) => json_encode($value),
    //     );
    // }

    public function getTimeZoneAttribute($value): string
    {
        return $value == config('app.timezone') || empty($value) ? config('app.timezone') : $value;
    }

    public function setTimeZoneAttribute($value)
    {
        $this->attributes['timezone'] = $value == config('app.timezone') || is_null($value) ? null : $value;
    }

    public function usertags()
    {
        return $this->belongsToMany(Usertag::class)->withTimestamps();
    }
}
