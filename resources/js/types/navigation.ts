import type { InertiaLinkProps } from '@inertiajs/react';
import type { LucideIcon } from 'lucide-react';

export type BreadcrumbItem = {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
};

/**
 * Sidebar menü öğesi. Menü backend'deki `MenuRegistry`'den `navigation`
 * paylaşılan prop'u olarak gelir; bu yüzden `icon` bir string anahtar olabilir
 * (React tarafında Lucide bileşenine çözülür). Doğrudan bileşen geçilmesi de
 * (eski/yerel kullanım) desteklenir.
 */
export type NavItem = {
    key?: string;
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: string | LucideIcon | null;
    permission?: string | null;
    order?: number;
    isActive?: boolean;
    items?: NavItem[];
};

/**
 * `navigation` paylaşılan prop'undaki bir menü grubu (Platform / Araçlar / …).
 */
export type NavigationGroup = {
    key: string;
    label: string;
    order: number;
    items: NavItem[];
};

export type TeamItem = {
    name: string;
    href: NonNullable<InertiaLinkProps['href']>;
    logo: LucideIcon;
    plan: string;
};
