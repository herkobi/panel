<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as PermissionModel;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Permissiongroup;


class Permission extends PermissionModel
{
    use HasFactory, LogsActivity;

    protected $table = 'permissions';

    protected $fillable = [
        'name',
        'group_id',
        'text',
        'guard_name'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'text', 'group.name'])
            ->setDescriptionForEvent(fn (string $eventName) => "This model has been {$eventName}");;
    }

    public function group()
    {
        return $this->belongsTo(Permissiongroup::class, 'group_id', 'id');
    }
}
