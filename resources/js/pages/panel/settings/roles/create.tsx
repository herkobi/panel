import { Form, Head } from '@inertiajs/react';
import { useState } from 'react';
import RolesController from '@/actions/App/Http/Controllers/Panel/Settings/Roles/RolesController';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { create, index } from '@/routes/panel/settings/roles';

type PermissionRow = {
    name: string;
    label: string;
};

type Props = {
    permissionGroups: Record<string, PermissionRow[]>;
};

export default function CreateRole({ permissionGroups }: Props) {
    const [selected, setSelected] = useState<Set<string>>(new Set());

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
            <Head title="Yeni Rol" />

            <div className="flex max-w-4xl flex-col gap-6">
                <div className="flex flex-col gap-1">
                    <h2 className="text-lg font-semibold">Yeni Rol</h2>
                    <p className="text-sm text-muted-foreground">
                        Rol adını belirleyin ve atanacak izinleri seçin.
                    </p>
                </div>

                <Form
                    {...RolesController.store.form()}
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
                                    required
                                    placeholder="Editor"
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

                            <div className="flex justify-end">
                                <Button type="submit" disabled={processing}>
                                    {processing && <Spinner />}
                                    Rol oluştur
                                </Button>
                            </div>
                        </>
                    )}
                </Form>
            </div>
        </>
    );
}

CreateRole.layout = {
    breadcrumbs: [
        {
            title: 'Roller ve Yetkiler',
            href: index(),
        },
        {
            title: 'Yeni Rol',
            href: create(),
        },
    ],
};
