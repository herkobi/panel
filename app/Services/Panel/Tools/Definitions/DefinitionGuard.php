<?php

declare(strict_types=1);

namespace App\Services\Panel\Tools\Definitions;

use App\Exceptions\DefinitionGuardException;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DefinitionGuard
{
    public function ensureNotDefault(string $settingKey, string $value, string $label): void
    {
        if (Setting::get($settingKey) !== $value) {
            return;
        }

        throw new DefinitionGuardException(
            "{$label} varsayılan olarak seçili olduğu için pasifleştirilemez veya silinemez.",
        );
    }

    public function ensureNoChildren(Model $model, string $relation, string $label): void
    {
        if (! method_exists($model, $relation)) {
            return;
        }

        $query = $model->{$relation}();

        if (in_array(SoftDeletes::class, class_uses_recursive($query->getRelated()), true)) {
            $query->withTrashed();
        }

        if (! $query->exists()) {
            return;
        }

        throw new DefinitionGuardException(
            "{$label} bağlı kayıtları olduğu için silinemez.",
        );
    }
}
