export type Address = {
    address: string | null;
    postal_code: string | null;
    district_id: string | null;
    city_id: string | null;
    country_id: string | null;
};

export type Account = {
    id: string;
    code: string;
    title: string | null;
    address: Address | null;
};
