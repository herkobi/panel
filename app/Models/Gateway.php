<?php

namespace App\Models;

use App\Enums\Status;
use App\Models\Currency;
use App\Traits\HasDefaultPagination;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Gateway extends Model
{
    use HasFactory, LogsActivity, HasDefaultPagination;

    protected $table = 'gateways';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'title',
        'desc',
        'payment_id',
        'currency_id',
        'value'
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
            'value' => 'array'
        ];
    }

    /**
     * Selected Payment
     */
    public function payment() {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    /**
     * Selected Currency
     */
    public function currency() {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    protected static $logAttributes = ['status', 'title', 'desc', 'payment_id', 'currency_id', 'value'];

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
        $newTitle = $this->title;

        if ($eventName === 'created') {
            $activity->description = "{$userName}, {$newTitle} isimli yeni ödeme sistemi ekledi.";
        } elseif ($eventName === 'updated') {
            $changes = $this->getChanges();
            if (isset($changes['title'])) {
                $oldTitle = $this->getOriginal('title');
                $activity->description = "{$userName}, {$oldTitle} isimli ödeme sistemini adını {$newTitle} olarak değiştirdi.";
            } else {
                $activity->description = "{$userName}, {$newTitle} isimli ödeme sisteminin içeriğini güncelledi.";
            }
        } elseif ($eventName === 'deleted') {
            $activity->description = "{$userName}, {$newTitle} isimli ödeme sistemini sildi.";
        }
    }

}
