<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasMedia;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'code',
    'title',
])]
class Account extends Model
{
    use HasFactory, HasMedia, HasUuids;

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    /**
     * Member media lives directly under the account code on each disk
     * (e.g. public/{code}, private/{code}).
     */
    protected function mediaAccountCode(): ?string
    {
        return (string) $this->code;
    }
}
