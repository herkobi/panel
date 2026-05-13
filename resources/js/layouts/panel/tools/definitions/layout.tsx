import { Link } from '@inertiajs/react';
import type { PropsWithChildren } from 'react';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { useCurrentUrl } from '@/hooks/use-current-url';
import { cn } from '@/lib/utils';
import { index as countriesIndex } from '@/routes/panel/tools/definitions/countries';
import { index as currenciesIndex } from '@/routes/panel/tools/definitions/currencies';
import { index as languagesIndex } from '@/routes/panel/tools/definitions/languages';
import { index as taxesIndex } from '@/routes/panel/tools/definitions/taxes';
import type { NavItem } from '@/types';

const sidebarNavItems: NavItem[] = [
    {
        title: 'Diller',
        href: languagesIndex(),
        icon: null,
    },
    {
        title: 'Bölgeler',
        href: countriesIndex(),
        icon: null,
    },
    {
        title: 'Para Birimleri',
        href: currenciesIndex(),
        icon: null,
    },
    {
        title: 'Vergi Oranları',
        href: taxesIndex(),
        icon: null,
    },
];

export default function PanelDefinitionsLayout({
    children,
}: PropsWithChildren) {
    const { isCurrentOrParentUrl } = useCurrentUrl();

    return (
        <div className="px-4 py-6">
            <Heading
                title="Tanımlamalar"
                description="Sistem genelinde kullanılan tanımlama bilgilerini yönetin"
            />

            <div className="flex flex-col lg:flex-row lg:space-x-12">
                <aside className="w-full max-w-xl lg:w-48">
                    <nav
                        className="flex flex-col space-y-1 space-x-0"
                        aria-label="Definitions"
                    >
                        {sidebarNavItems.map((item, index) => (
                            <Button
                                key={`${item.href}-${index}`}
                                size="sm"
                                variant="ghost"
                                asChild
                                className={cn('w-full justify-start', {
                                    'bg-muted': isCurrentOrParentUrl(item.href),
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
