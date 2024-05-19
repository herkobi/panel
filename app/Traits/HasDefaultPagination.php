<?php

namespace App\Traits;

trait HasDefaultPagination
{
    public function scopeDefaultPagination($query)
    {
        return $query->orderByRaw('COALESCE(updated_at, created_at) DESC')
                     ->paginate(40);
    }
}
