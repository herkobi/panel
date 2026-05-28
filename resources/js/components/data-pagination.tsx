import { Link } from '@inertiajs/react';

import { buttonVariants } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import type { Paginated, PaginationLink } from '@/types/pagination';

type DataPaginationProps<T> = {
    paginator: Paginated<T>;
    label?: string;
    showRange?: boolean;
    className?: string;
};

function cleanLabel(label: string): string {
    return label.replaceAll('&laquo;', '').replaceAll('&raquo;', '').trim();
}

function isPrev(label: string): boolean {
    const n = cleanLabel(label).toLowerCase();

    return n.includes('previous') || n.includes('önceki');
}

function isNext(label: string): boolean {
    const n = cleanLabel(label).toLowerCase();

    return n.includes('next') || n.includes('sonraki');
}

export function DataPagination<T>({
    paginator,
    label = 'kayıt',
    showRange = true,
    className,
}: DataPaginationProps<T>) {
    const total = paginator.meta?.total ?? paginator.total ?? 0;

    if (total === 0) {
        return null;
    }

    const from = paginator.meta?.from ?? paginator.from ?? 0;
    const to = paginator.meta?.to ?? paginator.to ?? 0;
    const lastPage = paginator.meta?.last_page ?? paginator.last_page ?? 1;
    const links: PaginationLink[] =
        paginator.meta?.links ?? paginator.links ?? [];
    const hasMultiplePages = lastPage > 1;

    return (
        <div
            className={cn(
                'flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between',
                className,
            )}
        >
            <div className="text-sm text-muted-foreground">
                {showRange && `${from ?? 0}-${to ?? 0} arası gösteriliyor. `}
                Toplam {total} {label}.
            </div>

            {hasMultiplePages && (
                <div className="flex flex-wrap items-center gap-1">
                    {links.map((link, index) => {
                        if (isPrev(link.label)) {
                            return (
                                <Link
                                    key={index}
                                    href={link.url ?? '#'}
                                    className={cn(
                                        buttonVariants({
                                            variant: 'ghost',
                                            size: 'sm',
                                        }),
                                        !link.url &&
                                            'pointer-events-none opacity-50',
                                    )}
                                >
                                    Önceki
                                </Link>
                            );
                        }

                        if (isNext(link.label)) {
                            return (
                                <Link
                                    key={index}
                                    href={link.url ?? '#'}
                                    className={cn(
                                        buttonVariants({
                                            variant: 'ghost',
                                            size: 'sm',
                                        }),
                                        !link.url &&
                                            'pointer-events-none opacity-50',
                                    )}
                                >
                                    Sonraki
                                </Link>
                            );
                        }

                        const text = cleanLabel(link.label);

                        if (text === '...') {
                            return (
                                <span
                                    key={index}
                                    className="flex size-8 items-center justify-center text-sm text-muted-foreground"
                                >
                                    ...
                                </span>
                            );
                        }

                        return (
                            <Link
                                key={index}
                                href={link.url ?? '#'}
                                className={cn(
                                    buttonVariants({
                                        variant: link.active
                                            ? 'outline'
                                            : 'ghost',
                                        size: 'icon-sm',
                                    }),
                                    !link.url &&
                                        'pointer-events-none opacity-50',
                                )}
                            >
                                {text}
                            </Link>
                        );
                    })}
                </div>
            )}
        </div>
    );
}
