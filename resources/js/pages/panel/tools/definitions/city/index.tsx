import { Form, Head, Link, router } from '@inertiajs/react';
import { Archive, MapPinned, Pencil, Plus, Save, Trash2 } from 'lucide-react';
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
import { index as countryIndex } from '@/routes/panel/tools/definitions/countries';
import {
    deleted as cityDeleted,
    destroy as cityDestroy,
    status as cityStatus,
    store as cityStore,
    update as cityUpdate,
} from '@/routes/panel/tools/definitions/countries/cities';
import { index as districtIndex } from '@/routes/panel/tools/definitions/countries/cities/districts';
import type { City, Country, Paginated, PaginationLink, Status } from '@/types';

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

function CityPagination({ cities }: { cities: Paginated<City> }) {
    const links = cities.links.filter(
        (link: PaginationLink) => link.url !== null || link.active,
    );

    if (links.length <= 1) {
        return null;
    }

    return (
        <div className="flex flex-wrap items-center justify-between gap-3">
            <div className="text-sm text-muted-foreground">
                Toplam {cities.meta?.total ?? cities.total ?? 0} kayıt
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
                                                <CityField
                                                    name="code"
                                                    label="Kod"
                                                    error={errors.code}
                                                />
                                                <CityField
                                                    name="name"
                                                    label="Ad"
                                                    error={errors.name}
                                                />
                                                <CityField
                                                    name="sort_order"
                                                    label="Sıra"
                                                    type="number"
                                                    min={0}
                                                    required={false}
                                                    error={errors.sort_order}
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
                                <TableHead>Kod</TableHead>
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
                                        <TableCell className="font-medium">
                                            {city.code}
                                        </TableCell>
                                        <TableCell>{city.name}</TableCell>
                                        <TableCell className="text-right">
                                            {city.sort_order}
                                        </TableCell>
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
                                                        <div className="flex flex-col gap-6 px-4">
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
                                                                            <input
                                                                                type="hidden"
                                                                                name="status"
                                                                                value={
                                                                                    city.status
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
                                                                            <CityField
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
                                                                                    city.sort_order
                                                                                }
                                                                                error={
                                                                                    errors.sort_order
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
                                                                <Form
                                                                    {...cityDestroy.form(
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

                <CityPagination cities={cities} />
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
