<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'desc',
        'guard_name'
    ];

    protected $casts = [
        'type' => UserType::class
    ];
}
