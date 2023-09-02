<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as PermissionModel;
use App\Models\Permissiongroup;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

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

    public function tapActivity(Activity $activity, string $eventName)
    {
        $authuser = !empty(auth()->user()->name) ?auth()->user()->name : 'Super Admin';
        $activity->description = __("permission.activity.message.{$eventName}", ['authuser' => $authuser]);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->useLogName('admin')
                ->logOnly(['name', 'group_id', 'text']);
    }

    public function group()
    {
        return $this->belongsTo(Permissiongroup::class, 'group_id', 'id');
    }
}
