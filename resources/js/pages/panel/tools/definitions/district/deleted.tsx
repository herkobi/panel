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
import { index as districtIndex } from '@/routes/panel/tools/definitions/countries/cities/districts';
import {
    forceDelete as districtForceDelete,
    restore as districtRestore,
} from '@/routes/panel/tools/definitions/countries/cities/districts';
import type { City, Country, District, Paginated } from '@/types';

type Props = {
    districts: Paginated<District>;
    country: { data: Country };
    city: { data: City };
};

export default function DistrictDeleted({ districts, country, city }: Props) {
    const parentCountry = country.data;
    const parentCity = city.data;
    const parentArgs = { country: parentCountry, city: parentCity };

    return (
        <>
            <Head title={`${parentCity.name} silinen ilçeler`} />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl">
                <div className="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <Heading
                        variant="small"
                        title={`${parentCity.name} silinen ilçeler`}
                        description="Silinen ilçe kayıtlarını geri alın veya kalıcı silin."
                    />
                    <Button variant="outline" asChild>
                        <Link href={districtIndex(parentArgs).url}>
                            Listeye dön
                        </Link>
                    </Button>
                </div>

                <div className="relative overflow-hidden rounded-xl border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Ad</TableHead>
                                <TableHead className="text-right">
                                    İşlem
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {districts.data.map((district) => {
                                const routeArgs = {
                                    ...parentArgs,
                                    district: district.id,
                                };

                                return (
                                    <TableRow key={district.id}>
                                        <TableCell className="font-medium">
                                            {district.name}
                                        </TableCell>
                                        <TableCell>
                                            <div className="flex justify-end gap-2">
                                                <Form
                                                    {...districtRestore.form(
                                                        routeArgs,
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
                                                            disabled={
                                                                processing
                                                            }
                                                        >
                                                            <RotateCcw data-icon="inline-start" />
                                                            Geri al
                                                        </Button>
                                                    )}
                                                </Form>
                                                <ConfirmDelete
                                                    action={districtForceDelete(
                                                        routeArgs,
                                                    )}
                                                    title={`${district.name} kalıcı silinsin mi?`}
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
                                );
                            })}

                            {districts.data.length === 0 && (
                                <TableRow>
                                    <TableCell
                                        colSpan={2}
                                        className="h-24 text-center text-muted-foreground"
                                    >
                                        Silinen ilçe kaydı bulunamadı.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>

                <DataPagination paginator={districts} showRange={false} />
            </div>
        </>
    );
}
