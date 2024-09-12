<?php

namespace App\Models;

use App\Traits\HasDefaultPagination;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authlog extends Model
{
    use HasFactory, HasUuids, HasDefaultPagination;

    protected $table = "auth_logs";

    protected $fillable = [
        'event_name',
        'email',
        'user_id',
        'ip_address',
        'user_agent',
        'context'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'context' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
