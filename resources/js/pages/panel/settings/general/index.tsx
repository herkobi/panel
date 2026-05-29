import { Form, Head, router } from '@inertiajs/react';
import { Clock3, Coins, Globe2, Languages, Percent, Save } from 'lucide-react';
import { useState } from 'react';
import type { ReactNode } from 'react';

import SettingsController from '@/actions/App/Http/Controllers/Panel/Settings/General/SettingsController';
import ImageUpload from '@/components/image-upload';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Field, FieldGroup, FieldLabel } from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import {
    NativeSelect,
    NativeSelectOption,
} from '@/components/ui/native-select';
import { useBranding } from '@/hooks/use-branding';
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

export default function Settings({
    settings,
    countries,
    currencies,
    taxes,
    languages,
    timezones,
}: Props) {
    const branding = useBranding();
    const [assetErrors, setAssetErrors] = useState<Record<string, string>>({});
    const [processingKey, setProcessingKey] = useState<string | null>(null);

    function uploadAsset(key: string, file: File) {
        router.post(
            SettingsController.uploadAsset().url,
            { key, file },
            {
                forceFormData: true,
                preserveScroll: true,
                only: ['settings'],
                onStart: () => setProcessingKey(key),
                onFinish: () => setProcessingKey(null),
                onSuccess: () =>
                    setAssetErrors((prev) => ({ ...prev, [key]: '' })),
                onError: (errors) =>
                    setAssetErrors((prev) => ({
                        ...prev,
                        [key]:
                            errors.file ?? errors.key ?? 'Görsel yüklenemedi.',
                    })),
            },
        );
    }

    function removeAsset(key: string) {
        router.delete(SettingsController.destroyAsset().url, {
            data: { key },
            preserveScroll: true,
            only: ['settings'],
            onStart: () => setProcessingKey(key),
            onFinish: () => setProcessingKey(null),
        });
    }

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
                                    <ImageUpload
                                        title="Logo"
                                        description="Açık tema ve genel kullanım."
                                        currentUrl={settings.logo_url}
                                        fallbackUrl={branding.logo}
                                        error={assetErrors.logo_path}
                                        processing={
                                            processingKey === 'logo_path'
                                        }
                                        onUpload={(file) =>
                                            uploadAsset('logo_path', file)
                                        }
                                        onRemove={() =>
                                            removeAsset('logo_path')
                                        }
                                    />
                                    <ImageUpload
                                        title="Logo dark"
                                        description="Koyu tema kullanımı."
                                        currentUrl={settings.logo_dark_url}
                                        fallbackUrl={branding.logo_dark}
                                        error={assetErrors.logo_dark_path}
                                        processing={
                                            processingKey === 'logo_dark_path'
                                        }
                                        onUpload={(file) =>
                                            uploadAsset('logo_dark_path', file)
                                        }
                                        onRemove={() =>
                                            removeAsset('logo_dark_path')
                                        }
                                    />
                                    <ImageUpload
                                        title="Favicon"
                                        description="Tarayıcı sekmesi ikonu."
                                        currentUrl={settings.favicon_url}
                                        fallbackUrl={branding.favicon}
                                        error={assetErrors.favicon_path}
                                        processing={
                                            processingKey === 'favicon_path'
                                        }
                                        previewClassName="object-cover"
                                        onUpload={(file) =>
                                            uploadAsset('favicon_path', file)
                                        }
                                        onRemove={() =>
                                            removeAsset('favicon_path')
                                        }
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
