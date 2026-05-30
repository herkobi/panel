import {
    Activity,
    BookMarked,
    Bolt,
    LayoutGrid,
    ScanText,
    SquareUser,
    UserRound,
    Users,
} from 'lucide-react';
import type { LucideIcon } from 'lucide-react';

/**
 * Backend (MenuRegistry) ikonu string anahtar olarak gönderir; React burada
 * Lucide bileşenine çözer. Böylece PHP↔JS sınırından bileşen referansı geçmez.
 *
 * Modüller yeni bir ikon kullanmak istediğinde anahtarını buraya ekler.
 */
export const navigationIcons: Record<string, LucideIcon> = {
    activity: Activity,
    bookMarked: BookMarked,
    bolt: Bolt,
    layoutGrid: LayoutGrid,
    scanText: ScanText,
    squareUser: SquareUser,
    userRound: UserRound,
    users: Users,
};

/**
 * String anahtarı veya doğrudan verilen bileşeni Lucide bileşenine çözer.
 */
export function resolveNavIcon(
    icon: string | LucideIcon | null | undefined,
): LucideIcon | null {
    if (!icon) {
        return null;
    }

    if (typeof icon !== 'string') {
        return icon;
    }

    return navigationIcons[icon] ?? null;
}
