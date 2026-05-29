import { Form, Head, Link } from '@inertiajs/react';
import {
    Activity,
    ArrowLeft,
    CalendarClock,
    Globe2,
    LogIn,
    LogOut,
    Mail,
    MailCheck,
    MoreHorizontal,
    MonitorCheck,
    RefreshCw,
    Send,
    ShieldCheck,
    UserCog,
    X,
} from 'lucide-react';
import { useState } from 'react';
import UsersController from '@/actions/App/Http/Controllers/Panel/Settings/User/UsersController';
import InputError from '@/components/input-error';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    Empty,
    EmptyDescription,
    EmptyHeader,
    EmptyMedia,
    EmptyTitle,
} from '@/components/ui/empty';
import { Input } from '@/components/ui/input';
import {
    Item,
    ItemContent,
    ItemDescription,
    ItemGroup,
    ItemMedia,
    ItemTitle,
} from '@/components/ui/item';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Spinner } from '@/components/ui/spinner';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { index } from '@/routes/panel/settings/users';
import type { Activity as ActivityItem, PanelUser } from '@/types';

type UserSessionLog = {
    id: number;
    ip_address: string | null;
    user_agent: string | null;
    device: string;
    browser: string;
    platform: string;
    login_at: string | null;
    logout_at: string | null;
};

type RoleOption = { name: string };

type Props = {
    user: {
        data: PanelUser;
    };
    activities: {
        data: ActivityItem[];
    };
    sessions: {
        data: UserSessionLog[];
    };
    assignableRoles: RoleOption[];
};

type EditableUserStatus = 'active' | 'passive';

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

function eventLabel(event: string | null): string {
    switch (event) {
        case 'created':
            return 'Oluşturuldu';
        case 'updated':
            return 'Güncellendi';
        case 'deleted':
            return 'Silindi';
        case 'session_revoked':
            return 'Oturum kapatıldı';
        default:
            return event ?? 'Kayıt';
    }
}

function eventVariant(
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

export default function Show({
    user,
    activities,
    sessions,
    assignableRoles,
}: Props) {
    const currentUser = user.data;
    const activityItems = activities.data;
    const sessionItems = sessions.data;
    const currentRole = currentUser.roles?.[0] ?? null;
    const [verifyEmailDialogOpen, setVerifyEmailDialogOpen] =
        useState<boolean>(false);
    const [emailChangeDialogOpen, setEmailChangeDialogOpen] =
        useState<boolean>(false);
    const [statusDialogOpen, setStatusDialogOpen] = useState<boolean>(false);
    const [statusValue, setStatusValue] = useState<EditableUserStatus>(
        currentUser.status === 'active' ? 'passive' : 'active',
    );
    const [roleDialogOpen, setRoleDialogOpen] = useState<boolean>(false);
    const [roleValue, setRoleValue] = useState<string>(
        currentRole ?? assignableRoles[0]?.name ?? '',
    );
    const canChangeRole =
        assignableRoles.length > 0 &&
        (currentRole === null ||
            assignableRoles.some((r) => r.name === currentRole));

    const openStatusDialog = (): void => {
        setStatusValue(currentUser.status === 'active' ? 'passive' : 'active');
        setStatusDialogOpen(true);
    };

    return (
        <>
            <Head title={currentUser.name} />

            <div className="flex flex-col gap-6">
                <div className="flex flex-col gap-4">
                    <div className="flex min-w-0 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div className="flex min-w-0 items-center gap-4">
                            <Avatar size="lg" className="shrink-0">
                                <AvatarFallback>
                                    {initials(currentUser.name)}
                                </AvatarFallback>
                            </Avatar>
                            <div className="min-w-0">
                                <h2 className="truncate text-lg font-semibold">
                                    {currentUser.name}
                                </h2>
                                <p className="truncate text-sm text-muted-foreground">
                                    {currentUser.email}
                                </p>
                            </div>
                        </div>
                        <div className="flex flex-wrap items-center gap-2 sm:justify-end">
                            <Badge variant="secondary">
                                {currentRole ?? 'Rolsüz'}
                            </Badge>
                            <Badge variant={statusVariant(currentUser.status)}>
                                {statusLabel(currentUser.status)}
                            </Badge>
                            <DropdownMenu>
                                <DropdownMenuTrigger asChild>
                                    <Button
                                        type="button"
                                        variant="outline"
                                        size="icon-sm"
                                        aria-label="Kullanıcı işlemleri"
                                    >
                                        <MoreHorizontal />
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent
                                    align="end"
                                    className="w-56"
                                >
                                    <DropdownMenuGroup>
                                        {!currentUser.email_verified_at && (
                                            <DropdownMenuItem
                                                onSelect={() =>
                                                    setVerifyEmailDialogOpen(
                                                        true,
                                                    )
                                                }
                                            >
                                                <MailCheck />
                                                E-posta Adresini Onayla
                                            </DropdownMenuItem>
                                        )}
                                        <DropdownMenuItem
                                            onSelect={() =>
                                                setEmailChangeDialogOpen(true)
                                            }
                                        >
                                            <Mail />
                                            E-posta Adresini Değiştir
                                        </DropdownMenuItem>
                                        <DropdownMenuItem
                                            onSelect={openStatusDialog}
                                        >
                                            <RefreshCw />
                                            Durum Değiştir
                                        </DropdownMenuItem>
                                        {canChangeRole && (
                                            <DropdownMenuItem
                                                onSelect={() =>
                                                    setRoleDialogOpen(true)
                                                }
                                            >
                                                <UserCog />
                                                Rol Değiştir
                                            </DropdownMenuItem>
                                        )}
                                    </DropdownMenuGroup>
                                </DropdownMenuContent>
                            </DropdownMenu>
                            <Button
                                asChild
                                variant="outline"
                                size="icon-sm"
                                aria-label="Listeye dön"
                            >
                                <Link href={index()}>
                                    <ArrowLeft />
                                </Link>
                            </Button>
                        </div>
                    </div>

                    <dl className="grid gap-3 text-sm md:grid-cols-3">
                        <div className="flex flex-col gap-1 rounded-lg border p-3">
                            <dt className="flex items-center gap-2 text-muted-foreground">
                                <ShieldCheck className="size-4" />
                                E-posta doğrulama
                            </dt>
                            <dd className="font-medium">
                                {currentUser.email_verified_at
                                    ? formatDate(currentUser.email_verified_at)
                                    : 'Doğrulanmadı'}
                            </dd>
                        </div>
                        <div className="flex flex-col gap-1 rounded-lg border p-3">
                            <dt className="flex items-center gap-2 text-muted-foreground">
                                <LogIn className="size-4" />
                                Son giriş
                            </dt>
                            <dd className="font-medium">
                                {formatDate(
                                    currentUser.last_login_at as
                                        | string
                                        | null
                                        | undefined,
                                )}
                            </dd>
                        </div>
                        <div className="flex flex-col gap-1 rounded-lg border p-3">
                            <dt className="flex items-center gap-2 text-muted-foreground">
                                <CalendarClock className="size-4" />
                                Kayıt tarihi
                            </dt>
                            <dd className="font-medium">
                                {formatDate(currentUser.created_at)}
                            </dd>
                        </div>
                    </dl>
                </div>

                <Tabs defaultValue="activities" className="min-w-0 gap-4">
                    <TabsList>
                        <TabsTrigger value="activities">
                            <Activity />
                            Etkinlik
                        </TabsTrigger>
                        <TabsTrigger value="sessions">
                            <MonitorCheck />
                            Oturumlar
                        </TabsTrigger>
                    </TabsList>

                    <TabsContent
                        value="activities"
                        className="flex flex-col gap-4"
                    >
                        <div className="flex flex-col gap-1">
                            <h3 className="text-base font-semibold">
                                Etkinlik Kayıtları
                            </h3>
                            <p className="text-sm text-muted-foreground">
                                Kullanıcıyla ilişkili son 20 denetim kaydı.
                            </p>
                        </div>

                        {activityItems.length === 0 ? (
                            <Empty>
                                <EmptyHeader>
                                    <EmptyMedia variant="icon">
                                        <Activity />
                                    </EmptyMedia>
                                    <EmptyTitle>Etkinlik kaydı yok</EmptyTitle>
                                    <EmptyDescription>
                                        Bu kullanıcı için henüz kayıtlı etkinlik
                                        bulunmuyor.
                                    </EmptyDescription>
                                </EmptyHeader>
                            </Empty>
                        ) : (
                            <ItemGroup className="gap-3">
                                {activityItems.map((activity) => (
                                    <Item key={activity.id} variant="outline">
                                        <ItemMedia variant="icon">
                                            <Activity />
                                        </ItemMedia>
                                        <ItemContent className="min-w-0">
                                            <div className="flex flex-wrap items-center gap-2">
                                                <ItemTitle>
                                                    {activity.description ??
                                                        eventLabel(
                                                            activity.event,
                                                        )}
                                                </ItemTitle>
                                                <Badge
                                                    variant={eventVariant(
                                                        activity.event,
                                                    )}
                                                >
                                                    {eventLabel(activity.event)}
                                                </Badge>
                                            </div>
                                            <ItemDescription>
                                                {formatDate(
                                                    activity.created_at,
                                                )}{' '}
                                                ·{' '}
                                                {activity.subject_label ?? '-'}{' '}
                                                · {activity.causer?.name ?? '-'}
                                            </ItemDescription>
                                        </ItemContent>
                                    </Item>
                                ))}
                            </ItemGroup>
                        )}
                    </TabsContent>

                    <TabsContent
                        value="sessions"
                        className="flex flex-col gap-4"
                    >
                        <div className="flex flex-col gap-1">
                            <h3 className="text-base font-semibold">
                                Oturum Kayıtları
                            </h3>
                            <p className="text-sm text-muted-foreground">
                                Kullanıcının son 20 giriş ve çıkış kaydı.
                            </p>
                        </div>

                        {sessionItems.length === 0 ? (
                            <Empty>
                                <EmptyHeader>
                                    <EmptyMedia variant="icon">
                                        <MonitorCheck />
                                    </EmptyMedia>
                                    <EmptyTitle>Oturum kaydı yok</EmptyTitle>
                                    <EmptyDescription>
                                        Kullanıcı giriş yaptığında kayıtlar
                                        burada listelenir.
                                    </EmptyDescription>
                                </EmptyHeader>
                            </Empty>
                        ) : (
                            <ItemGroup className="gap-3">
                                {sessionItems.map((session) => (
                                    <Item key={session.id} variant="outline">
                                        <ItemMedia variant="icon">
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
                                                        session.logout_at
                                                            ? 'outline'
                                                            : 'secondary'
                                                    }
                                                >
                                                    {session.logout_at
                                                        ? 'Kapandı'
                                                        : 'Açık olabilir'}
                                                </Badge>
                                            </div>
                                            <ItemDescription>
                                                {session.platform} · IP:{' '}
                                                {session.ip_address ?? '-'}
                                            </ItemDescription>
                                            <div className="grid gap-1 text-xs text-muted-foreground sm:grid-cols-2">
                                                <span className="flex items-center gap-1.5">
                                                    <LogIn className="size-3.5" />
                                                    Giriş:{' '}
                                                    {formatDate(
                                                        session.login_at,
                                                    )}
                                                </span>
                                                <span className="flex items-center gap-1.5">
                                                    <LogOut className="size-3.5" />
                                                    Çıkış:{' '}
                                                    {formatDate(
                                                        session.logout_at,
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
                                    </Item>
                                ))}
                            </ItemGroup>
                        )}
                    </TabsContent>
                </Tabs>
            </div>

            <Dialog
                open={verifyEmailDialogOpen}
                onOpenChange={setVerifyEmailDialogOpen}
            >
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>E-posta adresini onayla</DialogTitle>
                        <DialogDescription>
                            {currentUser.email} adresini bu kullanıcı için
                            onaylamak istediğinize emin misiniz? İşlem
                            kaydedilecek ve kullanıcıya bilgilendirme e-postası
                            gönderilecek.
                        </DialogDescription>
                    </DialogHeader>

                    <Form
                        {...UsersController.verifyEmail.form(currentUser)}
                        options={{
                            preserveScroll: true,
                        }}
                        onSuccess={() => setVerifyEmailDialogOpen(false)}
                    >
                        {({ processing }) => (
                            <DialogFooter>
                                <DialogClose asChild>
                                    <Button
                                        type="button"
                                        variant="outline"
                                        disabled={processing}
                                    >
                                        <X />
                                        Vazgeç
                                    </Button>
                                </DialogClose>
                                <Button type="submit" disabled={processing}>
                                    {processing ? <Spinner /> : <MailCheck />}
                                    E-postayı onayla
                                </Button>
                            </DialogFooter>
                        )}
                    </Form>
                </DialogContent>
            </Dialog>

            <Dialog
                open={emailChangeDialogOpen}
                onOpenChange={setEmailChangeDialogOpen}
            >
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>E-posta adresini değiştir</DialogTitle>
                        <DialogDescription>
                            Yeni adrese onay bağlantısı gönderilecek. Bağlantı
                            onaylandığında e-posta değişecek, yeni adres
                            onaylanacak ve kullanıcının oturumları kapatılacak.
                        </DialogDescription>
                    </DialogHeader>

                    <Form
                        {...UsersController.requestEmailChange.form(
                            currentUser,
                        )}
                        options={{
                            preserveScroll: true,
                        }}
                        onSuccess={() => setEmailChangeDialogOpen(false)}
                        resetOnSuccess={['email']}
                        className="flex flex-col gap-6"
                    >
                        {({ errors, processing }) => (
                            <>
                                <div className="grid gap-2">
                                    <Label htmlFor="current_email">
                                        Var olan e-posta adresi
                                    </Label>
                                    <Input
                                        id="current_email"
                                        type="email"
                                        value={currentUser.email}
                                        disabled
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="new_email">
                                        Yeni e-posta adresi
                                    </Label>
                                    <Input
                                        id="new_email"
                                        type="email"
                                        name="email"
                                        required
                                        autoComplete="email"
                                        placeholder="yeni@ornek.com"
                                        aria-invalid={Boolean(errors.email)}
                                    />
                                    <InputError message={errors.email} />
                                </div>

                                <DialogFooter>
                                    <DialogClose asChild>
                                        <Button
                                            type="button"
                                            variant="outline"
                                            disabled={processing}
                                        >
                                            <X />
                                            Vazgeç
                                        </Button>
                                    </DialogClose>
                                    <Button type="submit" disabled={processing}>
                                        {processing ? <Spinner /> : <Send />}
                                        Onay bağlantısı gönder
                                    </Button>
                                </DialogFooter>
                            </>
                        )}
                    </Form>
                </DialogContent>
            </Dialog>

            <Dialog open={roleDialogOpen} onOpenChange={setRoleDialogOpen}>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Rol Değiştir</DialogTitle>
                        <DialogDescription>
                            Kullanıcının rolünü güncelleyin. Yalnızca
                            atayabileceğiniz roller listelenir.
                        </DialogDescription>
                    </DialogHeader>

                    <Form
                        {...UsersController.updateRole.form(currentUser)}
                        options={{ preserveScroll: true }}
                        onSuccess={() => setRoleDialogOpen(false)}
                        className="flex flex-col gap-6"
                    >
                        {({ errors, processing }) => (
                            <>
                                <input
                                    type="hidden"
                                    name="role"
                                    value={roleValue}
                                />
                                <div className="grid gap-2">
                                    <Label>Yeni rol</Label>
                                    <Select
                                        value={roleValue}
                                        onValueChange={setRoleValue}
                                    >
                                        <SelectTrigger className="w-full">
                                            <SelectValue placeholder="Rol seçin" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                {assignableRoles.map((r) => (
                                                    <SelectItem
                                                        key={r.name}
                                                        value={r.name}
                                                    >
                                                        {r.name}
                                                    </SelectItem>
                                                ))}
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                    <InputError message={errors.role} />
                                </div>

                                <DialogFooter>
                                    <DialogClose asChild>
                                        <Button
                                            type="button"
                                            variant="outline"
                                            disabled={processing}
                                        >
                                            <X />
                                            Vazgeç
                                        </Button>
                                    </DialogClose>
                                    <Button type="submit" disabled={processing}>
                                        {processing ? <Spinner /> : <UserCog />}
                                        Rolü güncelle
                                    </Button>
                                </DialogFooter>
                            </>
                        )}
                    </Form>
                </DialogContent>
            </Dialog>

            <Dialog open={statusDialogOpen} onOpenChange={setStatusDialogOpen}>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Durum değiştir</DialogTitle>
                        <DialogDescription>
                            Kullanıcının panel erişim durumunu active/passive
                            olarak güncelleyin. İşlem kaydedilecek ve
                            kullanıcıya bilgilendirme e-postası gönderilecek.
                        </DialogDescription>
                    </DialogHeader>

                    <Form
                        {...UsersController.updateStatus.form(currentUser)}
                        options={{
                            preserveScroll: true,
                        }}
                        onSuccess={() => setStatusDialogOpen(false)}
                        className="flex flex-col gap-6"
                    >
                        {({ errors, processing }) => (
                            <>
                                <input
                                    type="hidden"
                                    name="status"
                                    value={statusValue}
                                />
                                <div className="grid gap-2">
                                    <Label>Yeni durum</Label>
                                    <Select
                                        value={statusValue}
                                        onValueChange={(value) =>
                                            setStatusValue(
                                                value as EditableUserStatus,
                                            )
                                        }
                                    >
                                        <SelectTrigger className="w-full">
                                            <SelectValue />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectItem value="active">
                                                    Aktif
                                                </SelectItem>
                                                <SelectItem value="passive">
                                                    Pasif
                                                </SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                    <InputError message={errors.status} />
                                </div>

                                <DialogFooter>
                                    <DialogClose asChild>
                                        <Button
                                            type="button"
                                            variant="outline"
                                            disabled={processing}
                                        >
                                            <X />
                                            Vazgeç
                                        </Button>
                                    </DialogClose>
                                    <Button type="submit" disabled={processing}>
                                        {processing ? <Spinner /> : <RefreshCw />}
                                        Durumu güncelle
                                    </Button>
                                </DialogFooter>
                            </>
                        )}
                    </Form>
                </DialogContent>
            </Dialog>
        </>
    );
}

Show.layout = {
    breadcrumbs: [
        {
            title: 'Kullanıcılar',
            href: index(),
        },
    ],
};
