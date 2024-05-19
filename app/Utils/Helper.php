<?php

namespace App\Utils;

use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Helper
{

    /**
     * Renk kodunun koyuluğuna göre font kodunu ayarlama
     * https://stackoverflow.com/questions/12228644/how-to-detect-light-colors-with-php
     */
    public static function isDark($hex)
    {
        $average = 381; // range 1 - 765
        if (strlen(trim($hex)) == 4) {
            $hex = "#" . substr($hex, 1, 1) . substr($hex, 1, 1) . substr($hex, 2, 1) . substr($hex, 2, 1) . substr($hex, 3, 1) . substr($hex, 3, 1);
        }
        return ((hexdec(substr($hex, 1, 2)) + hexdec(substr($hex, 3, 2)) + hexdec(substr($hex, 5, 2)) < $average) ? true : false);
    }

    /**
     * Get part of string.
     * @param string $string
     * @param int $start
     * @param int $end
     * @return string
     * Örnek Kullanım: Helper::short_it($post->body,0,40)
     * Girilen içeriğin başlangıçtan kırkıncı karaktere kadar olan bölümünü alır
     * Kaynak: https://blog.corelux.com.tr/laravelde-kendi-helper-sinifimizi-olusturmak
     */
    public static function short_it(string $string, int $start = 0, int $end = 35): string
    {
        return mb_substr($string, $start, $end, 'UTF-8') . '...';
    }

    /**
     * Timezones
     *
     * List of timezones
     */
    static public function getTimeZoneList()
    {
        return Cache::rememberForever('timezones_list_collection', function () {
            $timestamp = time();
            foreach (timezone_identifiers_list(DateTimeZone::ALL) as $key => $value) {
                date_default_timezone_set($value);
                $timezone[$value] = $value . ' (UTC ' . date('P', $timestamp) . ')';
            }
            return collect($timezone)->sortKeys();
        });
    }

    /**
     * User Timezone
     *
     * List of timezones
     */
    static public function getUserTimeZone()
    {
        $user_settings = json_decode(Auth::user()->settings, true);
        $user_timezone = $user_settings['timezone'];
        return optional($user_timezone ?? config('app.timezone'));
    }

    /**
     * User Settings is active
     *
     * Check usersettings is active
     */
    static public function checkUserSettings()
    {

        $usersettings = config('panel.usersettings');

        if($usersettings == 1)
        {
            return true;
        }
    }

    /**
     * Date Formats
     *
     * Which will try to obtain the timezone defined by the user,
     * if it exists, and otherwise it will return the application’s default timezone.
     */
    public static function dateformats(): array
    {
        return [
            'j F Y',
            'F j, Y',
            'Y-m-d',
            'm/d/Y',
            'd/m/Y',
        ];
    }

    /**
     * Time Formats
     *
     * List of time formats
     */
    public static function timeformats(): array
    {
        return [
            'g:i a',
            'g:i:s a',
            'H:i',
        ];
    }

}
