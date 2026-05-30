import { Form, Head, Link, router } from '@inertiajs/react';
import { Archive, Pencil, Plus, Save, Trash2 } from 'lucide-react';
import { useState } from 'react';

import { ConfirmDelete } from '@/components/confirm-delete';
import { DataPagination } from '@/components/data-pagination';
import Heading from '@/components/heading';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Field, FieldGroup, FieldLabel } from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import { Separator } from '@/components/ui/separator';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import { Switch } from '@/components/ui/switch';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { dashboard } from '@/routes';
import { index as cityIndex } from '@/routes/panel/tools/definitions/countries/cities';
import {
    deleted as districtDeleted,
    destroy as districtDestroy,
    status as districtStatus,
    store as districtStore,
    update as districtUpdate,
} from '@/routes/panel/tools/definitions/countries/cities/districts';
import type { City, Country, District, Paginated, Status } from '@/types';

type Props = {
    districts: Paginated<District>;
    country: { data: Country };
    city: { data: City };
};

function DistrictField({
    name,
    label,
    defaultValue,
    error,
    type = 'text',
    required = true,
    min,
}: {
    name: string;
    label: string;
    defaultValue?: string | number | null;
    error?: string;
    type?: string;
    required?: boolean;
    min?: number;
}) {
    return (
        <Field data-invalid={Boolean(error)}>
            <FieldLabel htmlFor={name}>{label}</FieldLabel>
            <Input
                id={name}
                name={name}
                type={type}
                defaultValue={defaultValue ?? ''}
                required={required}
                min={min}
                aria-invalid={Boolean(error)}
            />
            <InputError message={error} />
        </Field>
    );
}

function DistrictStatusSwitch({
    status,
    url,
}: {
    status: Status;
    url: string;
}) {
    const [processing, setProcessing] = useState(false);

    return (
        <Switch
            size="sm"
            checked={status === 'active'}
            disabled={processing}
            aria-label="İlçe durumunu değiştir"
            onCheckedChange={() => {
                setProcessing(true);

                router.patch(
                    url,
                    {},
                    {
                        preserveScroll: true,
                        onFinish: () => setProcessing(false),
                    },
                );
            }}
        />
    );
}

function DistrictSaveButton({ processing }: { processing?: boolean }) {
    return (
        <Button type="submit" disabled={processing}>
            <Save data-icon="inline-start" />
            Kaydet
        </Button>
    );
}

export default function DistrictIndex({ districts, country, city }: Props) {
    const parentCountry = country.data;
    const parentCity = city.data;
    const parentArgs = { country: parentCountry, city: parentCity };

    return (
        <>
            <Head title={`${parentCity.name} ilçeleri`} />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl">
                <div className="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <Heading
                        variant="small"
                        title={`${parentCity.name} ilçeleri`}
                        description="İlçeler ait oldukları şehir altında yönetilir."
                    />
                    <div className="flex flex-wrap items-center gap-2">
                        <Button variant="outline" asChild>
                            <Link href={cityIndex(parentCountry).url}>
                                Şehirlere dön
                            </Link>
                        </Button>
                        <Button variant="outline" asChild>
                            <Link href={districtDeleted(parentArgs).url}>
                                <Archive data-icon="inline-start" />
                                Silinenler
                            </Link>
                        </Button>
                        <Sheet>
                            <SheetTrigger asChild>
                                <Button>
                                    <Plus data-icon="inline-start" />
                                    Yeni
                                </Button>
                            </SheetTrigger>
                            <SheetContent className="sm:max-w-md">
                                <SheetHeader>
                                    <SheetTitle>İlçe ekle</SheetTitle>
                                    <SheetDescription>
                                        {parentCity.name} için yeni ilçe tanımı
                                        oluşturun.
                                    </SheetDescription>
                                </SheetHeader>
                                <Form
                                    {...districtStore.form(parentArgs)}
                                    options={{ preserveScroll: true }}
                                    className="flex min-h-0 flex-1 flex-col gap-5 overflow-y-auto px-4 pb-4"
                                >
                                    {({ processing, errors }) => (
                                        <>
                                            <FieldGroup>
                                                <input
                                                    type="hidden"
                                                    name="status"
                                                    value="passive"
                                                />
                                                <DistrictField
                                                    name="sort_order"
                                                    label="Sıra No"
                                                    type="number"
                                                    min={0}
                                                    required={false}
                                                    error={errors.sort_order}
                                                />
                                                <DistrictField
                                                    name="name"
                                                    label="Ad"
                                                    error={errors.name}
                                                />
                                            </FieldGroup>
                                            <div className="flex justify-end">
                                                <DistrictSaveButton
                                                    processing={processing}
                                                />
                                            </div>
                                        </>
                                    )}
                                </Form>
                            </SheetContent>
                        </Sheet>
                    </div>
                </div>

                <div className="relative overflow-hidden rounded-xl border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Aktif</TableHead>
                                <TableHead>Sıra No</TableHead>
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
                                    district,
                                };

                                return (
                                    <TableRow key={district.id}>
                                        <TableCell>
                                            <DistrictStatusSwitch
                                                status={district.status}
                                                url={
                                                    districtStatus(routeArgs)
                                                        .url
                                                }
                                            />
                                        </TableCell>
                                        <TableCell>
                                            {district.sort_order}
                                        </TableCell>
                                        <TableCell className="font-medium">
                                            {district.name}
                                        </TableCell>
                                        <TableCell className="text-right">
                                            <Sheet>
                                                <SheetTrigger asChild>
                                                    <Button
                                                        variant="ghost"
                                                        size="icon-sm"
                                                        aria-label="Düzenle"
                                                    >
                                                        <Pencil />
                                                        <span className="sr-only">
                                                            Düzenle
                                                        </span>
                                                    </Button>
                                                </SheetTrigger>
                                                <SheetContent className="sm:max-w-md">
                                                    <SheetHeader>
                                                        <SheetTitle>
                                                            İlçe düzenle
                                                        </SheetTitle>
                                                        <SheetDescription>
                                                            {district.name}{' '}
                                                            kaydını düzenleyin.
                                                        </SheetDescription>
                                                    </SheetHeader>
                                                    <div className="flex min-h-0 flex-1 flex-col gap-6 overflow-y-auto px-4 pb-4">
                                                        <Form
                                                            {...districtUpdate.form(
                                                                routeArgs,
                                                            )}
                                                            options={{
                                                                preserveScroll: true,
                                                            }}
                                                            className="flex flex-col gap-5"
                                                        >
                                                            {({
                                                                processing,
                                                                errors,
                                                            }) => (
                                                                <>
                                                                    <FieldGroup>
                                                                        <DistrictField
                                                                            name="sort_order"
                                                                            label="Sıra No"
                                                                            type="number"
                                                                            min={
                                                                                0
                                                                            }
                                                                            required={
                                                                                false
                                                                            }
                                                                            defaultValue={
                                                                                district.sort_order
                                                                            }
                                                                            error={
                                                                                errors.sort_order
                                                                            }
                                                                        />
                                                                        <DistrictField
                                                                            name="name"
                                                                            label="Ad"
                                                                            defaultValue={
                                                                                district.name
                                                                            }
                                                                            error={
                                                                                errors.name
                                                                            }
                                                                        />
                                                                    </FieldGroup>
                                                                    <div className="flex justify-end">
                                                                        <DistrictSaveButton
                                                                            processing={
                                                                                processing
                                                                            }
                                                                        />
                                                                    </div>
                                                                </>
                                                            )}
                                                        </Form>
                                                        <Separator />
                                                        <div className="flex flex-col gap-3">
                                                            <div className="flex flex-col gap-1">
                                                                <div className="text-sm font-medium">
                                                                    Kaydı sil
                                                                </div>
                                                                <p className="text-sm text-muted-foreground">
                                                                    Silinen
                                                                    ilçe,
                                                                    silinenler
                                                                    sayfasından
                                                                    geri
                                                                    alınabilir.
                                                                </p>
                                                            </div>
                                                            <div className="flex justify-end">
                                                                <ConfirmDelete
                                                                    action={districtDestroy(
                                                                        routeArgs,
                                                                    )}
                                                                    title={`${district.name} ilçesi silinsin mi?`}
                                                                    description="Silinen ilçe, silinenler sayfasından geri alınabilir."
                                                                >
                                                                    <Button variant="destructive">
                                                                        <Trash2 data-icon="inline-start" />
                                                                        Kaydı
                                                                        sil
                                                                    </Button>
                                                                </ConfirmDelete>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </SheetContent>
                                            </Sheet>
                                        </TableCell>
                                    </TableRow>
                                );
                            })}

                            {districts.data.length === 0 && (
                                <TableRow>
                                    <TableCell
                                        colSpan={4}
                                        className="h-24 text-center text-muted-foreground"
                                    >
                                        İlçe kaydı bulunamadı.
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

DistrictIndex.layout = {
    breadcrumbs: [
        {
            title: 'İlçeler',
            href: dashboard(),
        },
    ],
};
