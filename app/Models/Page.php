<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\HasDefaultPagination;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Page extends Model
{
    use HasFactory, LogsActivity, HasDefaultPagination, Sluggable;

    protected $table = 'pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'title',
        'slug',
        'text',
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
     * Write code on Method
     *
     * @return response()
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = $this->generateSlug($value);
    }

    protected static $logAttributes = ['status', 'title', 'slug', 'text'];

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
            $activity->description = "{$userName}, {$pageTitle} isimli yeni sayfa oluşturdu.";
        } elseif ($eventName === 'updated') {
            $changes = $this->getChanges();
            if (isset($changes['title'])) {
                $oldTitle = $this->getOriginal('title');
                $activity->description = "{$userName}, {$oldTitle} isimli sayfanın adını {$pageTitle} olarak değiştirdi.";
            } else {
                $activity->description = "{$userName}, {$pageTitle} isimli sayfa içeriğini güncelledi.";
            }
        } elseif ($eventName === 'deleted') {
            $activity->description = "{$userName}, {$pageTitle} isimli sayfayı sildi.";
        }
    }
}
