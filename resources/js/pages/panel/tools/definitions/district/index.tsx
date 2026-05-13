import { Form, Head, Link, router } from '@inertiajs/react';
import { Archive, Pencil, Plus, Save, Trash2 } from 'lucide-react';
import { useState } from 'react';

import Heading from '@/components/heading';
import InputError from '@/components/input-error';
import { Button, buttonVariants } from '@/components/ui/button';
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
import { cn } from '@/lib/utils';
import { dashboard } from '@/routes';
import { index as cityIndex } from '@/routes/panel/tools/definitions/countries/cities';
import {
    deleted as districtDeleted,
    destroy as districtDestroy,
    status as districtStatus,
    store as districtStore,
    update as districtUpdate,
} from '@/routes/panel/tools/definitions/countries/cities/districts';
import type {
    City,
    Country,
    District,
    Paginated,
    PaginationLink,
    Status,
} from '@/types';

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

function DistrictPagination({ districts }: { districts: Paginated<District> }) {
    const links = districts.links.filter(
        (link: PaginationLink) => link.url !== null || link.active,
    );

    if (links.length <= 1) {
        return null;
    }

    return (
        <div className="flex flex-wrap items-center justify-between gap-3">
            <div className="text-sm text-muted-foreground">
                Toplam {districts.meta?.total ?? districts.total ?? 0} kayıt
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
                                    className="flex flex-col gap-5 px-4"
                                >
                                    {({ processing, errors }) => (
                                        <>
                                            <FieldGroup>
                                                <input
                                                    type="hidden"
                                                    name="status"
                                                    value="active"
                                                />
                                                <DistrictField
                                                    name="name"
                                                    label="Ad"
                                                    error={errors.name}
                                                />
                                                <DistrictField
                                                    name="sort_order"
                                                    label="Sıra"
                                                    type="number"
                                                    min={0}
                                                    required={false}
                                                    error={errors.sort_order}
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
                                <TableHead>Ad</TableHead>
                                <TableHead className="text-right">
                                    Sıra
                                </TableHead>
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
                                        <TableCell className="font-medium">
                                            {district.name}
                                        </TableCell>
                                        <TableCell className="text-right">
                                            {district.sort_order}
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
                                                    <div className="flex flex-col gap-6 px-4">
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
                                                                        <input
                                                                            type="hidden"
                                                                            name="status"
                                                                            value={
                                                                                district.status
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
                                                                        <DistrictField
                                                                            name="sort_order"
                                                                            label="Sıra"
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
                                                            <Form
                                                                {...districtDestroy.form(
                                                                    routeArgs,
                                                                )}
                                                                options={{
                                                                    preserveScroll: true,
                                                                }}
                                                                className="flex justify-end"
                                                            >
                                                                {({
                                                                    processing,
                                                                }) => (
                                                                    <Button
                                                                        type="submit"
                                                                        variant="destructive"
                                                                        disabled={
                                                                            processing
                                                                        }
                                                                    >
                                                                        <Trash2 data-icon="inline-start" />
                                                                        Kaydı
                                                                        sil
                                                                    </Button>
                                                                )}
                                                            </Form>
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

                <DistrictPagination districts={districts} />
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
