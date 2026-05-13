<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

#[Fillable([
    'country_id',
    'code',
    'name',
    'status',
    'sort_order',
])]
class City extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected function casts(): array
    {
        return [
            'status' => Status::class,
            'sort_order' => 'integer',
        ];
    }

    public function setCodeAttribute(string $value): void
    {
        $this->attributes['code'] = Str::upper($value);
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', Status::Active->value);
    }

    #[Scope]
    protected function forCountry(Builder $query, string $countryId): void
    {
        $query->where('country_id', $countryId);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }
}
