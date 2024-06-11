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

    public static function title($title): string
    {
        return match ($title) {
            self::ACTIVE => __('admin/global.active'),
            self::PASSIVE => __('admin/global.passive'),
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
                return __('admin/global.active');
            case self::PASSIVE->value:
                return __('admin/global.passive');
            default:
                throw new \Exception('Invalid type');
        }
    }
}
