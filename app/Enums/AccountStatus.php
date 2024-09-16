<?php

namespace App\Enums;

enum AccountStatus: int
{
    case ACTIVE = 1;
    case DRAFT = 2;
    case PASSIVE = 3;
    case DELETED = 4;

    public function title(): string
    {
        return match($this) {
            self::ACTIVE => 'ACTIVE',
            self::DRAFT => 'DRAFT',
            self::PASSIVE => 'PASSIVE',
            self::DELETED => 'DELETED',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::ACTIVE => 'text-bg-success',
            self::DRAFT => 'text-bg-secondary',
            self::PASSIVE => 'text-bg-warning',
            self::DELETED => 'text-bg-danger',
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
