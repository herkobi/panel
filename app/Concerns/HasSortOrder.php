<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

/**
 * `sort_order` integer kolonu olan modeller için ortak trait.
 *
 * - `sort_order` cast'ini `mergeCasts` ile otomatik ekler (initialize hook).
 * - `ordered()` scope'unu sağlar (`->orderBy('sort_order')`).
 *
 * @property int $sort_order
 */
trait HasSortOrder
{
    public function initializeHasSortOrder(): void
    {
        $this->mergeCasts(['sort_order' => 'integer']);
    }

    #[Scope]
    protected function ordered(Builder $query): void
    {
        $query->orderBy('sort_order');
    }
}
