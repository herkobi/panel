<?php

namespace App\Utils;

use App\Models\Currency;
use DateTimeZone;
use Illuminate\Support\Facades\Cache;

class Helper
{
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

}
