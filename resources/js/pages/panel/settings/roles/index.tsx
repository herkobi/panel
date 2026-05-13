import { Form, Head, Link } from '@inertiajs/react';
import { Eye, RotateCcw, Search, ShieldCheck } from 'lucide-react';
import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button, buttonVariants } from '@/components/ui/button';
import {
    Empty,
    EmptyDescription,
    EmptyHeader,
    EmptyMedia,
    EmptyTitle,
} from '@/components/ui/empty';
import { Input } from '@/components/ui/input';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { cn } from '@/lib/utils';
import { dashboard } from '@/routes';
import {
    create as createRole,
    index,
    show,
} from '@/routes/panel/settings/roles';
import type { Paginated, PaginationLink } from '@/types';

type RoleItem = {
    uuid: string;
    name: string;
    is_system: boolean;
    permissions_count: number;
    users_count: number;
    created_at: string;
};

type RolesPaginator = Omit<Paginated<RoleItem>, 'links' | 'meta'> & {
    links:
        | PaginationLink[]
        | {
              first: string | null;
              last: string | null;
              prev: string | null;
              next: string | null;
          };
    meta?: Paginated<RoleItem>['meta'] & {
        links?: PaginationLink[];
    };
};

type Props = {
    roles: RolesPaginator;
    filters: {
        q?: string;
    };
};

function paginationLinks(roles: RolesPaginator): PaginationLink[] {
    if (Array.isArray(roles.links)) {
        return roles.links;
    }

    return roles.meta?.links ?? [];
}

function paginationLabel(label: string): string {
    return label.replace('&laquo;', '').replace('&raquo;', '').trim();
}

function isPreviousPaginationLink(label: string): boolean {
    return (
        label.includes('Previous') ||
        label.includes('Önceki') ||
        label.includes('&laquo;')
    );
}

function isNextPaginationLink(label: string): boolean {
    return (
        label.includes('Next') ||
        label.includes('Sonraki') ||
        label.includes('&raquo;')
    );
}

export default function Roles({ roles, filters }: Props) {
    const pageLinks = paginationLinks(roles);

    return (
        <>
            <Head title="Roller ve Yetkiler" />

            <div className="flex flex-col gap-6">
                <div className="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <Heading
                        variant="small"
                        title="Roller ve Yetkiler"
                        description="Sistem rollerini görüntüleyin, yeni rol oluşturun ve izin atayın."
                    />

                    <div className="flex w-full flex-col gap-2 sm:max-w-md sm:flex-row">
                        <Form
                            {...index.form()}
                            className="flex w-full flex-col gap-2 sm:flex-row"
                        >
                            <div className="relative min-w-0 flex-1">
                                <Search className="pointer-events-none absolute top-1/2 left-3 -translate-y-1/2 text-muted-foreground" />
                                <Input
                                    name="q"
                                    defaultValue={filters.q ?? ''}
                                    placeholder="Rol ara"
                                    className="pl-9"
                                />
                            </div>
                            <div className="flex gap-2">
                                <Button type="submit">Filtrele</Button>
                                {(filters.q ?? '') !== '' && (
                                    <Button asChild variant="outline">
                                        <Link href={index()}>
                                            <RotateCcw />
                                        </Link>
                                    </Button>
                                )}
                            </div>
                        </Form>
                        <Button asChild>
                            <Link href={createRole()}>Yeni Rol</Link>
                        </Button>
                    </div>
                </div>

                <div className="flex flex-col gap-4">
                    {roles.data.length === 0 ? (
                        <Empty>
                            <EmptyHeader>
                                <EmptyMedia variant="icon">
                                    <ShieldCheck />
                                </EmptyMedia>
                                <EmptyTitle>Rol bulunamadı</EmptyTitle>
                                <EmptyDescription>
                                    Seçili filtreye uygun rol yok.
                                </EmptyDescription>
                            </EmptyHeader>
                        </Empty>
                    ) : (
                        <>
                            <div className="overflow-hidden rounded-lg border">
                                <Table>
                                    <TableHeader>
                                        <TableRow>
                                            <TableHead>Rol</TableHead>
                                            <TableHead>İzin sayısı</TableHead>
                                            <TableHead>
                                                Kullanıcı sayısı
                                            </TableHead>
                                            <TableHead className="text-right">
                                                İşlem
                                            </TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        {roles.data.map((role) => (
                                            <TableRow key={role.uuid}>
                                                <TableCell>
                                                    <div className="flex flex-wrap items-center gap-2">
                                                        <span className="font-medium">
                                                            {role.name}
                                                        </span>
                                                        {role.is_system && (
                                                            <Badge variant="secondary">
                                                                Sistem
                                                            </Badge>
                                                        )}
                                                    </div>
                                                </TableCell>
                                                <TableCell>
                                                    {role.permissions_count}
                                                </TableCell>
                                                <TableCell>
                                                    {role.users_count}
                                                </TableCell>
                                                <TableCell className="text-right">
                                                    <Button
                                                        asChild
                                                        size="sm"
                                                        variant="outline"
                                                    >
                                                        <Link
                                                            href={show(
                                                                role.uuid,
                                                            )}
                                                        >
                                                            <Eye data-icon="inline-start" />
                                                            Düzenle
                                                        </Link>
                                                    </Button>
                                                </TableCell>
                                            </TableRow>
                                        ))}
                                    </TableBody>
                                </Table>
                            </div>

                            <div className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div className="text-sm text-muted-foreground">
                                    {roles.meta?.from ?? 0}-
                                    {roles.meta?.to ?? 0} arası gösteriliyor.
                                    Toplam {roles.meta?.total ?? 0} kayıt.
                                </div>
                                <div className="flex flex-wrap items-center gap-1">
                                    {pageLinks.map((link, idx) => {
                                        if (
                                            isPreviousPaginationLink(link.label)
                                        ) {
                                            return (
                                                <Link
                                                    key={idx}
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

                                        if (isNextPaginationLink(link.label)) {
                                            return (
                                                <Link
                                                    key={idx}
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

                                        const label = paginationLabel(
                                            link.label,
                                        );

                                        if (label === '...') {
                                            return (
                                                <span
                                                    key={idx}
                                                    className="flex size-8 items-center justify-center text-sm text-muted-foreground"
                                                >
                                                    ...
                                                </span>
                                            );
                                        }

                                        return (
                                            <Link
                                                key={idx}
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
                                                {label}
                                            </Link>
                                        );
                                    })}
                                </div>
                            </div>
                        </>
                    )}
                </div>
            </div>
        </>
    );
}

Roles.layout = {
    breadcrumbs: [
        {
            title: 'Roller ve Yetkiler',
            href: dashboard(),
        },
    ],
};
