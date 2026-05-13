<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Str;

class ActivitySubjectLabels
{
    public static function for(?string $subjectType): ?string
    {
        if ($subjectType === null || $subjectType === '') {
            return null;
        }

        $className = class_basename($subjectType);

        return match ($className) {
            'Account' => 'Hesap',
            'City' => 'İl',
            'Country' => 'Ülke',
            'Currency' => 'Para Birimi',
            'District' => 'İlçe',
            'Language' => 'Dil',
            'Setting' => 'Ayar',
            'Tax' => 'Vergi Oranı',
            'User' => 'Kullanıcı',
            default => Str::of($className)->headline()->toString(),
        };
    }

    /**
     * @return array{value: string, label: string}
     */
    public static function option(string $subjectType): array
    {
        $value = class_basename($subjectType);

        return [
            'value' => $value,
            'label' => self::for($subjectType) ?? $value,
        ];
    }
}
