import { Form, Head, Link, router } from '@inertiajs/react';
import { Archive, MapPinned, Pencil, Plus, Save, Trash2 } from 'lucide-react';
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
import { index as countryIndex } from '@/routes/panel/tools/definitions/countries';
import {
    deleted as cityDeleted,
    destroy as cityDestroy,
    status as cityStatus,
    store as cityStore,
    update as cityUpdate,
} from '@/routes/panel/tools/definitions/countries/cities';
import { index as districtIndex } from '@/routes/panel/tools/definitions/countries/cities/districts';
import type { City, Country, Paginated, Status } from '@/types';

type Props = {
    cities: Paginated<City>;
    country: { data: Country };
};

function CityField({
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

function CityStatusSwitch({ status, url }: { status: Status; url: string }) {
    const [processing, setProcessing] = useState(false);

    return (
        <Switch
            size="sm"
            checked={status === 'active'}
            disabled={processing}
            aria-label="Şehir durumunu değiştir"
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

function CitySaveButton({ processing }: { processing?: boolean }) {
    return (
        <Button type="submit" disabled={processing}>
            <Save data-icon="inline-start" />
            Kaydet
        </Button>
    );
}

export default function CityIndex({ cities, country }: Props) {
    const parent = country.data;

    return (
        <>
            <Head title={`${parent.name} şehirleri`} />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl">
                <div className="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <Heading
                        variant="small"
                        title={`${parent.name} şehirleri`}
                        description="Şehirler ait oldukları ülke altında yönetilir."
                    />
                    <div className="flex flex-wrap items-center gap-2">
                        <Button variant="outline" asChild>
                            <Link href={countryIndex().url}>Ülkelere dön</Link>
                        </Button>
                        <Button variant="outline" asChild>
                            <Link href={cityDeleted(parent).url}>
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
                                    <SheetTitle>Şehir ekle</SheetTitle>
                                    <SheetDescription>
                                        {parent.name} için yeni şehir tanımı
                                        oluşturun.
                                    </SheetDescription>
                                </SheetHeader>
                                <Form
                                    {...cityStore.form(parent)}
                                    options={{ preserveScroll: true }}
                                    className="flex flex-1 min-h-0 flex-col gap-5 overflow-y-auto px-4 pb-4"
                                >
                                    {({ processing, errors }) => (
                                        <>
                                            <FieldGroup>
                                                <input
                                                    type="hidden"
                                                    name="status"
                                                    value="passive"
                                                />
                                                <div className="grid grid-cols-2 gap-3">
                                                    <CityField
                                                        name="sort_order"
                                                        label="Sıra No"
                                                        type="number"
                                                        min={0}
                                                        required={false}
                                                        error={errors.sort_order}
                                                    />
                                                    <CityField
                                                        name="code"
                                                        label="Kod"
                                                        error={errors.code}
                                                    />
                                                </div>
                                                <CityField
                                                    name="name"
                                                    label="Ad"
                                                    error={errors.name}
                                                />
                                            </FieldGroup>
                                            <div className="flex justify-end">
                                                <CitySaveButton
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
                                <TableHead>Kod</TableHead>
                                <TableHead>Ad</TableHead>
                                <TableHead className="text-right">
                                    İşlem
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {cities.data.map((city) => {
                                const routeArgs = { country: parent, city };

                                return (
                                    <TableRow key={city.id}>
                                        <TableCell>
                                            <CityStatusSwitch
                                                status={city.status}
                                                url={cityStatus(routeArgs).url}
                                            />
                                        </TableCell>
                                        <TableCell>{city.sort_order}</TableCell>
                                        <TableCell className="font-medium">
                                            {city.code}
                                        </TableCell>
                                        <TableCell>{city.name}</TableCell>
                                        <TableCell>
                                            <div className="flex justify-end gap-2">
                                                <Button
                                                    variant="outline"
                                                    size="sm"
                                                    asChild
                                                >
                                                    <Link
                                                        href={
                                                            districtIndex(
                                                                routeArgs,
                                                            ).url
                                                        }
                                                    >
                                                        <MapPinned data-icon="inline-start" />
                                                        İlçeler
                                                    </Link>
                                                </Button>
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
                                                                Şehir düzenle
                                                            </SheetTitle>
                                                            <SheetDescription>
                                                                {city.name}{' '}
                                                                kaydını
                                                                düzenleyin.
                                                            </SheetDescription>
                                                        </SheetHeader>
                                                        <div className="flex flex-1 min-h-0 flex-col gap-6 overflow-y-auto px-4 pb-4">
                                                            <Form
                                                                {...cityUpdate.form(
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
                                                                            <div className="grid grid-cols-2 gap-3">
                                                                                <CityField
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
                                                                                        city.sort_order
                                                                                    }
                                                                                    error={
                                                                                        errors.sort_order
                                                                                    }
                                                                                />
                                                                                <CityField
                                                                                    name="code"
                                                                                    label="Kod"
                                                                                    defaultValue={
                                                                                        city.code
                                                                                    }
                                                                                    error={
                                                                                        errors.code
                                                                                    }
                                                                                />
                                                                            </div>
                                                                            <CityField
                                                                                name="name"
                                                                                label="Ad"
                                                                                defaultValue={
                                                                                    city.name
                                                                                }
                                                                                error={
                                                                                    errors.name
                                                                                }
                                                                            />
                                                                        </FieldGroup>
                                                                        <div className="flex justify-end">
                                                                            <CitySaveButton
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
                                                                        Kaydı
                                                                        sil
                                                                    </div>
                                                                    <p className="text-sm text-muted-foreground">
                                                                        Silinen
                                                                        şehir,
                                                                        silinenler
                                                                        sayfasından
                                                                        geri
                                                                        alınabilir.
                                                                    </p>
                                                                </div>
                                                                <div className="flex justify-end">
                                                                    <ConfirmDelete
                                                                        action={cityDestroy(
                                                                            routeArgs,
                                                                        )}
                                                                        title={`${city.name} şehri silinsin mi?`}
                                                                        description="Silinen şehir, silinenler sayfasından geri alınabilir."
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
                                            </div>
                                        </TableCell>
                                    </TableRow>
                                );
                            })}

                            {cities.data.length === 0 && (
                                <TableRow>
                                    <TableCell
                                        colSpan={5}
                                        className="h-24 text-center text-muted-foreground"
                                    >
                                        Şehir kaydı bulunamadı.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>

                <DataPagination paginator={cities} showRange={false} />
            </div>
        </>
    );
}

CityIndex.layout = {
    breadcrumbs: [
        {
            title: 'Şehirler',
            href: dashboard(),
        },
    ],
};
