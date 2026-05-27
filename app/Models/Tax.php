<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasStatus;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'name',
    'rate',
    'status',
])]
class Tax extends Model
{
    use HasFactory, HasStatus, HasUuids, SoftDeletes;

    protected function casts(): array
    {
        return [
            'rate' => 'decimal:2',
            'status' => Status::class,
        ];
    }
}
