<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class Usertag extends Model
{
    use HasFactory, Loggable;

    protected $table = 'usertags';

    protected $fillable = [
        'status',
        'name',
        'color',
        'desc'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => Status::class,
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
