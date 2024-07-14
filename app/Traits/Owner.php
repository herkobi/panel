<?php

namespace App\Traits;

use App\Scopes\GlobalQuery;
use Illuminate\Database\Eloquent\Model;

trait Owner
{
    protected static function bootOwner(): void
    {
        if (app()->runningInConsole() || !auth()->check()) {
            return;
        }

        static::creating(function (Model $model) {
            $model->user_id = auth()->id();
        });

        static::updating(function (Model $model) {
            if (!$model->isDirty('user_id')) {
                $model->user_id = auth()->id();
            }
        });

        static::addGlobalScope(new GlobalQuery);
    }
}
