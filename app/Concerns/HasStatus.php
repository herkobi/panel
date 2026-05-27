<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

/**
 * Ortak `Status` enum'u (Active/Passive) kullanan modeller için scope trait'i.
 *
 * Sadece `App\Enums\Status` kullanan modellerde uygulanır.
 *
 * @property Status $status
 */
trait HasStatus
{
    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', Status::Active->value);
    }

    #[Scope]
    protected function passive(Builder $query): void
    {
        $query->where('status', Status::Passive->value);
    }

    public function isActive(): bool
    {
        return $this->getAttribute('status') === Status::Active;
    }
}
