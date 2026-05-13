import { Form, Head } from '@inertiajs/react';
import {
    Clock3,
    Coins,
    Globe2,
    ImageIcon,
    Languages,
    Percent,
    Save,
    UploadCloud,
} from 'lucide-react';
import { useEffect, useState } from 'react';
import type { ChangeEvent, ReactNode } from 'react';

import SettingsController from '@/actions/App/Http/Controllers/Panel/Settings/General/SettingsController';
import InputError from '@/components/input-error';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Field,
    FieldDescription,
    FieldGroup,
    FieldLabel,
} from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import {
    NativeSelect,
    NativeSelectOption,
} from '@/components/ui/native-select';
import { dashboard } from '@/routes';
import type { Country, Currency, Language, Tax } from '@/types';

type SettingsValues = {
    app_name?: string | null;
    app_slogan?: string | null;
    logo_path?: string | null;
    logo_url?: string | null;
    logo_dark_path?: string | null;
    logo_dark_url?: string | null;
    favicon_path?: string | null;
    favicon_url?: string | null;
    default_country_id?: string | null;
    default_currency_id?: string | null;
    default_tax_id?: string | null;
    default_language_code?: string | null;
    default_timezone?: string | null;
};

type ResourceCollection<T> = {
    data: T[];
};

type Props = {
    settings: SettingsValues;
    countries: ResourceCollection<Country>;
    currencies: ResourceCollection<Currency>;
    taxes: ResourceCollection<Tax>;
    languages: ResourceCollection<Language>;
    timezones: string[];
};

function Section({
    title,
    description,
    children,
}: {
    title: string;
    description: string;
    children: ReactNode;
}) {
    return (
        <section className="grid gap-6 border-b py-7 last:border-b-0 lg:grid-cols-[240px_1fr]">
            <div className="flex flex-col gap-1">
                <h2 className="text-sm font-medium">{title}</h2>
                <p className="text-sm text-muted-foreground">{description}</p>
            </div>
            <div className="min-w-0">{children}</div>
        </section>
    );
}

function SelectField({
    id,
    name,
    label,
    defaultValue,
    error,
    icon,
    children,
}: {
    id: string;
    name: string;
    label: string;
    defaultValue?: string | null;
    error?: string;
    icon: ReactNode;
    children: ReactNode;
}) {
    return (
        <Field data-invalid={Boolean(error)}>
            <FieldLabel htmlFor={id} className="items-center">
                {icon}
                {label}
            </FieldLabel>
            <div className="[&>[data-slot=native-select-wrapper]]:w-full">
                <NativeSelect
                    id={id}
                    name={name}
                    defaultValue={defaultValue ?? ''}
                    aria-invalid={Boolean(error)}
                    className="w-full"
                >
                    <NativeSelectOption value="">Seçilmedi</NativeSelectOption>
                    {children}
                </NativeSelect>
            </div>
            <InputError message={error} />
        </Field>
    );
}

function AssetUpload({
    id,
    name,
    title,
    description,
    currentUrl,
    currentPath,
    error,
    previewClassName = 'object-contain',
}: {
    id: string;
    name: string;
    title: string;
    description: string;
    currentUrl?: string | null;
    currentPath?: string | null;
    error?: string;
    previewClassName?: string;
}) {
    const [previewUrl, setPreviewUrl] = useState<string | null>(null);
    const [fileName, setFileName] = useState<string | null>(null);
    const [objectUrl, setObjectUrl] = useState<string | null>(null);
    const displayUrl = previewUrl ?? currentUrl ?? null;

    useEffect(() => {
        return () => {
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
            }
        };
    }, [objectUrl]);

    function handleChange(event: ChangeEvent<HTMLInputElement>) {
        const file = event.target.files?.[0] ?? null;

        if (!file) {
            setFileName(null);
            setPreviewUrl(null);

            return;
        }

        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
        }

        const nextUrl = URL.createObjectURL(file);

        setObjectUrl(nextUrl);
        setPreviewUrl(nextUrl);
        setFileName(file.name);
    }

    return (
        <Field data-invalid={Boolean(error)} className="gap-3">
            <div className="flex min-w-0 flex-col gap-4 rounded-md border border-dashed p-4 sm:flex-row sm:items-center">
                <div className="flex size-24 shrink-0 items-center justify-center overflow-hidden rounded-md border bg-muted sm:size-28">
                    {displayUrl ? (
                        <img
                            src={displayUrl}
                            alt={title}
                            className={`size-full ${previewClassName}`}
                        />
                    ) : (
                        <ImageIcon className="text-muted-foreground" />
                    )}
                </div>

                <div className="flex min-w-0 flex-1 flex-col gap-3">
                    <div className="min-w-0">
                        <FieldLabel htmlFor={id}>{title}</FieldLabel>
                        <FieldDescription>{description}</FieldDescription>
                    </div>

                    <div className="flex flex-wrap items-center gap-2">
                        <Button asChild variant="outline" size="sm">
                            <label htmlFor={id} className="cursor-pointer">
                                <UploadCloud data-icon="inline-start" />
                                Dosya seç
                            </label>
                        </Button>
                        <Input
                            id={id}
                            name={name}
                            type="file"
                            accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                            aria-invalid={Boolean(error)}
                            onChange={handleChange}
                            className="sr-only"
                        />
                        <Badge variant="outline">JPG / JPEG / PNG</Badge>
                    </div>

                    <div className="min-w-0 truncate text-xs text-muted-foreground">
                        {fileName ?? currentPath ?? 'Dosya yüklenmedi'}
                    </div>
                    <InputError message={error} />
                </div>
            </div>
        </Field>
    );
}

export default function Settings({
    settings,
    countries,
    currencies,
    taxes,
    languages,
    timezones,
}: Props) {
    return (
        <>
            <Head title="Ayarlar" />

            <Form
                {...SettingsController.update.form()}
                options={{ preserveScroll: true }}
                encType="multipart/form-data"
                className="max-w-5xl"
            >
                {({ errors, processing }) => (
                    <div className="flex flex-col gap-1">
                        <div className="flex flex-wrap items-start justify-between gap-4 border-b pb-5">
                            <div className="min-w-0">
                                <h1 className="text-xl font-semibold">
                                    Genel ayarlar
                                </h1>
                                <p className="mt-1 text-sm text-muted-foreground">
                                    Panel kimliği ve varsayılan sistem
                                    tercihleri.
                                </p>
                            </div>
                            <Button disabled={processing}>
                                <Save data-icon="inline-start" />
                                Kaydet
                            </Button>
                        </div>

                        <Section
                            title="Kimlik"
                            description="Panelin adı, kısa tanımı ve marka görselleri."
                        >
                            <FieldGroup className="gap-5">
                                <div className="grid gap-5 md:grid-cols-2">
                                    <Field
                                        data-invalid={Boolean(errors.app_name)}
                                    >
                                        <FieldLabel htmlFor="app_name">
                                            Uygulama adı
                                        </FieldLabel>
                                        <Input
                                            id="app_name"
                                            name="app_name"
                                            defaultValue={
                                                settings.app_name ?? ''
                                            }
                                            aria-invalid={Boolean(
                                                errors.app_name,
                                            )}
                                            placeholder="Panel"
                                        />
                                        <InputError message={errors.app_name} />
                                    </Field>

                                    <Field
                                        data-invalid={Boolean(
                                            errors.app_slogan,
                                        )}
                                    >
                                        <FieldLabel htmlFor="app_slogan">
                                            Slogan
                                        </FieldLabel>
                                        <Input
                                            id="app_slogan"
                                            name="app_slogan"
                                            defaultValue={
                                                settings.app_slogan ?? ''
                                            }
                                            aria-invalid={Boolean(
                                                errors.app_slogan,
                                            )}
                                            placeholder="Kısa ve net bir açıklama"
                                        />
                                        <InputError
                                            message={errors.app_slogan}
                                        />
                                    </Field>
                                </div>

                                <div className="flex flex-col gap-4">
                                    <AssetUpload
                                        id="logo_path"
                                        name="logo_path"
                                        title="Logo"
                                        description="Açık tema ve genel kullanım."
                                        currentUrl={settings.logo_url}
                                        currentPath={settings.logo_path}
                                        error={errors.logo_path}
                                    />
                                    <AssetUpload
                                        id="logo_dark_path"
                                        name="logo_dark_path"
                                        title="Logo dark"
                                        description="Koyu tema kullanımı."
                                        currentUrl={settings.logo_dark_url}
                                        currentPath={settings.logo_dark_path}
                                        error={errors.logo_dark_path}
                                    />
                                    <AssetUpload
                                        id="favicon_path"
                                        name="favicon_path"
                                        title="Favicon"
                                        description="Tarayıcı sekmesi ikonu."
                                        currentUrl={settings.favicon_url}
                                        currentPath={settings.favicon_path}
                                        error={errors.favicon_path}
                                        previewClassName="object-cover"
                                    />
                                </div>
                            </FieldGroup>
                        </Section>

                        <Section
                            title="Varsayılanlar"
                            description="Tanımlar modülünden gelen sistem tercihleri."
                        >
                            <FieldGroup className="grid gap-5 md:grid-cols-2">
                                <SelectField
                                    id="default_country_id"
                                    name="default_country_id"
                                    label="Ülke"
                                    defaultValue={settings.default_country_id}
                                    error={errors.default_country_id}
                                    icon={
                                        <Globe2 className="size-4 text-muted-foreground" />
                                    }
                                >
                                    {countries.data.map((country) => (
                                        <NativeSelectOption
                                            key={country.id}
                                            value={country.id}
                                        >
                                            {country.name}
                                        </NativeSelectOption>
                                    ))}
                                </SelectField>

                                <SelectField
                                    id="default_currency_id"
                                    name="default_currency_id"
                                    label="Para birimi"
                                    defaultValue={settings.default_currency_id}
                                    error={errors.default_currency_id}
                                    icon={
                                        <Coins className="size-4 text-muted-foreground" />
                                    }
                                >
                                    {currencies.data.map((currency) => (
                                        <NativeSelectOption
                                            key={currency.id}
                                            value={currency.id}
                                        >
                                            {currency.name} ({currency.code})
                                        </NativeSelectOption>
                                    ))}
                                </SelectField>

                                <SelectField
                                    id="default_tax_id"
                                    name="default_tax_id"
                                    label="Vergi oranı"
                                    defaultValue={settings.default_tax_id}
                                    error={errors.default_tax_id}
                                    icon={
                                        <Percent className="size-4 text-muted-foreground" />
                                    }
                                >
                                    {taxes.data.map((tax) => (
                                        <NativeSelectOption
                                            key={tax.id}
                                            value={tax.id}
                                        >
                                            {tax.name} (%{tax.rate})
                                        </NativeSelectOption>
                                    ))}
                                </SelectField>

                                <SelectField
                                    id="default_language_code"
                                    name="default_language_code"
                                    label="Dil"
                                    defaultValue={
                                        settings.default_language_code
                                    }
                                    error={errors.default_language_code}
                                    icon={
                                        <Languages className="size-4 text-muted-foreground" />
                                    }
                                >
                                    {languages.data.map((language) => (
                                        <NativeSelectOption
                                            key={language.code}
                                            value={language.code}
                                        >
                                            {language.native_name} (
                                            {language.code})
                                        </NativeSelectOption>
                                    ))}
                                </SelectField>

                                <SelectField
                                    id="default_timezone"
                                    name="default_timezone"
                                    label="Zaman dilimi"
                                    defaultValue={settings.default_timezone}
                                    error={errors.default_timezone}
                                    icon={
                                        <Clock3 className="size-4 text-muted-foreground" />
                                    }
                                >
                                    {timezones.map((timezone) => (
                                        <NativeSelectOption
                                            key={timezone}
                                            value={timezone}
                                        >
                                            {timezone}
                                        </NativeSelectOption>
                                    ))}
                                </SelectField>
                            </FieldGroup>
                        </Section>

                        <div className="flex justify-end pt-5">
                            <Button disabled={processing}>
                                <Save data-icon="inline-start" />
                                Kaydet
                            </Button>
                        </div>
                    </div>
                )}
            </Form>
        </>
    );
}

Settings.layout = {
    breadcrumbs: [
        {
            title: 'Ayarlar',
            href: dashboard(),
        },
    ],
};
