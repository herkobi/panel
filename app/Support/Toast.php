<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Flash toast payload helper.
 *
 * Inertia tarafının beklediği `{type, message}` yapısını tek noktadan üretir.
 * Mesajlar `__()` ile sarılır; çeviri dosyasında karşılığı yoksa anahtar olduğu
 * gibi döner.
 */
class Toast
{
    /**
     * Frontend `FlashToast.type` ile aynı set: success | info | warning | error.
     *
     * @return array{type: string, message: string}
     */
    public static function success(string $message): array
    {
        return self::make('success', $message);
    }

    /**
     * @return array{type: string, message: string}
     */
    public static function info(string $message): array
    {
        return self::make('info', $message);
    }

    /**
     * @return array{type: string, message: string}
     */
    public static function warning(string $message): array
    {
        return self::make('warning', $message);
    }

    /**
     * @return array{type: string, message: string}
     */
    public static function error(string $message): array
    {
        return self::make('error', $message);
    }

    /**
     * @return array{type: string, message: string}
     */
    private static function make(string $type, string $message): array
    {
        return ['type' => $type, 'message' => __($message)];
    }
}
