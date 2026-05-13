<?php

declare(strict_types=1);

namespace App\Enums;

enum Status: string
{
    case Active = 'active';
    case Passive = 'passive';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Aktif',
            self::Passive => 'Pasif',
        };
    }
}
