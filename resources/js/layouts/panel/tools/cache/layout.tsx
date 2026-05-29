import { Link } from '@inertiajs/react';
import type { PropsWithChildren } from 'react';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { useActiveNavHref } from '@/hooks/use-current-url';
import { cn, toUrl } from '@/lib/utils';
import { cache } from '@/routes/panel/tools';
import type { NavItem } from '@/types';

const sidebarNavItems: NavItem[] = [
    {
        title: 'Önbellek Yönetimi',
        href: cache(),
        icon: null,
    },
];

export default function PanelCacheLayout({ children }: PropsWithChildren) {
    const activeHref = useActiveNavHref(
        sidebarNavItems.map((item) => item.href),
    );

    return (
        <div className="px-4 py-6">
            <Heading
                title="Önbellek Yönetimi"
                description="Önbellek ayarlarınızı ve performansınızı yönetin"
            />

            <div className="flex flex-col lg:flex-row lg:space-x-12">
                <aside className="w-full max-w-xl lg:w-48">
                    <nav
                        className="flex flex-col space-y-1 space-x-0"
                        aria-label="Cache"
                    >
                        {sidebarNavItems.map((item, index) => (
                            <Button
                                key={`${item.href}-${index}`}
                                size="sm"
                                variant="ghost"
                                asChild
                                className={cn('w-full justify-start', {
                                    'bg-muted': toUrl(item.href) === activeHref,
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
