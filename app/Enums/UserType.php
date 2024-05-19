<?php

/**
 * Kullanıcı türlerini tanımlamak için kullanılan ENUM dosyası.
 * ADMIN: Yöneticileri tanımlamak için,
 * USER: Kullanıcıları tanımlamak için kullanılır.
 */

namespace App\Enums;

enum UserType: int
{
    case ADMIN = 1;
    case USER = 2;

    /**
     * İlgili alanlarda kullanılması için değerlere atanan başlık
     */
    public static function title($title): string
    {
        return match ($title) {
            self::ADMIN => "Yönetici",
            self::USER => "Kullanıcı",
        };
    }

    /**
     * Başlığa üstteki yapının dışında erişilmesini sağlar
     */
    public static function getTitle($type)
    {
        switch ($type) {
            case self::ADMIN->value:
                return "Yönetici";
            case self::USER->value:
                return "Kullanıcı";
            default:
                throw new \Exception('Invalid type');
        }
    }
}
