<?php

namespace App\Models;

use App\Traits\HasDefaultPagination;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as PermissionModel;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Permission extends PermissionModel
{
    use HasFactory, LogsActivity, HasDefaultPagination;

    protected $table = 'permissions';

    protected $fillable = [
        'parent_id',
        'name',
        'desc',
        'guard_name'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function parent()
    {
        return $this->belongsTo(Permission::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Permission::class, 'parent_id');
    }

    protected static $logAttributes = ['name', 'text', 'guard_name'];

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
            $activity->description = "{$userName}, {$pageTitle} isimli yeni izin ekledi.";
        } elseif ($eventName === 'updated') {
            $changes = $this->getChanges();
            if (isset($changes['title'])) {
                $oldTitle = $this->getOriginal('title');
                $activity->description = "{$userName}, {$oldTitle} isimli iznin adını {$pageTitle} olarak değiştirdi.";
            } else {
                $activity->description = "{$userName}, {$pageTitle} isimli iznin içeriğini güncelledi.";
            }
        } elseif ($eventName === 'deleted') {
            $activity->description = "{$userName}, {$pageTitle} isimli izni sildi.";
        }
    }

}
