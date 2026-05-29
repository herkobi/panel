import { LayoutGrid, UserRound } from 'lucide-react';
import type { ComponentProps } from 'react';
import { NavMain } from '@/components/app/nav-main';
import { NavUser } from '@/components/app/nav-user';
import { BrandHeader } from '@/components/brand-header';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes/app';
import { account } from '@/routes/app';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Başlangıç',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Hesabım',
        href: '#',
        icon: UserRound,
        items: [
            {
                title: 'Hesabım',
                href: account(),
            },
        ],
    },
];

export function AppSidebar({ ...props }: ComponentProps<typeof Sidebar>) {
    return (
        <Sidebar collapsible="icon" {...props}>
            <SidebarHeader>
                <BrandHeader href={dashboard()} />
            </SidebarHeader>

            <SidebarContent>
                <NavMain label="Platform" items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
