import { Head, Link, router } from '@inertiajs/react';
import { ArrowLeft, RotateCcw, Trash2, X } from 'lucide-react';
import { useState } from 'react';

import PermissionsController from '@/actions/App/Http/Controllers/Panel/Settings/Permissions/PermissionsController';
import Heading from '@/components/heading';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { dashboard } from '@/routes';
import { index as permissionsIndex } from '@/routes/panel/settings/permissions';

type Permission = {
    uuid: string;
    name: string;
    group: string | null;
    label: string | null;
    roles_count: number;
};

type Props = {
    groups: Record<string, Permission[]>;
};

export default function PermissionsDeleted({ groups }: Props) {
    const [forcing, setForcing] = useState<Permission | null>(null);

    return (
        <>
            <Head title="Silinen Yetkiler" />

            <div className="flex flex-col gap-6 p-4">
                <div className="flex flex-wrap items-start justify-between gap-3 border-b pb-4">
                    <Heading
                        variant="small"
                        title="Silinen Yetkiler"
                        description="Soft-delete edilmiş izinler. Geri yüklenebilir veya kalıcı olarak silinebilir."
                    />
                    <Button asChild variant="outline">
                        <Link href={permissionsIndex().url}>
                            <ArrowLeft data-icon="inline-start" />
                            Listeye dön
                        </Link>
                    </Button>
                </div>

                {Object.keys(groups).length === 0 ? (
                    <div className="rounded-md border border-dashed p-8 text-center text-sm text-muted-foreground">
                        Silinmiş izin yok.
                    </div>
                ) : (
                    Object.entries(groups).map(([group, items]) => (
                        <section key={group} className="flex flex-col gap-2">
                            <h2 className="text-sm font-medium text-muted-foreground">
                                {group}
                            </h2>
                            <div className="rounded-md border">
                                <Table>
                                    <TableHeader>
                                        <TableRow>
                                            <TableHead>Etiket</TableHead>
                                            <TableHead className="font-mono">
                                                İzin Adı
                                            </TableHead>
                                            <TableHead className="w-24">
                                                Roller
                                            </TableHead>
                                            <TableHead className="w-40 text-right">
                                                İşlemler
                                            </TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        {items.map((item) => (
                                            <TableRow key={item.uuid}>
                                                <TableCell>
                                                    {item.label ?? (
                                                        <span className="text-muted-foreground italic">
                                                            (etiket yok)
                                                        </span>
                                                    )}
                                                </TableCell>
                                                <TableCell className="font-mono text-xs text-muted-foreground">
                                                    {item.name}
                                                </TableCell>
                                                <TableCell>
                                                    <Badge variant="secondary">
                                                        {item.roles_count}
                                                    </Badge>
                                                </TableCell>
                                                <TableCell>
                                                    <div className="flex justify-end gap-1">
                                                        <Button
                                                            variant="ghost"
                                                            size="icon"
                                                            onClick={() => {
                                                                router.patch(
                                                                    PermissionsController.restore(
                                                                        {
                                                                            permission:
                                                                                item.uuid,
                                                                        },
                                                                    ).url,
                                                                    undefined,
                                                                    {
                                                                        preserveScroll: true,
                                                                    },
                                                                );
                                                            }}
                                                            aria-label="Geri Yükle"
                                                        >
                                                            <RotateCcw />
                                                        </Button>
                                                        <Button
                                                            variant="ghost"
                                                            size="icon"
                                                            onClick={() =>
                                                                setForcing(item)
                                                            }
                                                            aria-label="Kalıcı Sil"
                                                        >
                                                            <Trash2 />
                                                        </Button>
                                                    </div>
                                                </TableCell>
                                            </TableRow>
                                        ))}
                                    </TableBody>
                                </Table>
                            </div>
                        </section>
                    ))
                )}
            </div>

            <AlertDialog
                open={forcing !== null}
                onOpenChange={(open) => {
                    if (!open) {
                        setForcing(null);
                    }
                }}
            >
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>İzni kalıcı sil</AlertDialogTitle>
                        <AlertDialogDescription>
                            <span className="font-mono">{forcing?.name}</span>{' '}
                            izni kalıcı olarak silinecek
                            {forcing && forcing.roles_count > 0
                                ? ` ve ${forcing.roles_count} rolden tamamen kaldırılacak`
                                : ''}
                            . Bu işlem geri alınamaz.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>
                            <X />
                            İptal
                        </AlertDialogCancel>
                        <AlertDialogAction
                            onClick={() => {
                                if (!forcing) {
                                    return;
                                }

                                router.delete(
                                    PermissionsController.forceDelete({
                                        permission: forcing.uuid,
                                    }).url,
                                    {
                                        preserveScroll: true,
                                        onFinish: () => setForcing(null),
                                    },
                                );
                            }}
                        >
                            <Trash2 />
                            Kalıcı Sil
                        </AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </>
    );
}

PermissionsDeleted.layout = {
    breadcrumbs: [{ title: 'Silinen Yetkiler', href: dashboard() }],
};
