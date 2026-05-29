import { Head } from '@inertiajs/react';
import { Globe2, LogIn, MonitorCheck, Power } from 'lucide-react';
import { destroy } from '@/actions/App/Http/Controllers/Panel/Profile/SessionsController';
import { ConfirmDelete } from '@/components/confirm-delete';
import Heading from '@/components/heading';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
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
import { sessions } from '@/routes/panel/profile';
import type { SessionItem } from '@/types';

type SessionsProps = {
    last_login_at?: string | null;
    sessions?: {
        data: SessionItem[];
    };
};

function formatDate(value: string | null | undefined): string {
    if (!value) {
        return '-';
    }

    return new Date(value).toLocaleString('tr-TR');
}

export default function Sessions({
    last_login_at,
    sessions: items,
}: SessionsProps) {
    const sessionItems = items?.data ?? [];

    return (
        <>
            <Head title="Oturum Kayıtları" />

            <div className="space-y-6">
                <div className="space-y-2">
                    <Heading
                        variant="small"
                        title="Aktif Oturumlar"
                        description="Hesabınızda açık olan cihazları ve son hareket bilgilerini buradan takip edebilirsiniz."
                    />

                    <p className="text-sm text-muted-foreground">
                        Son giriş tarihi: {formatDate(last_login_at)}
                    </p>
                </div>

                {sessionItems.length === 0 ? (
                    <Empty>
                        <EmptyHeader>
                            <EmptyMedia variant="icon">
                                <MonitorCheck />
                            </EmptyMedia>
                            <EmptyTitle>Açık oturum bulunamadı</EmptyTitle>
                            <EmptyDescription>
                                Aktif oturumlarınız oluştuğunda bu alanda
                                listelenecek.
                            </EmptyDescription>
                        </EmptyHeader>
                    </Empty>
                ) : (
                    <div className="max-w-3xl space-y-4">
                        <ItemGroup className="gap-3">
                            {sessionItems.map((session) => (
                                <Item
                                    key={session.id}
                                    className={cn(
                                        'border bg-background shadow-xs',
                                        session.is_current &&
                                            'border-primary/20 bg-muted/35',
                                    )}
                                >
                                    <ItemMedia
                                        variant="icon"
                                        className={cn(
                                            session.is_current &&
                                                'border-primary/25 bg-primary/10 text-primary',
                                        )}
                                    >
                                        <MonitorCheck />
                                    </ItemMedia>

                                    <ItemContent className="min-w-0">
                                        <div className="flex flex-wrap items-center gap-2">
                                            <ItemTitle>
                                                {session.device} ·{' '}
                                                {session.browser}
                                            </ItemTitle>
                                            <Badge
                                                variant={
                                                    session.is_current
                                                        ? 'secondary'
                                                        : 'outline'
                                                }
                                            >
                                                {session.is_current
                                                    ? 'Bu cihaz'
                                                    : 'Diğer cihaz'}
                                            </Badge>
                                            {session.session_count > 1 && (
                                                <Badge variant="outline">
                                                    {session.session_count}{' '}
                                                    oturum
                                                </Badge>
                                            )}
                                        </div>

                                        <ItemDescription>
                                            {session.platform} · IP:{' '}
                                            {session.ip_address ?? '-'}
                                        </ItemDescription>

                                        <div className="grid gap-1 text-xs text-muted-foreground sm:grid-cols-2">
                                            <span className="flex items-center gap-1.5">
                                                <LogIn className="size-3.5" />
                                                Giriş:{' '}
                                                {formatDate(session.login_at)}
                                            </span>
                                            <span className="flex items-center gap-1.5">
                                                <MonitorCheck className="size-3.5" />
                                                Son hareket:{' '}
                                                {formatDate(
                                                    session.last_activity_at,
                                                )}
                                            </span>
                                        </div>

                                        <p className="flex min-w-0 items-center gap-1.5 truncate text-xs text-muted-foreground">
                                            <Globe2 className="size-3.5 shrink-0" />
                                            <span className="truncate">
                                                {session.user_agent ?? '-'}
                                            </span>
                                        </p>
                                    </ItemContent>

                                    {!session.is_current && (
                                        <ItemActions className="ml-auto">
                                            <ConfirmDelete
                                                action={destroy(session.id)}
                                                title="Oturum kapatılsın mı?"
                                                description="Bu cihazdaki oturum sonlandırılacak."
                                                confirmLabel="Oturumu kapat"
                                                confirmIcon={Power}
                                            >
                                                <Button
                                                    size="sm"
                                                    variant="outline"
                                                >
                                                    <Power />
                                                    Oturumu kapat
                                                </Button>
                                            </ConfirmDelete>
                                        </ItemActions>
                                    )}
                                </Item>
                            ))}
                        </ItemGroup>

                        <div className="text-sm text-muted-foreground">
                            Toplam {sessionItems.length} aktif cihaz
                        </div>
                    </div>
                )}
            </div>
        </>
    );
}

Sessions.layout = {
    breadcrumbs: [
        {
            title: 'Oturum Kayıtları',
            href: sessions(),
        },
    ],
};
