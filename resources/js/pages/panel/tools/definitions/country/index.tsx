import { Form, Head, Link, router } from '@inertiajs/react';
import { Archive, MapPinned, Pencil, Plus, Save, Trash2 } from 'lucide-react';
import { useState } from 'react';

import { ConfirmDelete } from '@/components/confirm-delete';
import { DataPagination } from '@/components/data-pagination';
import Heading from '@/components/heading';
import InputError from '@/components/input-error';
import { Badge } from '@/components/ui/badge';
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
import {
    deleted as countryDeleted,
    destroy as countryDestroy,
    status as countryStatus,
    store as countryStore,
    update as countryUpdate,
} from '@/routes/panel/tools/definitions/countries';
import { index as cityIndex } from '@/routes/panel/tools/definitions/countries/cities';
import type { Country, Paginated, Status } from '@/types';

type Props = {
    countries: Paginated<Country>;
    defaults: {
        default_country_id: string | null;
    };
};

function CountryField({
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

function CountryStatusSwitch({ status, url }: { status: Status; url: string }) {
    const [processing, setProcessing] = useState(false);

    return (
        <Switch
            size="sm"
            checked={status === 'active'}
            disabled={processing}
            aria-label="Ülke durumunu değiştir"
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

function CountrySaveButton({ processing }: { processing?: boolean }) {
    return (
        <Button type="submit" disabled={processing}>
            <Save data-icon="inline-start" />
            Kaydet
        </Button>
    );
}

export default function CountryIndex({ countries, defaults }: Props) {
    return (
        <>
            <Head title="Ülkeler" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl">
                <div className="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <Heading
                        variant="small"
                        title="Ülkeler"
                        description="Ülke kayıtlarını yönetin; şehirler ülkeye bağlı açılır."
                    />
                    <div className="flex flex-wrap items-center gap-2">
                        <Button variant="outline" asChild>
                            <Link href={countryDeleted().url}>
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
                                    <SheetTitle>Ülke ekle</SheetTitle>
                                    <SheetDescription>
                                        Yeni ülke tanımı oluşturun.
                                    </SheetDescription>
                                </SheetHeader>
                                <Form
                                    {...countryStore.form()}
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
                                                    <CountryField
                                                        name="sort_order"
                                                        label="Sıra No"
                                                        type="number"
                                                        min={0}
                                                        required={false}
                                                        error={errors.sort_order}
                                                    />
                                                    <CountryField
                                                        name="code"
                                                        label="Kod"
                                                        error={errors.code}
                                                    />
                                                </div>
                                                <CountryField
                                                    name="name"
                                                    label="Ad"
                                                    error={errors.name}
                                                />
                                            </FieldGroup>
                                            <div className="flex justify-end">
                                                <CountrySaveButton
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
                            {countries.data.map((country) => (
                                <TableRow key={country.id}>
                                    <TableCell>
                                        <CountryStatusSwitch
                                            status={country.status}
                                            url={countryStatus(country.id).url}
                                        />
                                    </TableCell>
                                    <TableCell>{country.sort_order}</TableCell>
                                    <TableCell className="font-medium">
                                        {country.code}
                                    </TableCell>
                                    <TableCell>
                                        <div className="flex items-center gap-2">
                                            <span>{country.name}</span>
                                            {country.id ===
                                            defaults.default_country_id ? (
                                                <Badge variant="secondary">
                                                    Varsayılan
                                                </Badge>
                                            ) : null}
                                        </div>
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
                                                        cityIndex(country).url
                                                    }
                                                >
                                                    <MapPinned data-icon="inline-start" />
                                                    Şehirler
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
                                                            Ülke düzenle
                                                        </SheetTitle>
                                                        <SheetDescription>
                                                            {country.name}{' '}
                                                            kaydını düzenleyin.
                                                        </SheetDescription>
                                                    </SheetHeader>
                                                    <div className="flex flex-1 min-h-0 flex-col gap-6 overflow-y-auto px-4 pb-4">
                                                        <Form
                                                            {...countryUpdate.form(
                                                                country.id,
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
                                                                            <CountryField
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
                                                                                    country.sort_order
                                                                                }
                                                                                error={
                                                                                    errors.sort_order
                                                                                }
                                                                            />
                                                                            <CountryField
                                                                                name="code"
                                                                                label="Kod"
                                                                                defaultValue={
                                                                                    country.code
                                                                                }
                                                                                error={
                                                                                    errors.code
                                                                                }
                                                                            />
                                                                        </div>
                                                                        <CountryField
                                                                            name="name"
                                                                            label="Ad"
                                                                            defaultValue={
                                                                                country.name
                                                                            }
                                                                            error={
                                                                                errors.name
                                                                            }
                                                                        />
                                                                    </FieldGroup>
                                                                    <div className="flex justify-end">
                                                                        <CountrySaveButton
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
                                                                    ülke,
                                                                    silinenler
                                                                    sayfasından
                                                                    geri
                                                                    alınabilir.
                                                                </p>
                                                            </div>
                                                            <div className="flex justify-end">
                                                                <ConfirmDelete
                                                                    action={countryDestroy(
                                                                        country.id,
                                                                    )}
                                                                    title={`${country.name} ülkesi silinsin mi?`}
                                                                    description="Silinen ülke, silinenler sayfasından geri alınabilir."
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
                            ))}

                            {countries.data.length === 0 && (
                                <TableRow>
                                    <TableCell
                                        colSpan={5}
                                        className="h-24 text-center text-muted-foreground"
                                    >
                                        Ülke kaydı bulunamadı.
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

CountryIndex.layout = {
    breadcrumbs: [
        {
            title: 'Ülkeler',
            href: dashboard(),
        },
    ],
};
