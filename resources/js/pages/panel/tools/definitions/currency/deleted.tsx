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
    forceDelete as currencyForceDelete,
    index as currencyIndex,
    restore as currencyRestore,
} from '@/routes/panel/tools/definitions/currencies';
import type { Currency, Paginated, PaginationLink } from '@/types';

type Props = {
    currencies: Paginated<Currency>;
};

function CurrencyDeletedPagination({
    currencies,
}: {
    currencies: Paginated<Currency>;
}) {
    const links = currencies.links.filter(
        (link: PaginationLink) => link.url !== null || link.active,
    );

    if (links.length <= 1) {
        return null;
    }

    return (
        <div className="flex flex-wrap items-center justify-between gap-3">
            <div className="text-sm text-muted-foreground">
                Toplam {currencies.meta?.total ?? currencies.total ?? 0} kayıt
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

export default function CurrencyDeleted({ currencies }: Props) {
    return (
        <>
            <Head title="Silinen para birimleri" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl">
                <div className="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <Heading
                        variant="small"
                        title="Silinen para birimleri"
                        description="Silinen para birimlerini geri alın veya kalıcı silin."
                    />
                    <Button variant="outline" asChild>
                        <Link href={currencyIndex().url}>Listeye dön</Link>
                    </Button>
                </div>

                <div className="relative overflow-hidden rounded-xl border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Kod</TableHead>
                                <TableHead>Ad</TableHead>
                                <TableHead>Sembol</TableHead>
                                <TableHead className="text-right">
                                    İşlem
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {currencies.data.map((currency) => (
                                <TableRow key={currency.id}>
                                    <TableCell className="font-medium">
                                        {currency.code}
                                    </TableCell>
                                    <TableCell>{currency.name}</TableCell>
                                    <TableCell>{currency.symbol}</TableCell>
                                    <TableCell>
                                        <div className="flex justify-end gap-2">
                                            <Form
                                                {...currencyRestore.form(
                                                    currency.id,
                                                )}
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
                                                {...currencyForceDelete.form(
                                                    currency.id,
                                                )}
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

                            {currencies.data.length === 0 && (
                                <TableRow>
                                    <TableCell
                                        colSpan={4}
                                        className="h-24 text-center text-muted-foreground"
                                    >
                                        Silinen para birimi kaydı bulunamadı.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>

                <CurrencyDeletedPagination currencies={currencies} />
            </div>
        </>
    );
}
