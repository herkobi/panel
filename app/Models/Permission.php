<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as PermissionModel;
use App\Models\Permissiongroup;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class Permission extends PermissionModel
{
    use HasFactory, Loggable;

    protected $table = 'permissions';

    protected $fillable = [
        'name',
        'group_id',
        'text',
        'guard_name'
    ];

    public function group()
    {
        return $this->belongsTo(Permissiongroup::class, 'group_id', 'id');
    }
}
