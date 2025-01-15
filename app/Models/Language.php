<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;
use App\Traits\HasDefaultPagination;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory, HasUuids, HasDefaultPagination;

    protected $table = "languages";

    protected $fillable = [
        'status',
        'name',
        'code',
        'regional_code',
        'charset',
        'direction'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'status' => Status::class,
        ];
    }
}
