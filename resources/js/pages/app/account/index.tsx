import { Form, Head, router } from '@inertiajs/react';
import { useMemo, useState } from 'react';

import AccountController from '@/actions/App/Http/Controllers/App/Account/AccountController';
import Heading from '@/components/heading';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import {
    Combobox,
    ComboboxCollection,
    ComboboxContent,
    ComboboxEmpty,
    ComboboxInput,
    ComboboxItem,
    ComboboxList,
} from '@/components/ui/combobox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { dashboard } from '@/routes';
import type { Account as AccountType } from '@/types';

type CountryOption = {
    id: string;
    name: string;
};

type CityOption = CountryOption & {
    country_id: string;
};

type DistrictOption = CountryOption & {
    city_id: string;
};

type Props = {
    account: {
        data: AccountType | null;
    };
    countries: CountryOption[];
    cities: CityOption[];
    districts: DistrictOption[];
};

function reloadLocations(countryId: string, cityId: string) {
    router.reload({
        only: ['cities', 'districts'],
        data: { country_id: countryId, city_id: cityId },
    });
}

export default function Account({
    account,
    countries,
    cities,
    districts,
}: Props) {
    const currentAccount = account.data;
    const [countryId, setCountryId] = useState(
        currentAccount?.country_id ?? '',
    );
    const [cityId, setCityId] = useState(currentAccount?.city_id ?? '');
    const [districtId, setDistrictId] = useState(
        currentAccount?.district_id ?? '',
    );

    const selectedCountry = useMemo(
        () => countries.find((c) => c.id === countryId) ?? null,
        [countries, countryId],
    );
    const selectedCity = useMemo(
        () => cities.find((c) => c.id === cityId) ?? null,
        [cities, cityId],
    );
    const selectedDistrict = useMemo(
        () => districts.find((d) => d.id === districtId) ?? null,
        [districts, districtId],
    );

    function onCountryChange(next: CountryOption | null) {
        const nextId = next?.id ?? '';
        setCountryId(nextId);
        setCityId('');
        setDistrictId('');
        reloadLocations(nextId, '');
    }

    function onCityChange(next: CityOption | null) {
        const nextId = next?.id ?? '';
        setCityId(nextId);
        setDistrictId('');
        reloadLocations(countryId, nextId);
    }

    function onDistrictChange(next: DistrictOption | null) {
        setDistrictId(next?.id ?? '');
    }

    return (
        <>
            <Head title="Hesap Bilgileri" />

            <div className="max-w-2xl p-4">
                <Heading
                    variant="small"
                    title="Hesap Bilgileri"
                    description="Firma veya hesap adres bilgilerinizi düzenleyin."
                />

                <Form
                    {...AccountController.update.form()}
                    options={{ preserveScroll: true }}
                    className="space-y-6"
                >
                    {({ errors, processing }) => (
                        <>
                            <div className="grid gap-2">
                                <Label htmlFor="title">Ünvan</Label>
                                <Input
                                    id="title"
                                    name="title"
                                    defaultValue={currentAccount?.title ?? ''}
                                />
                                <InputError message={errors.title} />
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="address">Adres</Label>
                                <Textarea
                                    id="address"
                                    name="address"
                                    defaultValue={currentAccount?.address ?? ''}
                                    rows={4}
                                />
                                <InputError message={errors.address} />
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="postal_code">Posta kodu</Label>
                                <Input
                                    id="postal_code"
                                    name="postal_code"
                                    defaultValue={
                                        currentAccount?.postal_code ?? ''
                                    }
                                />
                                <InputError message={errors.postal_code} />
                            </div>

                            <div className="grid gap-4 md:grid-cols-3">
                                <div className="grid gap-2">
                                    <Label htmlFor="country_id">Ülke</Label>
                                    <Combobox
                                        items={countries}
                                        value={selectedCountry}
                                        onValueChange={onCountryChange}
                                        itemToStringLabel={(c: CountryOption) =>
                                            c.name
                                        }
                                    >
                                        <ComboboxInput
                                            id="country_id"
                                            placeholder="Seçiniz"
                                            showClear={Boolean(countryId)}
                                            className="w-full"
                                        />
                                        <ComboboxContent>
                                            <ComboboxList>
                                                <ComboboxEmpty>
                                                    Sonuç yok
                                                </ComboboxEmpty>
                                                <ComboboxCollection>
                                                    {(
                                                        country: CountryOption,
                                                    ) => (
                                                        <ComboboxItem
                                                            key={country.id}
                                                            value={country}
                                                        >
                                                            {country.name}
                                                        </ComboboxItem>
                                                    )}
                                                </ComboboxCollection>
                                            </ComboboxList>
                                        </ComboboxContent>
                                    </Combobox>
                                    <input
                                        type="hidden"
                                        name="country_id"
                                        value={countryId}
                                    />
                                    <InputError message={errors.country_id} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="city_id">Şehir</Label>
                                    <Combobox
                                        items={cities}
                                        value={selectedCity}
                                        onValueChange={onCityChange}
                                        itemToStringLabel={(c: CityOption) =>
                                            c.name
                                        }
                                        disabled={countryId === ''}
                                    >
                                        <ComboboxInput
                                            id="city_id"
                                            placeholder="Seçiniz"
                                            disabled={countryId === ''}
                                            showClear={Boolean(cityId)}
                                            className="w-full"
                                        />
                                        <ComboboxContent>
                                            <ComboboxList>
                                                <ComboboxEmpty>
                                                    Sonuç yok
                                                </ComboboxEmpty>
                                                <ComboboxCollection>
                                                    {(city: CityOption) => (
                                                        <ComboboxItem
                                                            key={city.id}
                                                            value={city}
                                                        >
                                                            {city.name}
                                                        </ComboboxItem>
                                                    )}
                                                </ComboboxCollection>
                                            </ComboboxList>
                                        </ComboboxContent>
                                    </Combobox>
                                    <input
                                        type="hidden"
                                        name="city_id"
                                        value={cityId}
                                    />
                                    <InputError message={errors.city_id} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="district_id">İlçe</Label>
                                    <Combobox
                                        items={districts}
                                        value={selectedDistrict}
                                        onValueChange={onDistrictChange}
                                        itemToStringLabel={(
                                            d: DistrictOption,
                                        ) => d.name}
                                        disabled={cityId === ''}
                                    >
                                        <ComboboxInput
                                            id="district_id"
                                            placeholder="Seçiniz"
                                            disabled={cityId === ''}
                                            showClear={Boolean(districtId)}
                                            className="w-full"
                                        />
                                        <ComboboxContent>
                                            <ComboboxList>
                                                <ComboboxEmpty>
                                                    Sonuç yok
                                                </ComboboxEmpty>
                                                <ComboboxCollection>
                                                    {(
                                                        district: DistrictOption,
                                                    ) => (
                                                        <ComboboxItem
                                                            key={district.id}
                                                            value={district}
                                                        >
                                                            {district.name}
                                                        </ComboboxItem>
                                                    )}
                                                </ComboboxCollection>
                                            </ComboboxList>
                                        </ComboboxContent>
                                    </Combobox>
                                    <input
                                        type="hidden"
                                        name="district_id"
                                        value={districtId}
                                    />
                                    <InputError message={errors.district_id} />
                                </div>
                            </div>

                            <Button disabled={processing}>Kaydet</Button>
                        </>
                    )}
                </Form>
            </div>
        </>
    );
}

Account.layout = {
    breadcrumbs: [
        {
            title: 'Hesap Bilgileri',
            href: dashboard(),
        },
    ],
};
