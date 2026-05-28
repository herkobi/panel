import type { PageProps as InertiaPageProps } from '@inertiajs/core';
import { Head, useForm, usePage } from '@inertiajs/react';
import {
    Activity as ActivityIcon,
    ChevronDownIcon,
    RotateCcw,
    Search,
} from 'lucide-react';
import { DataPagination } from '@/components/data-pagination';
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
import { dashboard } from '@/routes';
import { activity } from '@/routes/panel/tools';
import type {
    Activity,
    ActivityFilters,
    ActivitySubjectTypeOption,
} from '@/types/activity';
import type { Paginated } from '@/types/pagination';

type PageProps = InertiaPageProps & {
    activities: Paginated<Activity>;
    filters: ActivityFilters;
    users: { id: string; name: string }[];
    subject_types: ActivitySubjectTypeOption[];
};

function getEventVariant(
    event: string | null,
): 'default' | 'secondary' | 'destructive' | 'outline' {
    switch (event) {
        case 'created':
            return 'default';
        case 'updated':
            return 'secondary';
        case 'deleted':
            return 'destructive';
        default:
            return 'outline';
    }
}

function getEventLabel(event: string | null): string {
    switch (event) {
        case 'created':
            return 'Oluşturuldu';
        case 'updated':
            return 'Güncellendi';
        case 'deleted':
            return 'Silindi';
        default:
            return event ?? '-';
    }
}

export default function ActivityIndex() {
    const { activities, filters, users, subject_types } =
        usePage<PageProps>().props;

    const form = useForm<ActivityFilters>({
        user_id: filters.user_id,
        subject_type: filters.subject_type,
        causer_id: filters.causer_id,
        from: filters.from,
        to: filters.to,
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        form.get(activity({ query: form.data }).url);
    };

    const handleReset = () => {
        form.reset();
        form.get(activity().url);
    };

    return (
        <>
            <Head title="Etkinlik Kayıtları" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl">
                <form
                    onSubmit={handleSubmit}
                    className="grid grid-cols-1 items-end gap-3 sm:grid-cols-2 lg:grid-cols-5"
                >
                    <div className="flex flex-col gap-1.5">
                        <label
                            htmlFor="causer_id"
                            className="text-sm font-medium"
                        >
                            Kullanıcı
                        </label>
                        <div className="relative w-full">
                            <select
                                id="causer_id"
                                value={form.data.causer_id}
                                onChange={(e) =>
                                    form.setData('causer_id', e.target.value)
                                }
                                className="h-9 w-full min-w-0 appearance-none rounded-md border border-input bg-transparent px-3 py-2 pr-9 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 disabled:pointer-events-none disabled:cursor-not-allowed dark:bg-input/30 dark:hover:bg-input/50"
                            >
                                <option value="">Tümü</option>
                                {users.map((user) => (
                                    <option key={user.id} value={user.id}>
                                        {user.name}
                                    </option>
                                ))}
                            </select>
                            <ChevronDownIcon className="pointer-events-none absolute top-1/2 right-3.5 size-4 -translate-y-1/2 text-muted-foreground opacity-50 select-none" />
                        </div>
                    </div>

                    <div className="flex flex-col gap-1.5">
                        <label
                            htmlFor="subject_type"
                            className="text-sm font-medium"
                        >
                            Kayıt Türü
                        </label>
                        <div className="relative w-full">
                            <select
                                id="subject_type"
                                value={form.data.subject_type}
                                onChange={(e) =>
                                    form.setData('subject_type', e.target.value)
                                }
                                className="h-9 w-full min-w-0 appearance-none rounded-md border border-input bg-transparent px-3 py-2 pr-9 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 disabled:pointer-events-none disabled:cursor-not-allowed dark:bg-input/30 dark:hover:bg-input/50"
                            >
                                <option value="">Tümü</option>
                                {subject_types.map((type) => (
                                    <option key={type.value} value={type.value}>
                                        {type.label}
                                    </option>
                                ))}
                            </select>
                            <ChevronDownIcon className="pointer-events-none absolute top-1/2 right-3.5 size-4 -translate-y-1/2 text-muted-foreground opacity-50 select-none" />
                        </div>
                    </div>

                    <div className="flex flex-col gap-1.5">
                        <label htmlFor="from" className="text-sm font-medium">
                            Başlangıç Tarihi
                        </label>
                        <Input
                            id="from"
                            type="date"
                            value={form.data.from}
                            onChange={(e) =>
                                form.setData('from', e.target.value)
                            }
                        />
                    </div>

                    <div className="flex flex-col gap-1.5">
                        <label htmlFor="to" className="text-sm font-medium">
                            Bitiş Tarihi
                        </label>
                        <Input
                            id="to"
                            type="date"
                            value={form.data.to}
                            onChange={(e) => form.setData('to', e.target.value)}
                        />
                    </div>

                    <div className="flex gap-2">
                        <Button type="submit" disabled={form.processing}>
                            <Search className="size-4" />
                            Filtrele
                        </Button>
                        <Button
                            type="button"
                            variant="outline"
                            onClick={handleReset}
                        >
                            <RotateCcw className="size-4" />
                            Sıfırla
                        </Button>
                    </div>
                </form>

                {activities.data.length === 0 ? (
                    <Empty>
                        <EmptyHeader>
                            <EmptyMedia variant="icon">
                                <ActivityIcon className="size-6" />
                            </EmptyMedia>
                            <EmptyTitle>Kayıt Bulunamadı</EmptyTitle>
                            <EmptyDescription>
                                Seçili filtrelere uygun etkinlik kaydı
                                bulunmuyor.
                            </EmptyDescription>
                        </EmptyHeader>
                    </Empty>
                ) : (
                    <>
                        <div className="relative overflow-hidden rounded-xl border">
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Tarih</TableHead>
                                        <TableHead>Kullanıcı</TableHead>
                                        <TableHead>Olay</TableHead>
                                        <TableHead>Kayıt Türü</TableHead>
                                        <TableHead>Açıklama</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {activities.data.map((item) => (
                                        <TableRow key={item.id}>
                                            <TableCell>
                                                {item.created_at
                                                    ? new Date(
                                                          item.created_at,
                                                      ).toLocaleString('tr-TR')
                                                    : '-'}
                                            </TableCell>
                                            <TableCell>
                                                {item.causer?.name ?? '-'}
                                            </TableCell>
                                            <TableCell>
                                                <Badge
                                                    variant={getEventVariant(
                                                        item.event,
                                                    )}
                                                >
                                                    {getEventLabel(item.event)}
                                                </Badge>
                                            </TableCell>
                                            <TableCell>
                                                {item.subject_label ?? '-'}
                                            </TableCell>
                                            <TableCell className="max-w-xs truncate">
                                                {item.description ?? '-'}
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </div>

                        <DataPagination paginator={activities} />
                    </>
                )}
            </div>
        </>
    );
}

ActivityIndex.layout = {
    breadcrumbs: [
        {
            title: 'Etkinlik Kayıtları',
            href: dashboard(),
        },
    ],
};
