<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginatedResource
{
    /**
     * @param  class-string  $resourceClass
     */
    public static function make(LengthAwarePaginator $paginator, string $resourceClass, Request $request): LengthAwarePaginator
    {
        return $paginator->through(fn (mixed $item): array => $resourceClass::make($item)->resolve($request));
    }
}
