<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait HasDefaultPagination
{
    public function scopeDefaultPagination($query): LengthAwarePaginator
    {
        return $query->orderByRaw('COALESCE(updated_at, created_at) DESC')
                     ->paginate(40);
    }
}
