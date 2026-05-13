import { Form, Head, Link, router } from '@inertiajs/react';
import { Archive, Pencil, Plus, Save, Trash2 } from 'lucide-react';
import { useState } from 'react';

import Heading from '@/components/heading';
import InputError from '@/components/input-error';
import { Badge } from '@/components/ui/badge';
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
import {
    deleted as currencyDeleted,
    destroy as currencyDestroy,
    status as currencyStatus,
    store as currencyStore,
    update as currencyUpdate,
} from '@/routes/panel/tools/definitions/currencies';
import type { Currency, Paginated, PaginationLink, Status } from '@/types';

type Props = {
    currencies: Paginated<Currency>;
    defaults: {
        default_currency_id: string | null;
    };
};

function CurrencyField({
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

function CurrencyStatusSwitch({
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
            aria-label="Para birimi durumunu değiştir"
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

function CurrencySaveButton({ processing }: { processing?: boolean }) {
    return (
        <Button type="submit" disabled={processing}>
            <Save data-icon="inline-start" />
            Kaydet
        </Button>
    );
}

function CurrencyPagination({
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

export default function CurrencyIndex({ currencies, defaults }: Props) {
    return (
        <>
            <Head title="Para Birimleri" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl">
                <div className="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <Heading
                        variant="small"
                        title="Para Birimleri"
                        description="Sistemde kullanılacak para birimlerini yönetin."
                    />
                    <div className="flex flex-wrap items-center gap-2">
                        <Button variant="outline" asChild>
                            <Link href={currencyDeleted().url}>
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
                                    <SheetTitle>Para birimi ekle</SheetTitle>
                                    <SheetDescription>
                                        Yeni para birimi tanımı oluşturun.
                                    </SheetDescription>
                                </SheetHeader>
                                <Form
                                    {...currencyStore.form()}
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
                                                <CurrencyField
                                                    name="code"
                                                    label="Kod"
                                                    error={errors.code}
                                                />
                                                <CurrencyField
                                                    name="name"
                                                    label="Ad"
                                                    error={errors.name}
                                                />
                                                <CurrencyField
                                                    name="symbol"
                                                    label="Sembol"
                                                    error={errors.symbol}
                                                />
                                                <CurrencyField
                                                    name="decimal_places"
                                                    label="Ondalık basamak"
                                                    type="number"
                                                    min={0}
                                                    defaultValue={2}
                                                    error={
                                                        errors.decimal_places
                                                    }
                                                />
                                                <CurrencyField
                                                    name="sort_order"
                                                    label="Sıra"
                                                    type="number"
                                                    min={0}
                                                    required={false}
                                                    error={errors.sort_order}
                                                />
                                            </FieldGroup>
                                            <div className="flex justify-end">
                                                <CurrencySaveButton
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
                                <TableHead>Sembol</TableHead>
                                <TableHead>Ondalık</TableHead>
                                <TableHead className="text-right">
                                    İşlem
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {currencies.data.map((currency) => (
                                <TableRow key={currency.id}>
                                    <TableCell>
                                        <CurrencyStatusSwitch
                                            status={currency.status}
                                            url={
                                                currencyStatus(currency.id).url
                                            }
                                        />
                                    </TableCell>
                                    <TableCell className="font-medium">
                                        {currency.code}
                                    </TableCell>
                                    <TableCell>
                                        <div className="flex items-center gap-2">
                                            <span>{currency.name}</span>
                                            {currency.id ===
                                            defaults.default_currency_id ? (
                                                <Badge variant="secondary">
                                                    Varsayılan
                                                </Badge>
                                            ) : null}
                                        </div>
                                    </TableCell>
                                    <TableCell>{currency.symbol}</TableCell>
                                    <TableCell>
                                        {currency.decimal_places}
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
                                                        Para birimi düzenle
                                                    </SheetTitle>
                                                    <SheetDescription>
                                                        {currency.name} kaydını
                                                        düzenleyin.
                                                    </SheetDescription>
                                                </SheetHeader>
                                                <div className="flex flex-col gap-6 px-4">
                                                    <Form
                                                        {...currencyUpdate.form(
                                                            currency.id,
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
                                                                            currency.status
                                                                        }
                                                                    />
                                                                    <CurrencyField
                                                                        name="code"
                                                                        label="Kod"
                                                                        defaultValue={
                                                                            currency.code
                                                                        }
                                                                        error={
                                                                            errors.code
                                                                        }
                                                                    />
                                                                    <CurrencyField
                                                                        name="name"
                                                                        label="Ad"
                                                                        defaultValue={
                                                                            currency.name
                                                                        }
                                                                        error={
                                                                            errors.name
                                                                        }
                                                                    />
                                                                    <CurrencyField
                                                                        name="symbol"
                                                                        label="Sembol"
                                                                        defaultValue={
                                                                            currency.symbol
                                                                        }
                                                                        error={
                                                                            errors.symbol
                                                                        }
                                                                    />
                                                                    <CurrencyField
                                                                        name="decimal_places"
                                                                        label="Ondalık basamak"
                                                                        type="number"
                                                                        min={0}
                                                                        defaultValue={
                                                                            currency.decimal_places
                                                                        }
                                                                        error={
                                                                            errors.decimal_places
                                                                        }
                                                                    />
                                                                    <CurrencyField
                                                                        name="sort_order"
                                                                        label="Sıra"
                                                                        type="number"
                                                                        min={0}
                                                                        required={
                                                                            false
                                                                        }
                                                                        defaultValue={
                                                                            currency.sort_order
                                                                        }
                                                                        error={
                                                                            errors.sort_order
                                                                        }
                                                                    />
                                                                </FieldGroup>
                                                                <div className="flex justify-end">
                                                                    <CurrencySaveButton
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
                                                                Silinen para
                                                                birimi,
                                                                silinenler
                                                                sayfasından geri
                                                                alınabilir.
                                                            </p>
                                                        </div>
                                                        <Form
                                                            {...currencyDestroy.form(
                                                                currency.id,
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
                                                                    Kaydı sil
                                                                </Button>
                                                            )}
                                                        </Form>
                                                    </div>
                                                </div>
                                            </SheetContent>
                                        </Sheet>
                                    </TableCell>
                                </TableRow>
                            ))}

                            {currencies.data.length === 0 && (
                                <TableRow>
                                    <TableCell
                                        colSpan={6}
                                        className="h-24 text-center text-muted-foreground"
                                    >
                                        Para birimi kaydı bulunamadı.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>

                <CurrencyPagination currencies={currencies} />
            </div>
        </>
    );
}

CurrencyIndex.layout = {
    breadcrumbs: [
        {
            title: 'Para Birimleri',
            href: dashboard(),
        },
    ],
};
