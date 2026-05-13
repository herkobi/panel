import { Form, Head, Link } from '@inertiajs/react';
import { RotateCcw, Trash2 } from 'lucide-react';

import Heading from '@/components/heading';
import { Button, buttonVariants } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { cn } from '@/lib/utils';
import {
    forceDelete as taxForceDelete,
    index as taxIndex,
    restore as taxRestore,
} from '@/routes/panel/tools/definitions/taxes';
import type { Paginated, PaginationLink, Tax } from '@/types';

type Props = {
    taxes: Paginated<Tax>;
};

function TaxDeletedPagination({ taxes }: { taxes: Paginated<Tax> }) {
    const links = taxes.links.filter(
        (link: PaginationLink) => link.url !== null || link.active,
    );

    if (links.length <= 1) {
        return null;
    }

    return (
        <div className="flex flex-wrap items-center justify-between gap-3">
            <div className="text-sm text-muted-foreground">
                Toplam {taxes.meta?.total ?? taxes.total ?? 0} kayıt
            </div>
            <div className="flex flex-wrap items-center gap-1">
                {links.map((link) => (
                    <Link
                        key={`${link.label}-${link.url ?? 'current'}`}
                        href={link.url ?? '#'}
                        className={cn(
                            buttonVariants({
                                variant: link.active ? 'outline' : 'ghost',
                                size: 'sm',
                            }),
                            !link.url && 'pointer-events-none opacity-50',
                        )}
                    >
                        {link.label
                            .replace('&laquo;', 'Önceki')
                            .replace('&raquo;', 'Sonraki')
                            .trim()}
                    </Link>
                ))}
            </div>
        </div>
    );
}

export default function TaxDeleted({ taxes }: Props) {
    return (
        <>
            <Head title="Silinen vergi oranları" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl">
                <div className="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <Heading
                        variant="small"
                        title="Silinen vergi oranları"
                        description="Silinen vergi oranlarını geri alın veya kalıcı silin."
                    />
                    <Button variant="outline" asChild>
                        <Link href={taxIndex().url}>Listeye dön</Link>
                    </Button>
                </div>

                <div className="relative overflow-hidden rounded-xl border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Ad</TableHead>
                                <TableHead>Oran</TableHead>
                                <TableHead className="text-right">
                                    İşlem
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {taxes.data.map((tax) => (
                                <TableRow key={tax.id}>
                                    <TableCell className="font-medium">
                                        {tax.name}
                                    </TableCell>
                                    <TableCell>%{tax.rate}</TableCell>
                                    <TableCell>
                                        <div className="flex justify-end gap-2">
                                            <Form
                                                {...taxRestore.form(tax.id)}
                                                options={{
                                                    preserveScroll: true,
                                                }}
                                            >
                                                {({ processing }) => (
                                                    <Button
                                                        type="submit"
                                                        variant="outline"
                                                        size="sm"
                                                        disabled={processing}
                                                    >
                                                        <RotateCcw data-icon="inline-start" />
                                                        Geri al
                                                    </Button>
                                                )}
                                            </Form>
                                            <Form
                                                {...taxForceDelete.form(tax.id)}
                                                options={{
                                                    preserveScroll: true,
                                                }}
                                            >
                                                {({ processing }) => (
                                                    <Button
                                                        type="submit"
                                                        variant="destructive"
                                                        size="sm"
                                                        disabled={processing}
                                                    >
                                                        <Trash2 data-icon="inline-start" />
                                                        Kalıcı sil
                                                    </Button>
                                                )}
                                            </Form>
                                        </div>
                                    </TableCell>
                                </TableRow>
                            ))}

                            {taxes.data.length === 0 && (
                                <TableRow>
                                    <TableCell
                                        colSpan={3}
                                        className="h-24 text-center text-muted-foreground"
                                    >
                                        Silinen vergi oranı kaydı bulunamadı.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>

                <TaxDeletedPagination taxes={taxes} />
            </div>
        </>
    );
}
