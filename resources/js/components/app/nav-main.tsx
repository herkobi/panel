import { Link } from '@inertiajs/react';
import { ChevronRight } from 'lucide-react';
import { createElement } from 'react';
import type { ReactNode } from 'react';

import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from '@/components/ui/collapsible';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
    useSidebar,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/hooks/use-current-url';
import { resolveNavIcon } from '@/lib/navigation-icons';
import type { NavItem } from '@/types';

// Icon string anahtarını Lucide bileşenine çözüp createElement ile render eder.
// (Bileşeni render sırasında bir değişkene atayıp <Icon /> yazmak react-hooks
// kuralını tetiklediği için createElement kullanılır.)
function renderNavIcon(icon: NavItem['icon']): ReactNode {
    const resolved = resolveNavIcon(icon);

    return resolved ? createElement(resolved) : null;
}

export function NavMain({
    label,
    items = [],
}: {
    label: string;
    items: NavItem[];
}) {
    const { isCurrentUrl } = useCurrentUrl();
    const { state, isMobile } = useSidebar();
    const isCollapsed = state === 'collapsed' && !isMobile;

    const isItemActive = (item: NavItem): boolean => {
        return item.isActive === true || isCurrentUrl(item.href);
    };

    return (
        <SidebarGroup>
            <SidebarGroupLabel>{label}</SidebarGroupLabel>

            <SidebarMenu>
                {items.map((item) => {
                    const hasChildren = item.items && item.items.length > 0;
                    const key = item.key ?? item.title;

                    if (!hasChildren) {
                        return (
                            <SidebarMenuItem key={key}>
                                <SidebarMenuButton
                                    asChild
                                    isActive={isItemActive(item)}
                                    tooltip={{ children: item.title }}
                                >
                                    <Link href={item.href} prefetch>
                                        {renderNavIcon(item.icon)}
                                        <span>{item.title}</span>
                                    </Link>
                                </SidebarMenuButton>
                            </SidebarMenuItem>
                        );
                    }

                    const isActive =
                        isItemActive(item) ||
                        item.items?.some((subItem) => isItemActive(subItem)) ===
                            true;

                    // Sidebar ikon moduna küçüldüğünde alt menüler flyout
                    // (yana açılan) dropdown olarak gösterilir; aksi halde
                    // tekrar genişletmeden alt menülere erişilemezdi.
                    if (isCollapsed) {
                        return (
                            <SidebarMenuItem key={key}>
                                <DropdownMenu>
                                    <DropdownMenuTrigger asChild>
                                        <SidebarMenuButton
                                            isActive={isActive}
                                            tooltip={{ children: item.title }}
                                        >
                                            {renderNavIcon(item.icon)}
                                            <span>{item.title}</span>
                                            <ChevronRight className="ml-auto" />
                                        </SidebarMenuButton>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent
                                        side="right"
                                        align="start"
                                        className="min-w-48"
                                    >
                                        <DropdownMenuLabel>
                                            {item.title}
                                        </DropdownMenuLabel>
                                        <DropdownMenuSeparator />
                                        {item.items?.map((subItem) => (
                                            <DropdownMenuItem
                                                key={
                                                    subItem.key ?? subItem.title
                                                }
                                                asChild
                                            >
                                                <Link
                                                    href={subItem.href}
                                                    prefetch
                                                >
                                                    {subItem.title}
                                                </Link>
                                            </DropdownMenuItem>
                                        ))}
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </SidebarMenuItem>
                        );
                    }

                    return (
                        <Collapsible
                            key={key}
                            asChild
                            defaultOpen={isActive}
                            className="group/collapsible"
                        >
                            <SidebarMenuItem>
                                <CollapsibleTrigger asChild>
                                    <SidebarMenuButton
                                        isActive={isActive}
                                        tooltip={{ children: item.title }}
                                    >
                                        {renderNavIcon(item.icon)}
                                        <span>{item.title}</span>
                                        <ChevronRight className="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />
                                    </SidebarMenuButton>
                                </CollapsibleTrigger>

                                <CollapsibleContent>
                                    <SidebarMenuSub>
                                        {item.items?.map((subItem) => (
                                            <SidebarMenuSubItem
                                                key={
                                                    subItem.key ?? subItem.title
                                                }
                                            >
                                                <SidebarMenuSubButton
                                                    asChild
                                                    isActive={isItemActive(
                                                        subItem,
                                                    )}
                                                >
                                                    <Link
                                                        href={subItem.href}
                                                        prefetch
                                                    >
                                                        <span>
                                                            {subItem.title}
                                                        </span>
                                                    </Link>
                                                </SidebarMenuSubButton>
                                            </SidebarMenuSubItem>
                                        ))}
                                    </SidebarMenuSub>
                                </CollapsibleContent>
                            </SidebarMenuItem>
                        </Collapsible>
                    );
                })}
            </SidebarMenu>
        </SidebarGroup>
    );
}
