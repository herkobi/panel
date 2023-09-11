<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\UserType;
use App\Models\Permission;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class Permissiongroup extends Model
{
    use HasFactory, Loggable;

    protected $table = 'permissiongroups';

    protected $fillable = [
        'name',
        'type',
        'desc'
    ];

    protected $casts = [
        'type' => UserType::class
    ];

    public function permission()
    {
        return $this->hasMany(Permission::class, 'group_id', 'id');
    }

}
