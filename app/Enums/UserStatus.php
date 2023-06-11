<?php

namespace App\Enums;

enum UserStatus: int
{
    case ACTIVE = 1;
    case DRAFT = 2;
    case PASSIVE = 3;
    case DELETED = 4;

    public function title(): string
    {
        return match($this)
        {
            self::ACTIVE => 'Aktif',
            self::DRAFT => 'Duraklatılmış',
            self::PASSIVE => 'Dondurulmuş',
            self::DELETED => 'Silinmiş',
        };
    }

    public static function getTitle($type)
    {
        switch ($type) {
            case self::ACTIVE->value:
                return 'Aktif';
            case self::DRAFT->value:
                return 'Duraklatılmış';
            case self::PASSIVE->value:
                return 'Dondurulmuş';
            case self::DELETED->value:
                return 'Silinmiş';
            default:
                throw new \Exception('Invalid type');
        }
    }
}
