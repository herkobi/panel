import { Head, Link, router } from '@inertiajs/react';
import { ArrowLeft, CheckSquare, Square } from 'lucide-react';
import { useState } from 'react';

import PermissionsController from '@/actions/App/Http/Controllers/Panel/Settings/Permissions/PermissionsController';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
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

type DiscoverableRoute = {
    name: string;
    suggested_group: string;
    suggested_label: string;
};

type Props = {
    routes: DiscoverableRoute[];
};

export default function PermissionsDiscover({ routes }: Props) {
    const [selected, setSelected] = useState<Set<string>>(new Set());
    const [processing, setProcessing] = useState(false);

    const allSelected = routes.length > 0 && selected.size === routes.length;

    function toggle(name: string) {
        setSelected((prev) => {
            const next = new Set(prev);

            if (next.has(name)) {
                next.delete(name);
            } else {
                next.add(name);
            }

            return next;
        });
    }

    function toggleAll() {
        if (allSelected) {
            setSelected(new Set());
        } else {
            setSelected(new Set(routes.map((r) => r.name)));
        }
    }

    function submit() {
        if (selected.size === 0) {
            return;
        }

        setProcessing(true);
        router.post(
            PermissionsController.bulkStore().url,
            { names: Array.from(selected) },
            {
                preserveScroll: true,
                onFinish: () => setProcessing(false),
            },
        );
    }

    return (
        <>
            <Head title="Rotalardan Keşfet" />

            <div className="flex flex-col gap-6 p-4">
                <div className="flex flex-wrap items-start justify-between gap-3 border-b pb-4">
                    <Heading
                        variant="small"
                        title="Rotalardan Keşfet"
                        description="DB'de henüz izin satırı olmayan panel rotaları. Seçtiklerini toplu olarak izin tablosuna ekle (grup/etiket otomatik türetilir, sonra düzenleyebilirsin)."
                    />
                    <Button asChild variant="outline">
                        <Link href={permissionsIndex().url}>
                            <ArrowLeft data-icon="inline-start" />
                            Listeye dön
                        </Link>
                    </Button>
                </div>

                {routes.length === 0 ? (
                    <div className="rounded-md border border-dashed p-8 text-center text-sm text-muted-foreground">
                        Eklenmemiş panel rotası yok. Tüm rotalar zaten izin
                        tablosunda.
                    </div>
                ) : (
                    <>
                        <div className="rounded-md border">
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead className="w-12">
                                            <button
                                                type="button"
                                                onClick={toggleAll}
                                                aria-label={
                                                    allSelected
                                                        ? 'Tümünü kaldır'
                                                        : 'Tümünü seç'
                                                }
                                                className="text-muted-foreground hover:text-foreground"
                                            >
                                                {allSelected ? (
                                                    <CheckSquare className="size-4" />
                                                ) : (
                                                    <Square className="size-4" />
                                                )}
                                            </button>
                                        </TableHead>
                                        <TableHead className="font-mono">
                                            Rota Adı
                                        </TableHead>
                                        <TableHead>Önerilen Grup</TableHead>
                                        <TableHead>Önerilen Etiket</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {routes.map((route) => (
                                        <TableRow key={route.name}>
                                            <TableCell>
                                                <Checkbox
                                                    checked={selected.has(
                                                        route.name,
                                                    )}
                                                    onCheckedChange={() =>
                                                        toggle(route.name)
                                                    }
                                                />
                                            </TableCell>
                                            <TableCell className="font-mono text-xs">
                                                {route.name}
                                            </TableCell>
                                            <TableCell className="text-sm text-muted-foreground">
                                                {route.suggested_group}
                                            </TableCell>
                                            <TableCell className="text-sm text-muted-foreground">
                                                {route.suggested_label}
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </div>

                        <div className="flex items-center justify-between">
                            <p className="text-sm text-muted-foreground">
                                {selected.size} / {routes.length} seçili
                            </p>
                            <Button
                                onClick={submit}
                                disabled={processing || selected.size === 0}
                            >
                                Seçilenleri Ekle
                            </Button>
                        </div>
                    </>
                )}
            </div>
        </>
    );
}

PermissionsDiscover.layout = {
    breadcrumbs: [{ title: 'Yetkiler', href: dashboard() }],
};
