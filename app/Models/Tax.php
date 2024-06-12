<?php

namespace App\Models;

use App\Enums\Status;
use App\Models\Country;
use App\Traits\HasDefaultPagination;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Tax extends Model
{
    use HasFactory, LogsActivity, HasDefaultPagination;

    protected $table = 'taxes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'title',
        'desc',
        'code',
        'value',
        'country_id',
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
     * Countries.
    */
    public function country() {
        return $this->belongsTo(Country::class, 'country_id');
    }

    protected static $logAttributes = ['status', 'title', 'desc', 'code', 'value', 'country_id'];

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
            $activity->description = "{$userName}, {$pageTitle} isimli vergi ekledi.";
        } elseif ($eventName === 'updated') {
            $changes = $this->getChanges();
            if (isset($changes['title'])) {
                $oldTitle = $this->getOriginal('title');
                $activity->description = "{$userName}, {$oldTitle} isimli vergi adını {$pageTitle} olarak değiştirdi.";
            } else {
                $activity->description = "{$userName}, {$pageTitle} isimli vergi içeriğini güncelledi.";
            }
        } elseif ($eventName === 'deleted') {
            $activity->description = "{$userName}, {$pageTitle} isimli vergiyi sildi.";
        }
    }

}
