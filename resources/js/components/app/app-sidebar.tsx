import { GalleryVerticalEnd, LayoutGrid, UserRound } from 'lucide-react';
import type { ComponentProps } from 'react';
import { NavMain } from '@/components/app/nav-main';
import { NavUser } from '@/components/app/nav-user';
import { TeamSwitcher } from '@/components/app/team-switcher';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarRail,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes/app';
import { account } from '@/routes/app';
import type { NavItem } from '@/types';

const teams = [
    {
        name: 'Uygulama',
        logo: GalleryVerticalEnd,
        plan: 'Kullanıcı Alanı',
        href: dashboard(),
    },
];

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
                <TeamSwitcher teams={teams} />
            </SidebarHeader>

            <SidebarContent>
                <NavMain label="Platform" items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavUser />
            </SidebarFooter>

            <SidebarRail />
        </Sidebar>
    );
}
