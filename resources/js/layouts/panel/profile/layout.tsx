import { Link } from '@inertiajs/react';
import type { PropsWithChildren } from 'react';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { useCurrentUrl } from '@/hooks/use-current-url';
import { cn } from '@/lib/utils';
import {
    edit,
    notifications,
    security,
    sessions,
} from '@/routes/panel/profile';
import { edit as editAppearance } from '@/routes/panel/profile/appearance';

import type { NavItem } from '@/types';

const sidebarNavItems: NavItem[] = [
    {
        title: 'Bilgilerim',
        href: edit(),
        icon: null,
    },
    {
        title: 'Bildirimler',
        href: notifications(),
        icon: null,
    },
    {
        title: 'Oturum Kayıtları',
        href: sessions(),
        icon: null,
    },
    {
        title: 'Güvenlik',
        href: security(),
        icon: null,
    },
    {
        title: 'Tercihler',
        href: editAppearance(),
        icon: null,
    },
];

export default function PanelProfileLayout({ children }: PropsWithChildren) {
    const { isCurrentUrl } = useCurrentUrl();

    return (
        <div className="px-4 py-6">
            <Heading
                title="Bilgilerim"
                description="Profil bilgilerinizi ve hesap ayarlarınızı yönetin"
            />

            <div className="flex flex-col lg:flex-row lg:space-x-12">
                <aside className="w-full max-w-xl lg:w-48">
                    <nav
                        className="flex flex-col space-y-1 space-x-0"
                        aria-label="Profile"
                    >
                        {sidebarNavItems.map((item, index) => (
                            <Button
                                key={`${item.href}-${index}`}
                                size="sm"
                                variant="ghost"
                                asChild
                                className={cn('w-full justify-start', {
                                    'bg-muted': isCurrentUrl(item.href),
                                })}
                            >
                                <Link href={item.href}>
                                    {item.icon && (
                                        <item.icon className="h-4 w-4" />
                                    )}
                                    {item.title}
                                </Link>
                            </Button>
                        ))}
                    </nav>
                </aside>

                <Separator className="my-6 lg:hidden" />

                <div className="flex-1">
                    <section className="space-y-12">{children}</section>
                </div>
            </div>
        </div>
    );
}
