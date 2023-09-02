<?php

namespace App\Models;

use App\Enums\UserType;
use Spatie\Permission\Models\Role as RoleModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

class Role extends RoleModel
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'type',
        'desc',
        'guard_name'
    ];

    protected $casts = [
        'type' => UserType::class
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $authuser = !empty(auth()->user()->name) ? auth()->user()->name : 'Super Admin';
        $activity->description = __("role.activity.message.{$eventName}", ['authuser' => $authuser]);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->useLogName('admin')
                ->logOnly(['name', 'type', 'desc']);
    }
}
