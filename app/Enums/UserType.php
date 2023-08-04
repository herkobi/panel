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
            self::ADMIN => __('enum.usertype.admin'),
            self::USER => __('enum.usertype.user'),
        };
    }

    /**
     * Başlığa üstteki yapının dışında erişilmesini sağlar
     */
    public static function getTitle($type)
    {
        switch ($type) {
            case self::ADMIN->value:
                return __('enum.usertype.admin');
            case self::USER->value:
                return __('enum.usertype.user');
            default:
                throw new \Exception('Invalid type');
        }
    }
}
