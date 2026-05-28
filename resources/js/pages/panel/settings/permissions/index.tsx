import { Head, Link, router, useForm } from '@inertiajs/react';
import { Pencil, Plus, Radar, Trash2 } from 'lucide-react';
import { useState } from 'react';

import PermissionsController from '@/actions/App/Http/Controllers/Panel/Settings/Permissions/PermissionsController';
import Heading from '@/components/heading';
import InputError from '@/components/input-error';
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
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { dashboard } from '@/routes';
import { discover as discoverRoute } from '@/routes/panel/settings/permissions';

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

export default function PermissionsIndex({ groups }: Props) {
    const [editing, setEditing] = useState<Permission | null>(null);
    const [creating, setCreating] = useState(false);
    const [deleting, setDeleting] = useState<Permission | null>(null);

    return (
        <>
            <Head title="Yetkiler" />

            <div className="flex flex-col gap-6 p-4">
                <div className="flex flex-wrap items-start justify-between gap-3 border-b pb-4">
                    <Heading
                        variant="small"
                        title="Yetkiler"
                        description="Sistemdeki izinleri tanımla, grupla ve etiketle. Rotalara karşılık gelmeyen özel izinler de buradan eklenir."
                    />
                    <div className="flex gap-2">
                        <Button asChild variant="outline">
                            <Link href={discoverRoute().url}>
                                <Radar data-icon="inline-start" />
                                Rotalardan Keşfet
                            </Link>
                        </Button>
                        <Button onClick={() => setCreating(true)}>
                            <Plus data-icon="inline-start" />
                            Yeni İzin
                        </Button>
                    </div>
                </div>

                {Object.keys(groups).length === 0 ? (
                    <div className="rounded-md border border-dashed p-8 text-center text-sm text-muted-foreground">
                        Henüz tanımlı izin yok. "Rotalardan Keşfet" ile mevcut
                        panel rotalarını toplu ekleyebilir veya "Yeni İzin" ile
                        tek tek tanımlayabilirsin.
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
                                            <TableHead className="w-32 text-right">
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
                                                            onClick={() =>
                                                                setEditing(item)
                                                            }
                                                            aria-label="Düzenle"
                                                        >
                                                            <Pencil />
                                                        </Button>
                                                        <Button
                                                            variant="ghost"
                                                            size="icon"
                                                            onClick={() =>
                                                                setDeleting(
                                                                    item,
                                                                )
                                                            }
                                                            aria-label="Sil"
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

            {creating ? (
                <PermissionDialog
                    mode="create"
                    onClose={() => setCreating(false)}
                />
            ) : null}

            {editing ? (
                <PermissionDialog
                    mode="edit"
                    permission={editing}
                    onClose={() => setEditing(null)}
                />
            ) : null}

            <AlertDialog
                open={deleting !== null}
                onOpenChange={(open) => {
                    if (!open) {
setDeleting(null);
}
                }}
            >
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>İzni sil</AlertDialogTitle>
                        <AlertDialogDescription>
                            <span className="font-mono">{deleting?.name}</span>{' '}
                            izni silinecek
                            {deleting && deleting.roles_count > 0
                                ? ` ve ${deleting.roles_count} rolden kaldırılacak`
                                : ''}
                            . Geri alınamaz.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>İptal</AlertDialogCancel>
                        <AlertDialogAction
                            onClick={() => {
                                if (!deleting) {
return;
}

                                router.delete(
                                    PermissionsController.destroy({
                                        permission: deleting.uuid,
                                    }).url,
                                    {
                                        preserveScroll: true,
                                        onFinish: () => setDeleting(null),
                                    },
                                );
                            }}
                        >
                            Sil
                        </AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </>
    );
}

type DialogProps =
    | { mode: 'create'; onClose: () => void }
    | { mode: 'edit'; permission: Permission; onClose: () => void };

function PermissionDialog(props: DialogProps) {
    const isEdit = props.mode === 'edit';
    const initial = isEdit
        ? {
              name: props.permission.name,
              group: props.permission.group ?? '',
              label: props.permission.label ?? '',
          }
        : { name: '', group: '', label: '' };

    const { data, setData, processing, errors, post, put, reset } =
        useForm(initial);

    function submit(e: React.FormEvent) {
        e.preventDefault();

        if (isEdit) {
            put(
                PermissionsController.update({
                    permission: props.permission.uuid,
                }).url,
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        reset();
                        props.onClose();
                    },
                },
            );
        } else {
            post(PermissionsController.store().url, {
                preserveScroll: true,
                onSuccess: () => {
                    reset();
                    props.onClose();
                },
            });
        }
    }

    return (
        <Dialog
            open
            onOpenChange={(open) => {
                if (!open) {
props.onClose();
}
            }}
        >
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>
                        {isEdit ? 'İzni düzenle' : 'Yeni izin'}
                    </DialogTitle>
                    <DialogDescription>
                        {isEdit
                            ? 'Grup ve etiket bilgisi UI metadata içindir; izin adı değiştirilemez.'
                            : 'Rotaya bağlı bir izin için "Rotalardan Keşfet"i kullanmayı düşün.'}
                    </DialogDescription>
                </DialogHeader>

                <form onSubmit={submit} className="flex flex-col gap-4">
                    <div className="grid gap-2">
                        <Label htmlFor="name">İzin adı</Label>
                        <Input
                            id="name"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            disabled={isEdit}
                            placeholder="panel.tools.definitions.units.index"
                            className="font-mono"
                        />
                        <InputError message={errors.name} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="group">Grup</Label>
                        <Input
                            id="group"
                            value={data.group}
                            onChange={(e) => setData('group', e.target.value)}
                            placeholder="Tanımlamalar / Birimler"
                        />
                        <InputError message={errors.group} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="label">Etiket</Label>
                        <Input
                            id="label"
                            value={data.label}
                            onChange={(e) => setData('label', e.target.value)}
                            placeholder="Listele"
                        />
                        <InputError message={errors.label} />
                    </div>

                    <DialogFooter>
                        <Button
                            type="button"
                            variant="outline"
                            onClick={props.onClose}
                        >
                            İptal
                        </Button>
                        <Button type="submit" disabled={processing}>
                            {isEdit ? 'Kaydet' : 'Ekle'}
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
}

PermissionsIndex.layout = {
    breadcrumbs: [{ title: 'Yetkiler', href: dashboard() }],
};
