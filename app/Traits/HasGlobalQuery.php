<?php

namespace App\Traits;

use App\Scopes\GlobalQuery;

trait HasGlobalQuery
{
    protected static function bootHasGlobalQuery()
    {
        static::addGlobalScope(new GlobalQuery);
    }

    public static function withoutGlobalQuery()
    {
        return static::withoutGlobalScope(GlobalQuery::class);
    }
}
