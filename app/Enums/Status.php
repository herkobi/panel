<?php

/**
 * Sistemde kullanılan yapıları aktif ve pasif olarak
 * tanımlamak için kullanılacak ENUM yapısı
 */

namespace App\Enums;

enum Status: int
{
    case ACTIVE = 1;
    case PASSIVE = 2;

    /**
     * İlgili alanlarda kullanılması için değerlere atanan başlık
     */
    public function title(): string
    {
        return match ($this) {
            self::ACTIVE => 'Aktif',
            self::PASSIVE => 'Pasif',
        };
    }

    /**
     * Başlığa üstteki yapının dışında erişilmesini sağlar
     */
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
