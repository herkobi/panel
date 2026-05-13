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
    deleted as taxDeleted,
    destroy as taxDestroy,
    status as taxStatus,
    store as taxStore,
    update as taxUpdate,
} from '@/routes/panel/tools/definitions/taxes';
import type { Paginated, PaginationLink, Status, Tax } from '@/types';

type Props = {
    taxes: Paginated<Tax>;
    defaults: {
        default_tax_id: string | null;
    };
};

function TaxField({
    name,
    label,
    defaultValue,
    error,
    type = 'text',
    min,
    step,
}: {
    name: string;
    label: string;
    defaultValue?: string | number | null;
    error?: string;
    type?: string;
    min?: number;
    step?: string;
}) {
    return (
        <Field data-invalid={Boolean(error)}>
            <FieldLabel htmlFor={name}>{label}</FieldLabel>
            <Input
                id={name}
                name={name}
                type={type}
                defaultValue={defaultValue ?? ''}
                required
                min={min}
                step={step}
                aria-invalid={Boolean(error)}
            />
            <InputError message={error} />
        </Field>
    );
}

function TaxStatusSwitch({ status, url }: { status: Status; url: string }) {
    const [processing, setProcessing] = useState(false);

    return (
        <Switch
            size="sm"
            checked={status === 'active'}
            disabled={processing}
            aria-label="Vergi oranı durumunu değiştir"
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

function TaxSaveButton({ processing }: { processing?: boolean }) {
    return (
        <Button type="submit" disabled={processing}>
            <Save data-icon="inline-start" />
            Kaydet
        </Button>
    );
}

function TaxPagination({ taxes }: { taxes: Paginated<Tax> }) {
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

export default function TaxIndex({ taxes, defaults }: Props) {
    return (
        <>
            <Head title="Vergi Oranları" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl">
                <div className="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <Heading
                        variant="small"
                        title="Vergi Oranları"
                        description="Sistemde kullanılacak vergi oranlarını yönetin."
                    />
                    <div className="flex flex-wrap items-center gap-2">
                        <Button variant="outline" asChild>
                            <Link href={taxDeleted().url}>
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
                                    <SheetTitle>Vergi oranı ekle</SheetTitle>
                                    <SheetDescription>
                                        Yeni vergi oranı tanımı oluşturun.
                                    </SheetDescription>
                                </SheetHeader>
                                <Form
                                    {...taxStore.form()}
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
                                                <TaxField
                                                    name="name"
                                                    label="Ad"
                                                    error={errors.name}
                                                />
                                                <TaxField
                                                    name="rate"
                                                    label="Oran"
                                                    type="number"
                                                    min={0}
                                                    step="0.01"
                                                    error={errors.rate}
                                                />
                                            </FieldGroup>
                                            <div className="flex justify-end">
                                                <TaxSaveButton
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
                                <TableHead>Oran</TableHead>
                                <TableHead className="text-right">
                                    İşlem
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {taxes.data.map((tax) => (
                                <TableRow key={tax.id}>
                                    <TableCell>
                                        <TaxStatusSwitch
                                            status={tax.status}
                                            url={taxStatus(tax.id).url}
                                        />
                                    </TableCell>
                                    <TableCell className="font-medium">
                                        <div className="flex items-center gap-2">
                                            <span>{tax.name}</span>
                                            {tax.id ===
                                            defaults.default_tax_id ? (
                                                <Badge variant="secondary">
                                                    Varsayılan
                                                </Badge>
                                            ) : null}
                                        </div>
                                    </TableCell>
                                    <TableCell>%{tax.rate}</TableCell>
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
                                                        Vergi oranı düzenle
                                                    </SheetTitle>
                                                    <SheetDescription>
                                                        {tax.name} kaydını
                                                        düzenleyin.
                                                    </SheetDescription>
                                                </SheetHeader>
                                                <div className="flex flex-col gap-6 px-4">
                                                    <Form
                                                        {...taxUpdate.form(
                                                            tax.id,
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
                                                                            tax.status
                                                                        }
                                                                    />
                                                                    <TaxField
                                                                        name="name"
                                                                        label="Ad"
                                                                        defaultValue={
                                                                            tax.name
                                                                        }
                                                                        error={
                                                                            errors.name
                                                                        }
                                                                    />
                                                                    <TaxField
                                                                        name="rate"
                                                                        label="Oran"
                                                                        type="number"
                                                                        min={0}
                                                                        step="0.01"
                                                                        defaultValue={
                                                                            tax.rate
                                                                        }
                                                                        error={
                                                                            errors.rate
                                                                        }
                                                                    />
                                                                </FieldGroup>
                                                                <div className="flex justify-end">
                                                                    <TaxSaveButton
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
                                                                Silinen vergi
                                                                oranı,
                                                                silinenler
                                                                sayfasından geri
                                                                alınabilir.
                                                            </p>
                                                        </div>
                                                        <Form
                                                            {...taxDestroy.form(
                                                                tax.id,
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

                            {taxes.data.length === 0 && (
                                <TableRow>
                                    <TableCell
                                        colSpan={4}
                                        className="h-24 text-center text-muted-foreground"
                                    >
                                        Vergi oranı kaydı bulunamadı.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>

                <TaxPagination taxes={taxes} />
            </div>
        </>
    );
}

TaxIndex.layout = {
    breadcrumbs: [
        {
            title: 'Vergi Oranları',
            href: dashboard(),
        },
    ],
};
