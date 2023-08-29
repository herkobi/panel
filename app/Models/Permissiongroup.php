<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\UserType;
use App\Models\Permission;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

class Permissiongroup extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'permissiongroups';

    protected $fillable = [
        'name',
        'type',
        'desc'
    ];

    protected $casts = [
        'type' => UserType::class
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->description = __("permissiongroup.activity.message.{$eventName}", ['authuser' => auth()->user()->name]);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->useLogName('admin')
                ->logOnly(['name', 'type', 'desc']);
    }

    public function permission()
    {
        return $this->hasMany(Permission::class, 'group_id', 'id');
    }

}
