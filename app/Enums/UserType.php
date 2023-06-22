<?php

namespace App\Enums;

enum UserType: int
{
    case ADMIN = 1;
    case USER = 2;

    public static function title($title): string
    {
        return match ($title) {
            self::ADMIN => 'Yönetici',
            self::USER => 'Kullanıcı',
        };
    }

    public static function getTitle($type)
    {
        switch ($type) {
            case self::ADMIN->value:
                return 'Yönetici';
            case self::USER->value:
                return 'Kullanıcı';
            default:
                throw new \Exception('Invalid type');
        }
    }
}
