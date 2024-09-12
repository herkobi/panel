<?php

namespace App\Enums;

enum UserType: int
{
    case SUPER = 1;
    case ADMIN = 2;
    case USER = 3;
    case DEMO = 4;

    public function title(): string
    {
        return match ($this) {
            self::SUPER => 'SUPER ADMIN',
            self::ADMIN => 'ADMIN',
            self::USER => 'USER',
            self::DEMO => 'DEMO',
        };
    }

    public static function fromValue(int $value): ?self
    {
        foreach (self::cases() as $status) {
            if ($status->value === $value) {
                return $status;
            }
        }
        return null;
    }
}
