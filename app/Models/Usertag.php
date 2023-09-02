<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

class Usertag extends Model
{
    use HasFactory, LogsActivity;

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

    public function tapActivity(Activity $activity, string $eventName)
    {
        $authuser = !empty(auth()->user()->name) ? auth()->user()->name : 'Super Admin';
        $activity->description = __("usertag.activity.message.{$eventName}", ['authuser' => $authuser]);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->useLogName('admin')
                ->logOnly(['status', 'name', 'color', 'desc']);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
