<?php

namespace App\Models;

use App\Enums\Status;
use App\Models\State;
use App\Traits\HasDefaultPagination;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Country extends Model
{
    use HasFactory, LogsActivity, HasDefaultPagination;

    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'title',
        'slug',
        'code'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'status' => Status::class,
        ];
    }

    /**
     * States.
    */
    public function states() {
        return $this->hasMany(State::class, 'country_id');
    }

    /**
     * Taxes.
    */
    public function taxes() {
        return $this->hasMany(Tax::class, 'country_id');
    }

    protected static $logAttributes = ['status', 'title', 'slug', 'code'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->useLogName('panel')
                ->logOnlyDirty()
                ->dontSubmitEmptyLogs()
                ->logFillable();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $userName = auth()->user()?->name .' '.auth()->user()?->surname ?? "Panel User";
        $pageTitle = $this->title;

        if ($eventName === 'created') {
            $activity->description = "{$userName}, {$pageTitle} isimli yeni ülke ekledi.";
        } elseif ($eventName === 'updated') {
            $changes = $this->getChanges();
            if (isset($changes['title'])) {
                $oldTitle = $this->getOriginal('title');
                $activity->description = "{$userName}, {$oldTitle} isimli ülkenin adını {$pageTitle} olarak değiştirdi.";
            } else {
                $activity->description = "{$userName}, {$pageTitle} isimli ülke içeriğini güncelledi.";
            }
        } elseif ($eventName === 'deleted') {
            $activity->description = "{$userName}, {$pageTitle} isimli ülkeyi sildi.";
        }
    }

}
