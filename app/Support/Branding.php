<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

/**
 * Uygulama markası (ad, slogan, logo, favicon) için tek kaynak.
 *
 * Değerler önce `settings` tablosundan (genel ayarlar ekranı) okunur; ayar
 * tanımlı değilse `public/` altındaki varsayılan Herkobi görsellerine ve
 * `config('app.name')` değerine düşer. Hem Inertia paylaşımı, hem Blade kök
 * şablonu, hem de mailler bu helper'ı kullanır; böylece marka bilgisi tek
 * yerden yönetilir.
 */
class Branding
{
    private const DEFAULT_LOGO = 'herkobi.png';

    private const DEFAULT_LOGO_DARK = 'herkobi-white.png';

    private const DEFAULT_FAVICON = 'herkobi-ikon.png';

    public static function name(): string
    {
        $name = Setting::get('app_name');

        return $name !== null && $name !== ''
            ? $name
            : (string) config('app.name', 'Herkobi');
    }

    public static function slogan(): ?string
    {
        $slogan = Setting::get('app_slogan');

        return $slogan !== null && $slogan !== '' ? $slogan : null;
    }

    public static function logo(): string
    {
        return self::resolve('logo_path', self::DEFAULT_LOGO);
    }

    public static function logoDark(): string
    {
        return self::resolve('logo_dark_path', self::DEFAULT_LOGO_DARK);
    }

    public static function favicon(): string
    {
        return self::resolve('favicon_path', self::DEFAULT_FAVICON);
    }

    /**
     * Inertia paylaşımı ve mail için serileştirilmiş marka verisi.
     *
     * @return array{name: string, slogan: string|null, logo: string, logo_dark: string, favicon: string}
     */
    public static function toArray(): array
    {
        return [
            'name' => self::name(),
            'slogan' => self::slogan(),
            'logo' => self::logo(),
            'logo_dark' => self::logoDark(),
            'favicon' => self::favicon(),
        ];
    }

    /**
     * Ayardaki yüklenmiş görselin public URL'i; yoksa public/ altındaki
     * varsayılan görselin asset URL'i.
     */
    private static function resolve(string $settingKey, string $defaultAsset): string
    {
        $path = Setting::get($settingKey);

        if ($path !== null && $path !== '') {
            return Storage::disk('public')->url($path);
        }

        return asset($defaultAsset);
    }
}
