<?php

/**
 * Genel kullanıcı durumlarını tanımlamak için kullanılacak yapı
 * ACTIVE: Kullanıcılar sistemi kullanabilir.
 * DRAFT: Kullanıcılar sisteme erişir ancak yeni kayıt/güncelleme yapamaz.
 * PASSIVE: Kullanıcılar sisteme erişir ancak kendileri için ayrılmış özel sayfaya erişir. Bu sayfadan hesaplarını tekrar aktifleştirmesi gerekir.
 * DELETED: Kullanıcılar sisteme erişemez. Yöneticiler kullanıcıları görür. Bu kullanıcıların kayıtları belirli bir süre sonra silinir.
 */

namespace App\Enums;

enum AccountStatus: int
{
    case ACTIVE = 1;
    case DRAFT = 2;
    case PASSIVE = 3;
    case DELETED = 4;

    public static function title($title): string
    {
        return match ($title) {
            self::ACTIVE => __('admin/global.account.active'),
            self::DRAFT => __('admin/global.account.draft'),
            self::PASSIVE => __('admin/global.account.passive'),
            self::DELETED => __('admin/global.account.deleted'),
        };
    }

    /**
     * İlgili alanlarda kullanılması için değerlere atanan başlık
     */
    public static function color($title): string
    {
        return match ($title) {
            self::ACTIVE => 'text-bg-success',
            self::DRAFT => 'text-bg-secondary',
            self::PASSIVE => 'text-bg-warning',
            self::DELETED => 'text-bg-danger',
        };
    }

    /**
     * Başlığa üstteki yapının dışında erişilmesini sağlar
     */
    public static function getTitle($type)
    {
        switch ($type) {
            case self::ACTIVE->value:
                return __('admin/global.account.active');
            case self::DRAFT->value:
                return __('admin/global.account.draft');
            case self::PASSIVE->value:
                return __('admin/global.account.passive');
            case self::DELETED->value:
                return __('admin/global.account.deleted');
            default:
                throw new \Exception('Invalid type');
        }
    }
}
