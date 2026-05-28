import { Form, Head, Link } from '@inertiajs/react';
import { RotateCcw, Trash2 } from 'lucide-react';

import { ConfirmDelete } from '@/components/confirm-delete';
import { DataPagination } from '@/components/data-pagination';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    forceDelete as countryForceDelete,
    index as countryIndex,
    restore as countryRestore,
} from '@/routes/panel/tools/definitions/countries';
import type { Country, Paginated } from '@/types';

type Props = {
    countries: Paginated<Country>;
};

export default function CountryDeleted({ countries }: Props) {
    return (
        <>
            <Head title="Silinen ülkeler" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl">
                <div className="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <Heading
                        variant="small"
                        title="Silinen ülkeler"
                        description="Silinen ülke kayıtlarını geri alın veya kalıcı silin."
                    />
                    <Button variant="outline" asChild>
                        <Link href={countryIndex().url}>Listeye dön</Link>
                    </Button>
                </div>

                <div className="relative overflow-hidden rounded-xl border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Kod</TableHead>
                                <TableHead>Ad</TableHead>
                                <TableHead className="text-right">
                                    İşlem
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {countries.data.map((country) => (
                                <TableRow key={country.id}>
                                    <TableCell className="font-medium">
                                        {country.code}
                                    </TableCell>
                                    <TableCell>{country.name}</TableCell>
                                    <TableCell>
                                        <div className="flex justify-end gap-2">
                                            <Form
                                                {...countryRestore.form(
                                                    country.id,
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
                                            <ConfirmDelete
                                                action={countryForceDelete(
                                                    country.id,
                                                )}
                                                title={`${country.name} kalıcı silinsin mi?`}
                                                description="Bu işlem geri alınamaz; kayıt veritabanından tamamen kaldırılır."
                                                confirmLabel="Kalıcı sil"
                                            >
                                                <Button
                                                    variant="destructive"
                                                    size="sm"
                                                >
                                                    <Trash2 data-icon="inline-start" />
                                                    Kalıcı sil
                                                </Button>
                                            </ConfirmDelete>
                                        </div>
                                    </TableCell>
                                </TableRow>
                            ))}

                            {countries.data.length === 0 && (
                                <TableRow>
                                    <TableCell
                                        colSpan={3}
                                        className="h-24 text-center text-muted-foreground"
                                    >
                                        Silinen ülke kaydı bulunamadı.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>

                <DataPagination paginator={countries} showRange={false} />
            </div>
        </>
    );
}
