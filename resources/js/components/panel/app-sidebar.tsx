import {
    LayoutGrid,
    Bolt,
    Users,
    SquareUser,
    Activity,
    ScanText,
    BookMarked,
} from 'lucide-react';
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
import {
    create as createMember,
    index as members,
} from '@/routes/panel/members';
import { edit as general } from '@/routes/panel/settings/general';
import { index as permissions } from '@/routes/panel/settings/permissions';
import { index as roles } from '@/routes/panel/settings/roles';
import {
    create as createUser,
    index as users,
} from '@/routes/panel/settings/users';
import { activity, cache } from '@/routes/panel/tools';
import { index as countries } from '@/routes/panel/tools/definitions/countries';
import { index as currencies } from '@/routes/panel/tools/definitions/currencies';
import { index as languages } from '@/routes/panel/tools/definitions/languages';
import { index as taxes } from '@/routes/panel/tools/definitions/taxes';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Başlangıç',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Üyeler',
        href: '#',
        icon: Users,
        items: [
            {
                title: 'Üyeler',
                href: members(),
            },
            {
                title: 'Yeni Üye',
                href: createMember(),
            },
        ],
    },
];
const toolsNavItems: NavItem[] = [
    {
        title: 'Etkinlik Kayıtları',
        href: activity(),
        icon: Activity,
    },
    {
        title: 'Ön Bellek Yönetimi',
        href: cache(),
        icon: ScanText,
    },
    {
        title: 'Tanımlamalar',
        href: '#',
        icon: BookMarked,
        items: [
            {
                title: 'Diller',
                href: languages(),
            },
            {
                title: 'Bölgeler',
                href: countries(),
            },
            {
                title: 'Para Birimleri',
                href: currencies(),
            },
            {
                title: 'Vergi Oranları',
                href: taxes(),
            },
        ],
    },
];
const settingsNavItems: NavItem[] = [
    {
        title: 'Genel Ayarlar',
        href: general(),
        icon: Bolt,
    },
    {
        title: 'Kullanıcılar',
        href: '#',
        icon: SquareUser,
        items: [
            {
                title: 'Kullanıcılar',
                href: users(),
            },
            {
                title: 'Kullanıcı Ekle',
                href: createUser(),
            },
            {
                title: 'Roller',
                href: roles(),
            },
            {
                title: 'Yetkiler',
                href: permissions(),
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
                <NavMain label="Araçlar" items={toolsNavItems} />
                <NavMain label="Ayarlar" items={settingsNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
