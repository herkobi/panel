<?php

namespace App\Support;

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
     * Örnek Kullanım: Helper::shortString($post->body,0,40)
     * Girilen içeriğin başlangıçtan kırkıncı karaktere kadar olan bölümünü alır
     * Kaynak: https://blog.corelux.com.tr/laravelde-kendi-helper-sinifimizi-olusturmak
     */
    public static function shortString(string $string, int $start = 0, int $end = 35): string
    {
        return mb_substr($string, $start, $end, 'UTF-8') . '...';
    }
}
