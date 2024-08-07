<?php

namespace App\Utils;

use App\Models\Currency;
use DateTimeZone;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Format a price according to the currency settings.
     *
     * @param float $amount
     * @param string $currencyCode
     * @return string
     */
    public static function formatPrice($amount, $currencyCode)
    {
        // Retrieve currency settings from the database
        $currency = Currency::where('code', $currencyCode)->firstOrFail();

        // Extract currency settings
        $symbol = $currency->symbol;
        $symbolLocation = $currency->symbol_location;
        $thousandSep = $currency->thousand_sep;
        $decimalSep = $currency->decimal_sep;
        $decimalNumber = $currency->decimal_number;

        // Format the amount
        $formattedAmount = number_format($amount, $decimalNumber, $decimalSep, $thousandSep);

        // Place the symbol according to the symbol_location setting
        if ($symbolLocation == 'left') {
            return $symbol . $formattedAmount;
        } elseif ($symbolLocation == 'left_space') {
            return $symbol . ' ' . $formattedAmount;
        } elseif ($symbolLocation == 'right') {
            return $formattedAmount . $symbol;
        } elseif ($symbolLocation == 'right_space') {
            return $formattedAmount . ' ' . $symbol;
        }

        return $formattedAmount;
    }

}
