<?php

namespace App\Models;

use App\Traits\HasDefaultPagination;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory, HasDefaultPagination, HasUuids;
    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
