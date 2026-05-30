import { usePage } from '@inertiajs/react';
import type { ComponentProps } from 'react';
import { BrandHeader } from '@/components/brand-header';
import { NavMain } from '@/components/panel/nav-main';
import { NavUser } from '@/components/panel/nav-user';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes/panel';

export function AppSidebar({ ...props }: ComponentProps<typeof Sidebar>) {
    const { navigation = [] } = usePage().props;

    return (
        <Sidebar collapsible="icon" {...props}>
            <SidebarHeader>
                <BrandHeader href={dashboard()} />
            </SidebarHeader>

            <SidebarContent>
                {navigation.map((group) => (
                    <NavMain
                        key={group.key}
                        label={group.label}
                        items={group.items}
                    />
                ))}
            </SidebarContent>

            <SidebarFooter>
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
