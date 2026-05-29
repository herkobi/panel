import { usePage } from '@inertiajs/react';
import type { Branding } from '@/types/global';

/**
 * Genel ayarlardan beslenen marka bilgisini (ad, slogan, logo, favicon)
 * döndürür. Değerler `HandleInertiaRequests` ile her sayfada paylaşılır.
 */
export function useBranding(): Branding {
    return usePage().props.branding;
}
