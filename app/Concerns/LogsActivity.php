<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Listener'larda spatie/laravel-activitylog yazımının tekrarını engeller.
 *
 * Kullanım: listener `use LogsActivity;` ile dahil eder ve `logActivity(...)`
 * çağırır. `withProperties` boş ise eklenmez.
 */
trait LogsActivity
{
    /**
     * @param  array<string, mixed>  $properties
     */
    protected function logActivity(
        string $logName,
        User $causer,
        string $event,
        string $message,
        ?Model $subject = null,
        array $properties = [],
    ): void {
        $builder = activity($logName)
            ->causedBy($causer)
            ->event($event);

        if ($subject !== null) {
            $builder->performedOn($subject);
        }

        if ($properties !== []) {
            $builder->withProperties($properties);
        }

        $builder->log($message);
    }
}
