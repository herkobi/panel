import { Form, Head, Link } from '@inertiajs/react';
import { Eye, RotateCcw, Search, UserCog } from 'lucide-react';
import { DataPagination } from '@/components/data-pagination';
import Heading from '@/components/heading';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
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
import { usePanelAuth } from '@/hooks/use-panel-auth';
import { dashboard } from '@/routes';
import { edit as profileEdit } from '@/routes/panel/profile';
import { index, show } from '@/routes/panel/settings/users';
import type { Paginated, PanelUser } from '@/types';

type Props = {
    users: Paginated<PanelUser>;
    filters: {
        q?: string;
    };
};

function formatDate(value: string | null | undefined): string {
    if (!value) {
        return '-';
    }

    return new Date(value).toLocaleString('tr-TR');
}

function initials(name: string): string {
    return name
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part[0])
        .join('')
        .toLocaleUpperCase('tr-TR');
}

function statusLabel(status: PanelUser['status']): string {
    switch (status) {
        case 'active':
            return 'Aktif';
        case 'passive':
            return 'Pasif';
        case 'draft':
            return 'Kısıtlı';
        default:
            return String(status);
    }
}

function statusVariant(
    status: PanelUser['status'],
): 'default' | 'secondary' | 'destructive' | 'outline' {
    switch (status) {
        case 'active':
            return 'default';
        case 'passive':
            return 'destructive';
        case 'draft':
            return 'secondary';
        default:
            return 'outline';
    }
}

export default function Users({ users, filters }: Props) {
    const { user: authUser } = usePanelAuth();

    return (
        <>
            <Head title="Kullanıcılar" />

            <div className="flex flex-col gap-6">
                <div className="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <Heading
                        variant="small"
                        title="Panel Kullanıcıları"
                        description="Yönetici hesaplarını, erişim durumlarını ve son hareketlerini izleyin."
                    />

                    <Form
                        {...index.form()}
                        className="flex w-full flex-col gap-2 sm:max-w-md sm:flex-row"
                    >
                        <div className="relative min-w-0 flex-1">
                            <Search className="pointer-events-none absolute top-1/2 left-3 -translate-y-1/2 text-muted-foreground" />
                            <Input
                                name="q"
                                defaultValue={filters.q ?? ''}
                                placeholder="Ad veya e-posta ara"
                                className="pl-9"
                            />
                        </div>
                        <div className="flex gap-2">
                            <Button type="submit">
                                <Search data-icon="inline-start" />
                                Filtrele
                            </Button>
                            {(filters.q ?? '') !== '' && (
                                <Button asChild variant="outline">
                                    <Link href={index()}>
                                        <RotateCcw data-icon="inline-start" />
                                        Sıfırla
                                    </Link>
                                </Button>
                            )}
                        </div>
                    </Form>
                </div>

                <div className="flex flex-col gap-4">
                    {users.data.length === 0 ? (
                        <Empty>
                            <EmptyHeader>
                                <EmptyMedia variant="icon">
                                    <UserCog />
                                </EmptyMedia>
                                <EmptyTitle>Kullanıcı bulunamadı</EmptyTitle>
                                <EmptyDescription>
                                    Seçili filtreye uygun yönetici hesabı yok.
                                </EmptyDescription>
                            </EmptyHeader>
                        </Empty>
                    ) : (
                        <>
                            <div className="overflow-hidden rounded-lg border">
                                <Table>
                                    <TableHeader>
                                        <TableRow>
                                            <TableHead>Kullanıcı</TableHead>
                                            <TableHead>Durum</TableHead>
                                            <TableHead>Son giriş</TableHead>
                                            <TableHead>Kayıt tarihi</TableHead>
                                            <TableHead className="text-right">
                                                İşlem
                                            </TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        {users.data.map((user) => {
                                            const isCurrentUser =
                                                authUser?.id === user.id;
                                            const href = isCurrentUser
                                                ? profileEdit()
                                                : show(user);

                                            return (
                                                <TableRow key={user.id}>
                                                    <TableCell>
                                                        <div className="flex min-w-0 items-center gap-3">
                                                            <Avatar size="lg">
                                                                <AvatarFallback>
                                                                    {initials(
                                                                        user.name,
                                                                    )}
                                                                </AvatarFallback>
                                                            </Avatar>
                                                            <div className="min-w-0">
                                                                <div className="truncate font-medium">
                                                                    {user.name}
                                                                </div>
                                                                <div className="truncate text-sm text-muted-foreground">
                                                                    {user.email}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </TableCell>
                                                    <TableCell>
                                                        <div className="flex flex-wrap items-center gap-2">
                                                            <Badge variant="secondary">
                                                                {user
                                                                    .roles?.[0] ??
                                                                    'Rolsüz'}
                                                            </Badge>
                                                            <Badge
                                                                variant={statusVariant(
                                                                    user.status,
                                                                )}
                                                            >
                                                                {statusLabel(
                                                                    user.status,
                                                                )}
                                                            </Badge>
                                                        </div>
                                                    </TableCell>
                                                    <TableCell>
                                                        {formatDate(
                                                            user.last_login_at as
                                                                | string
                                                                | null
                                                                | undefined,
                                                        )}
                                                    </TableCell>
                                                    <TableCell>
                                                        {formatDate(
                                                            user.created_at,
                                                        )}
                                                    </TableCell>
                                                    <TableCell className="text-right">
                                                        <Button
                                                            asChild
                                                            size="sm"
                                                            variant={
                                                                isCurrentUser
                                                                    ? 'secondary'
                                                                    : 'outline'
                                                            }
                                                        >
                                                            <Link href={href}>
                                                                <Eye data-icon="inline-start" />
                                                                {isCurrentUser
                                                                    ? 'Profilim'
                                                                    : 'Görüntüle'}
                                                            </Link>
                                                        </Button>
                                                    </TableCell>
                                                </TableRow>
                                            );
                                        })}
                                    </TableBody>
                                </Table>
                            </div>

                            <DataPagination paginator={users} />
                        </>
                    )}
                </div>
            </div>
        </>
    );
}

Users.layout = {
    breadcrumbs: [
        {
            title: 'Kullanıcılar',
            href: dashboard(),
        },
    ],
};
