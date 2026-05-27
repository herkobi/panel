<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasSortOrder;
use App\Concerns\HasStatus;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'city_id',
    'name',
    'status',
    'sort_order',
])]
class District extends Model
{
    use HasFactory, HasSortOrder, HasStatus, HasUuids, SoftDeletes;

    protected function casts(): array
    {
        return [
            'status' => Status::class,
        ];
    }

    #[Scope]
    protected function forCity(Builder $query, string $cityId): void
    {
        $query->where('city_id', $cityId);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
