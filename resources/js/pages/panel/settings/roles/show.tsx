import { Form, Head } from '@inertiajs/react';
import { CheckCheck, Save, Trash2, X } from 'lucide-react';
import { useState } from 'react';
import RolesController from '@/actions/App/Http/Controllers/Panel/Settings/Roles/RolesController';
import InputError from '@/components/input-error';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { index } from '@/routes/panel/settings/roles';

type PermissionRow = {
    name: string;
    label: string;
};

type RoleDetail = {
    uuid: string;
    name: string;
    is_system: boolean;
    permissions: string[];
    users_count?: number;
};

type Props = {
    role: { data: RoleDetail };
    permissionGroups: Record<string, PermissionRow[]>;
    isSystem: boolean;
};

export default function ShowRole({ role, permissionGroups, isSystem }: Props) {
    const current = role.data;
    const [selected, setSelected] = useState<Set<string>>(
        new Set(current.permissions),
    );
    const [deleteOpen, setDeleteOpen] = useState(false);

    const toggle = (name: string) => {
        setSelected((prev) => {
            const next = new Set(prev);

            if (next.has(name)) {
                next.delete(name);
            } else {
                next.add(name);
            }

            return next;
        });
    };

    const toggleGroup = (rows: PermissionRow[]) => {
        const allSelected = rows.every((r) => selected.has(r.name));
        setSelected((prev) => {
            const next = new Set(prev);

            if (allSelected) {
                rows.forEach((r) => next.delete(r.name));
            } else {
                rows.forEach((r) => next.add(r.name));
            }

            return next;
        });
    };

    return (
        <>
            <Head title={current.name} />

            <div className="flex max-w-4xl flex-col gap-6">
                <div className="flex flex-col gap-1">
                    <div className="flex flex-wrap items-center gap-2">
                        <h2 className="text-lg font-semibold">
                            {current.name}
                        </h2>
                        {isSystem && (
                            <Badge variant="secondary">Sistem rolü</Badge>
                        )}
                    </div>
                    <p className="text-sm text-muted-foreground">
                        {isSystem
                            ? 'Sistem rolleri silinemez. İzinleri düzenleyebilirsiniz.'
                            : 'Rol adını ve izinleri güncelleyin.'}
                    </p>
                </div>

                <Form
                    {...RolesController.update.form(current.uuid)}
                    options={{ preserveScroll: true }}
                    className="flex flex-col gap-6"
                >
                    {({ errors, processing }) => (
                        <>
                            {Array.from(selected).map((name) => (
                                <input
                                    key={name}
                                    type="hidden"
                                    name="permissions[]"
                                    value={name}
                                />
                            ))}

                            <div className="grid gap-2">
                                <Label htmlFor="name">Rol adı</Label>
                                <Input
                                    id="name"
                                    name="name"
                                    defaultValue={current.name}
                                    required
                                    disabled={isSystem}
                                    aria-invalid={Boolean(errors.name)}
                                />
                                <InputError message={errors.name} />
                            </div>

                            <div className="flex flex-col gap-4">
                                <Label>İzinler</Label>
                                <InputError message={errors.permissions} />

                                {Object.entries(permissionGroups).map(
                                    ([group, rows]) => {
                                        const allSelected = rows.every((r) =>
                                            selected.has(r.name),
                                        );

                                        return (
                                            <div
                                                key={group}
                                                className="flex flex-col gap-3 rounded-lg border p-4"
                                            >
                                                <div className="flex items-center justify-between">
                                                    <h3 className="text-sm font-semibold">
                                                        {group}
                                                    </h3>
                                                    <Button
                                                        type="button"
                                                        variant="ghost"
                                                        size="sm"
                                                        onClick={() =>
                                                            toggleGroup(rows)
                                                        }
                                                    >
                                                        {allSelected ? (
                                                            <X />
                                                        ) : (
                                                            <CheckCheck />
                                                        )}
                                                        {allSelected
                                                            ? 'Tümünü Kaldır'
                                                            : 'Tümünü Seç'}
                                                    </Button>
                                                </div>
                                                <div className="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                                                    {rows.map((row) => (
                                                        <label
                                                            key={row.name}
                                                            className="flex items-start gap-2 text-sm"
                                                        >
                                                            <Checkbox
                                                                checked={selected.has(
                                                                    row.name,
                                                                )}
                                                                onCheckedChange={() =>
                                                                    toggle(
                                                                        row.name,
                                                                    )
                                                                }
                                                            />
                                                            <span>
                                                                {row.label}
                                                            </span>
                                                        </label>
                                                    ))}
                                                </div>
                                            </div>
                                        );
                                    },
                                )}
                            </div>

                            <div className="flex justify-between gap-2">
                                {!isSystem ? (
                                    <Button
                                        type="button"
                                        variant="destructive"
                                        onClick={() => setDeleteOpen(true)}
                                    >
                                        <Trash2 data-icon="inline-start" />
                                        Rolü Sil
                                    </Button>
                                ) : (
                                    <span />
                                )}
                                <Button type="submit" disabled={processing}>
                                    {processing ? <Spinner /> : <Save />}
                                    Değişiklikleri kaydet
                                </Button>
                            </div>
                        </>
                    )}
                </Form>
            </div>

            <Dialog open={deleteOpen} onOpenChange={setDeleteOpen}>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Rolü sil</DialogTitle>
                        <DialogDescription>
                            "{current.name}" rolünü silmek istediğinize emin
                            misiniz? Bu role atanmış kullanıcılar varsa işlem
                            engellenir.
                        </DialogDescription>
                    </DialogHeader>
                    <Form
                        {...RolesController.destroy.form(current.uuid)}
                        onSuccess={() => setDeleteOpen(false)}
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
                                <Button
                                    type="submit"
                                    variant="destructive"
                                    disabled={processing}
                                >
                                    {processing ? <Spinner /> : <Trash2 />}
                                    Sil
                                </Button>
                            </DialogFooter>
                        )}
                    </Form>
                </DialogContent>
            </Dialog>
        </>
    );
}

ShowRole.layout = {
    breadcrumbs: [
        {
            title: 'Roller ve Yetkiler',
            href: index(),
        },
        {
            title: 'Detay',
            href: '#',
        },
    ],
};
