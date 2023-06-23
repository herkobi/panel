<?php

namespace App\Enums;

enum Status: int
{
    case ACTIVE = 1;
    case PASSIVE = 2;

    public function title(): string
    {
        return match ($this) {
            self::ACTIVE => 'Aktif',
            self::PASSIVE => 'Pasif',
        };
    }

    public static function getTitle($type)
    {
        switch ($type) {
            case self::ACTIVE->value:
                return 'Aktif';
            case self::PASSIVE->value:
                return 'Pasif';
            default:
                throw new \Exception('Invalid type');
        }
    }
}
