import type { Status } from '@/types';

export type Currency = {
    id: string;
    code: string;
    name: string;
    symbol: string;
    decimal_places: number;
    thousands_separator: string;
    decimal_separator: string;
    status: Status;
    sort_order: number;
    deleted_at?: string | null;
};

export type Language = {
    id: string;
    code: string;
    name: string;
    native_name: string;
    status: Status;
    sort_order: number;
    deleted_at?: string | null;
};

export type Country = {
    id: string;
    code: string;
    name: string;
    slug: string;
    status: Status;
    sort_order: number;
    deleted_at?: string | null;
};

export type City = {
    id: string;
    country_id: string;
    code: string;
    name: string;
    status: Status;
    sort_order: number;
    deleted_at?: string | null;
};

export type District = {
    id: string;
    city_id: string;
    name: string;
    status: Status;
    sort_order: number;
    deleted_at?: string | null;
};

export type Tax = {
    id: string;
    name: string;
    rate: string | number;
    status: Status;
    sort_order: number;
    deleted_at?: string | null;
};

/**
 * Form select'lerinde kullanılan, ilgili tanım kaynağının küçültülmüş
 * "seçenek" görünümleri. Tam tipten türetilir, böylece backend alanı
 * değişince burası da derleme zamanında uyarır.
 */
export type LanguageOption = Pick<
    Language,
    'id' | 'code' | 'name' | 'native_name'
>;

export type CountryOption = Pick<Country, 'id' | 'name'>;

export type CityOption = Pick<City, 'id' | 'name' | 'country_id'>;

export type DistrictOption = Pick<District, 'id' | 'name' | 'city_id'>;
