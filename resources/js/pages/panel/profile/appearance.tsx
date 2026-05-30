import { Head, useForm } from '@inertiajs/react';
import { Clock, Globe2, Palette, Save } from 'lucide-react';
import type { FormEvent } from 'react';
import PreferencesController from '@/actions/App/Http/Controllers/Panel/Profile/PreferencesController';
import Heading from '@/components/heading';
import InputError from '@/components/input-error';
import AppearanceTabs from '@/components/panel/appearance-tabs';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Spinner } from '@/components/ui/spinner';
import { edit as editAppearance } from '@/routes/panel/profile/appearance';
import type { LanguageOption, Option } from '@/types';

type Preferences = {
    locale: string;
    timezone: string;
};

type Props = {
    languages: LanguageOption[];
    timezones: Option[];
    preferences: Preferences;
};

export default function Appearance({
    languages,
    timezones,
    preferences,
}: Props) {
    const { data, setData, put, processing, errors } = useForm({
        locale: preferences.locale,
        timezone: preferences.timezone,
    });

    const submit = (event: FormEvent<HTMLFormElement>): void => {
        event.preventDefault();

        put(PreferencesController.update.url(), {
            preserveScroll: true,
        });
    };

    return (
        <>
            <Head title="Tercihler" />

            <h1 className="sr-only">Tercihler</h1>

            <div className="space-y-6">
                <Heading
                    variant="small"
                    title="Tercihler"
                    description="Görünüm, arayüz dili ve zaman dilimi tercihlerinizi yönetin"
                />

                <div className="w-full max-w-2xl space-y-4">
                    <section className="rounded-lg border bg-card p-5 shadow-xs">
                        <div className="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div className="flex items-start gap-3">
                                <div className="flex size-10 shrink-0 items-center justify-center rounded-md border bg-muted text-muted-foreground">
                                    <Palette className="size-5" />
                                </div>
                                <div className="grid gap-1">
                                    <Label>Görünüm</Label>
                                    <p className="text-sm text-muted-foreground">
                                        Panel arayüzünün tema tercihini seçin.
                                    </p>
                                </div>
                            </div>
                            <AppearanceTabs className="self-start sm:self-center" />
                        </div>
                    </section>

                    <form
                        onSubmit={submit}
                        className="rounded-lg border bg-card p-5 shadow-xs"
                    >
                        <div className="grid gap-6">
                            <div className="flex items-start gap-3">
                                <div className="flex size-10 shrink-0 items-center justify-center rounded-md border bg-muted text-muted-foreground">
                                    <Globe2 className="size-5" />
                                </div>
                                <div className="grid flex-1 gap-2">
                                    <Label htmlFor="locale">Arayüz dili</Label>
                                    <Select
                                        value={data.locale}
                                        onValueChange={(value) =>
                                            setData('locale', value)
                                        }
                                    >
                                        <SelectTrigger
                                            id="locale"
                                            className="w-full"
                                        >
                                            <SelectValue placeholder="Dil seçin" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            {languages.map((language) => (
                                                <SelectItem
                                                    key={language.id}
                                                    value={language.code}
                                                >
                                                    {language.native_name} (
                                                    {language.name})
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                    <InputError message={errors.locale} />
                                </div>
                            </div>

                            <div className="flex items-start gap-3">
                                <div className="flex size-10 shrink-0 items-center justify-center rounded-md border bg-muted text-muted-foreground">
                                    <Clock className="size-5" />
                                </div>
                                <div className="grid flex-1 gap-2">
                                    <Label htmlFor="timezone">
                                        Zaman dilimi
                                    </Label>
                                    <Select
                                        value={data.timezone}
                                        onValueChange={(value) =>
                                            setData('timezone', value)
                                        }
                                    >
                                        <SelectTrigger
                                            id="timezone"
                                            className="w-full"
                                        >
                                            <SelectValue placeholder="Zaman dilimi seçin" />
                                        </SelectTrigger>
                                        <SelectContent className="max-h-72">
                                            {timezones.map((timezone) => (
                                                <SelectItem
                                                    key={timezone.value}
                                                    value={timezone.value}
                                                >
                                                    {timezone.label}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                    <InputError message={errors.timezone} />
                                </div>
                            </div>

                            <div className="flex justify-end border-t pt-5">
                                <Button type="submit" disabled={processing}>
                                    {processing ? (
                                        <Spinner />
                                    ) : (
                                        <Save className="size-4" />
                                    )}
                                    Kaydet
                                </Button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
}

Appearance.layout = {
    breadcrumbs: [
        {
            title: 'Tercihler',
            href: editAppearance(),
        },
    ],
};
