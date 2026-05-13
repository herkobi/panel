<?php

declare(strict_types=1);

namespace App\Enums;

enum UserStatus: string
{
    case Active = 'active';
    case Passive = 'passive';
    case Draft = 'draft';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Aktif',
            self::Passive => 'Pasif',
            self::Draft => 'Kısıtlı',
        };
    }

    /**
     * Check if status is active.
     *
     * @return bool True if status is active, false otherwise
     */
    public function isActive(): bool
    {
        return $this === self::Active;
    }

    /**
     * Check if the user status allows login.
     */
    public function canLogin(): bool
    {
        return match ($this) {
            self::Active, self::Draft => true,
            self::Passive => false,
        };
    }

    /**
     * Check if the user status implies read-only access.
     * (e.g., DRAFT status)
     */
    public function isReadOnly(): bool
    {
        return $this === self::Draft;
    }

    /**
     * Get all available options for forms.
     *
     * @return array Array of status values mapped to their labels
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
