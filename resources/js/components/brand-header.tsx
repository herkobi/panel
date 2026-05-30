import { Link } from '@inertiajs/react';
import type { InertiaLinkProps } from '@inertiajs/react';

import {
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { useBranding } from '@/hooks/use-branding';

/**
 * Sidebar başlığındaki marka alanı: genel ayarlardan gelen favicon + uygulama
 * adı. Tek kaynak [[Branding]] helper'ı; collapsed modda yalnız favicon görünür.
 */
export function BrandHeader({
    href,
}: {
    href: NonNullable<InertiaLinkProps['href']>;
}) {
    const branding = useBranding();

    return (
        <SidebarMenu>
            <SidebarMenuItem>
                <SidebarMenuButton size="lg" asChild>
                    <Link href={href} prefetch>
                        <div className="flex aspect-square size-8 items-center justify-center overflow-hidden">
                            <img
                                src={branding.favicon}
                                alt={branding.name}
                                className="size-full object-contain"
                            />
                        </div>

                        <div className="grid flex-1 text-left text-sm leading-tight">
                            <span className="truncate font-semibold">
                                {branding.name}
                            </span>
                            {branding.slogan && (
                                <span className="truncate text-xs text-muted-foreground">
                                    {branding.slogan}
                                </span>
                            )}
                        </div>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    );
}
