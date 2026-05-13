<?php

declare(strict_types=1);

namespace App\Enums;

enum UserType: string
{
    case Admin = 'admin';
    case Member = 'member';

    /**
     * Get human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Yönetici',
            self::Member => 'Üye',
        };
    }

    /**
     * Get badge variant for UI display.
     */
    public function badge(): string
    {
        return match ($this) {
            self::Admin => 'destructive',
            self::Member => 'default',
        };
    }

    /**
     * Check if user type is admin.
     */
    public function isAdmin(): bool
    {
        return $this === self::Admin;
    }

    /**
     * Check if user type is member.
     */
    public function isMember(): bool
    {
        return $this === self::Member;
    }

    /**
     * Get all available options for forms.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
