<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

class Settings extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
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
                ->logOnly(['key', 'value']);
    }
}
