<?php

namespace App\Enums;

enum Status: int
{
    case ACTIVE = 1;
    case PASSIVE = 2;

    public static function title($title): string
    {
        return match ($title) {
            self::ACTIVE => 'ACTIVE',
            self::PASSIVE => 'PASSIVE',
        };
    }

    /**
     * İlgili alanlarda kullanılması için değerlere atanan başlık
     */
    public static function color($title): string
    {
        return match ($title) {
            self::ACTIVE => 'text-bg-success',
            self::PASSIVE => 'text-bg-warning',
        };
    }

    /**
     * Başlığa üstteki yapının dışında erişilmesini sağlar
     */
    public static function getTitle($type)
    {
        switch ($type) {
            case self::ACTIVE->value:
                return 'AKTİF';
            case self::PASSIVE->value:
                return 'PASİF';
            default:
                throw new \Exception('Invalid type');
        }
    }
}
