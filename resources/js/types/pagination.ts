export type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

export type PaginationMeta = {
    current_page: number;
    from: number | null;
    last_page: number;
    path?: string;
    per_page?: number;
    to: number | null;
    total: number;
};

export interface PaginationResponse<T> {
    data: T[];
    links: PaginationLink[];
    meta?: PaginationMeta;
    current_page: number;
    first_page_url: string;
    from: number | null;
    last_page: number;
    last_page_url: string;
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number | null;
    total: number;
}

export type Paginated<T> = PaginationResponse<T>;
