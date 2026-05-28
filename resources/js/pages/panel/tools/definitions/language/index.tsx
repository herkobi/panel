import { Form, Head, Link, router } from '@inertiajs/react';
import { Archive, Pencil, Plus, Save, Trash2 } from 'lucide-react';
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
    deleted as languageDeleted,
    destroy as languageDestroy,
    status as languageStatus,
    store as languageStore,
    update as languageUpdate,
} from '@/routes/panel/tools/definitions/languages';
import type { Language, Paginated, Status } from '@/types';

type Props = {
    languages: Paginated<Language>;
    defaults: {
        default_language_code: string | null;
    };
};

function LanguageTextField({
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

function LanguageSubmitButton({ processing }: { processing?: boolean }) {
    return (
        <Button type="submit" disabled={processing}>
            <Save data-icon="inline-start" />
            Kaydet
        </Button>
    );
}

function LanguageStatusSwitch({
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
            aria-label="Dil durumunu değiştir"
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

export default function LanguageIndex({ languages, defaults }: Props) {
    return (
        <>
            <Head title="Dil Tanımları" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl">
                <div className="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <Heading
                        variant="small"
                        title="Dil Tanımları"
                        description="Sistemde kullanılacak dilleri yönetin."
                    />
                    <div className="flex flex-wrap items-center gap-2">
                        <Button variant="outline" asChild>
                            <Link href={languageDeleted().url}>
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
                                    <SheetTitle>Dil ekle</SheetTitle>
                                    <SheetDescription>
                                        Yeni dil tanımı oluşturun.
                                    </SheetDescription>
                                </SheetHeader>
                                <Form
                                    {...languageStore.form()}
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
                                                    <LanguageTextField
                                                        name="sort_order"
                                                        label="Sıra No"
                                                        type="number"
                                                        min={0}
                                                        required={false}
                                                        error={errors.sort_order}
                                                    />
                                                    <LanguageTextField
                                                        name="code"
                                                        label="Kod"
                                                        error={errors.code}
                                                    />
                                                </div>
                                                <LanguageTextField
                                                    name="name"
                                                    label="Ad"
                                                    error={errors.name}
                                                />
                                                <LanguageTextField
                                                    name="native_name"
                                                    label="Yerel ad"
                                                    error={errors.native_name}
                                                />
                                            </FieldGroup>
                                            <div className="flex justify-end">
                                                <LanguageSubmitButton
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
                                <TableHead>Yerel ad</TableHead>
                                <TableHead className="text-right">
                                    İşlem
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {languages.data.map((language) => (
                                <TableRow key={language.id}>
                                    <TableCell>
                                        <LanguageStatusSwitch
                                            status={language.status}
                                            url={
                                                languageStatus(language.id).url
                                            }
                                        />
                                    </TableCell>
                                    <TableCell>{language.sort_order}</TableCell>
                                    <TableCell className="font-medium">
                                        {language.code}
                                    </TableCell>
                                    <TableCell>
                                        <div className="flex items-center gap-2">
                                            <span>{language.name}</span>
                                            {language.code ===
                                            defaults.default_language_code ? (
                                                <Badge variant="secondary">
                                                    Varsayılan
                                                </Badge>
                                            ) : null}
                                        </div>
                                    </TableCell>
                                    <TableCell>
                                        {language.native_name}
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
                                                        Dil düzenle
                                                    </SheetTitle>
                                                    <SheetDescription>
                                                        {language.name} kaydını
                                                        düzenleyin.
                                                    </SheetDescription>
                                                </SheetHeader>
                                                <div className="flex flex-1 min-h-0 flex-col gap-6 overflow-y-auto px-4 pb-4">
                                                    <Form
                                                        {...languageUpdate.form(
                                                            language.id,
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
                                                                        <LanguageTextField
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
                                                                                language.sort_order
                                                                            }
                                                                            error={
                                                                                errors.sort_order
                                                                            }
                                                                        />
                                                                        <LanguageTextField
                                                                            name="code"
                                                                            label="Kod"
                                                                            defaultValue={
                                                                                language.code
                                                                            }
                                                                            error={
                                                                                errors.code
                                                                            }
                                                                        />
                                                                    </div>
                                                                    <LanguageTextField
                                                                        name="name"
                                                                        label="Ad"
                                                                        defaultValue={
                                                                            language.name
                                                                        }
                                                                        error={
                                                                            errors.name
                                                                        }
                                                                    />
                                                                    <LanguageTextField
                                                                        name="native_name"
                                                                        label="Yerel ad"
                                                                        defaultValue={
                                                                            language.native_name
                                                                        }
                                                                        error={
                                                                            errors.native_name
                                                                        }
                                                                    />
                                                                </FieldGroup>
                                                                <div className="flex justify-end">
                                                                    <LanguageSubmitButton
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
                                                                Silinen dil,
                                                                silinenler
                                                                sayfasından geri
                                                                alınabilir.
                                                            </p>
                                                        </div>
                                                        <div className="flex justify-end">
                                                            <ConfirmDelete
                                                                action={languageDestroy(
                                                                    language.id,
                                                                )}
                                                                title={`${language.name} dili silinsin mi?`}
                                                                description="Silinen dil, silinenler sayfasından geri alınabilir."
                                                            >
                                                                <Button variant="destructive">
                                                                    <Trash2 data-icon="inline-start" />
                                                                    Kaydı sil
                                                                </Button>
                                                            </ConfirmDelete>
                                                        </div>
                                                    </div>
                                                </div>
                                            </SheetContent>
                                        </Sheet>
                                    </TableCell>
                                </TableRow>
                            ))}

                            {languages.data.length === 0 && (
                                <TableRow>
                                    <TableCell
                                        colSpan={6}
                                        className="h-24 text-center text-muted-foreground"
                                    >
                                        Dil kaydı bulunamadı.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>

                <DataPagination paginator={languages} showRange={false} />
            </div>
        </>
    );
}

LanguageIndex.layout = {
    breadcrumbs: [
        {
            title: 'Dil Tanımları',
            href: dashboard(),
        },
    ],
};
