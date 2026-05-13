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
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

#[Fillable([
    'code',
    'name',
    'native_name',
    'status',
    'sort_order',
])]
class Language extends Model
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
        $this->attributes['code'] = Str::lower($value);
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', Status::Active->value);
    }
}
