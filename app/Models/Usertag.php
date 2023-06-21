<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usertag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'desc'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'group_id', 'id');
    }
}
