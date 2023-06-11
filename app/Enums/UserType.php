<?php

namespace App\Enums;

enum UserType: int
{
    case ADMIN = 1;
    case USER = 2;

    public function title(): string
    {
        return match($this)
        {
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
