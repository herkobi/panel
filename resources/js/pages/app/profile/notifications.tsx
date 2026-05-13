import { Form, Head, Link } from '@inertiajs/react';
import { Bell, CheckCircle2 } from 'lucide-react';
import { markAsRead } from '@/actions/App/Http/Controllers/App/Profile/NotificationsController';
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
import {
    Item,
    ItemActions,
    ItemContent,
    ItemDescription,
    ItemGroup,
    ItemMedia,
    ItemTitle,
} from '@/components/ui/item';
import { cn } from '@/lib/utils';
import { notifications } from '@/routes/app/profile';
import type { NotificationItem, Paginated, PaginationLink } from '@/types';

type NotificationsProps = {
    notifications?: Paginated<NotificationItem> & {
        meta?: {
            total?: number;
            links?: PaginationLink[];
        };
    };
};

function getNotificationText(
    notification: NotificationItem,
    key: 'title' | 'message',
): string {
    const value = notification.data[key];

    return typeof value === 'string' ? value : '-';
}

function getPaginationLinks(
    notifications?: NotificationsProps['notifications'],
): PaginationLink[] {
    if (Array.isArray(notifications?.links)) {
        return notifications.links;
    }

    if (Array.isArray(notifications?.meta?.links)) {
        return notifications.meta.links;
    }

    return [];
}

function getPaginationLabel(label: string): string {
    return label.replaceAll('&laquo;', '').replaceAll('&raquo;', '').trim();
}

function isPreviousPageLabel(label: string): boolean {
    const normalized = getPaginationLabel(label).toLowerCase();

    return normalized.includes('previous') || normalized.includes('önceki');
}

function isNextPageLabel(label: string): boolean {
    const normalized = getPaginationLabel(label).toLowerCase();

    return normalized.includes('next') || normalized.includes('sonraki');
}

export default function Notifications({
    notifications: items,
}: NotificationsProps) {
    const notificationItems = items?.data ?? [];
    const paginationLinks = getPaginationLinks(items);

    return (
        <>
            <Head title="Bildirimler" />

            <div className="space-y-6">
                <Heading
                    variant="small"
                    title="Bildirimler"
                    description="Hesabınıza ait bildirimleri buradan takip edebilirsiniz."
                />

                {notificationItems.length === 0 ? (
                    <Empty>
                        <EmptyHeader>
                            <EmptyMedia variant="icon">
                                <Bell />
                            </EmptyMedia>
                            <EmptyTitle>Henüz bildirim yok</EmptyTitle>
                            <EmptyDescription>
                                Yeni bildirimler oluştuğunda bu alanda
                                listelenecek.
                            </EmptyDescription>
                        </EmptyHeader>
                    </Empty>
                ) : (
                    <div className="max-w-3xl space-y-4">
                        <ItemGroup className="gap-3">
                            {notificationItems.map((notification) => (
                                <Item
                                    key={notification.id}
                                    className={cn(
                                        'border bg-background shadow-xs',
                                        !notification.read_at &&
                                            'border-primary/20 bg-muted/35',
                                    )}
                                >
                                    <ItemMedia
                                        variant="icon"
                                        className={cn(
                                            !notification.read_at &&
                                                'border-primary/25 bg-primary/10 text-primary',
                                        )}
                                    >
                                        {notification.read_at ? (
                                            <CheckCircle2 />
                                        ) : (
                                            <Bell />
                                        )}
                                    </ItemMedia>
                                    <ItemContent className="min-w-0">
                                        <div className="flex flex-wrap items-center gap-2">
                                            <ItemTitle>
                                                {getNotificationText(
                                                    notification,
                                                    'title',
                                                )}
                                            </ItemTitle>
                                            {!notification.read_at && (
                                                <Badge variant="secondary">
                                                    Yeni
                                                </Badge>
                                            )}
                                            {notification.read_at && (
                                                <Badge variant="outline">
                                                    Okundu
                                                </Badge>
                                            )}
                                        </div>
                                        <ItemDescription>
                                            {getNotificationText(
                                                notification,
                                                'message',
                                            )}
                                        </ItemDescription>
                                        <p className="text-xs text-muted-foreground">
                                            {new Date(
                                                notification.created_at,
                                            ).toLocaleString('tr-TR')}
                                        </p>
                                    </ItemContent>

                                    {!notification.read_at && (
                                        <ItemActions className="ml-auto">
                                            <Form
                                                {...markAsRead.form(
                                                    notification.id,
                                                )}
                                                options={{
                                                    preserveScroll: true,
                                                }}
                                            >
                                                {({ processing }) => (
                                                    <Button
                                                        type="submit"
                                                        size="icon-sm"
                                                        variant="outline"
                                                        disabled={processing}
                                                        aria-label="Okundu olarak işaretle"
                                                        title="Okundu olarak işaretle"
                                                    >
                                                        <CheckCircle2 />
                                                    </Button>
                                                )}
                                            </Form>
                                        </ItemActions>
                                    )}
                                </Item>
                            ))}
                        </ItemGroup>

                        <div className="flex items-center justify-between">
                            <div className="text-sm text-muted-foreground">
                                Toplam {items?.meta?.total ?? 0} bildirim
                            </div>
                            <div className="flex items-center gap-1">
                                {paginationLinks.map((link, index) => {
                                    if (isPreviousPageLabel(link.label)) {
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
                                                {getPaginationLabel(link.label)}
                                            </Link>
                                        );
                                    }

                                    if (isNextPageLabel(link.label)) {
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
                                                {getPaginationLabel(link.label)}
                                            </Link>
                                        );
                                    }

                                    if (link.label === '...') {
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
                                                    size: 'icon',
                                                }),
                                                'size-8 text-xs',
                                            )}
                                        >
                                            {getPaginationLabel(link.label)}
                                        </Link>
                                    );
                                })}
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </>
    );
}

Notifications.layout = {
    breadcrumbs: [
        {
            title: 'Bildirimler',
            href: notifications(),
        },
    ],
};
