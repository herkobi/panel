export const STATUS = ['active', 'passive'] as const;

export type Status = (typeof STATUS)[number];

export const STATUS_LABEL: Record<Status, string> = {
    active: 'Aktif',
    passive: 'Pasif',
};

export const STATUS_OPTIONS = STATUS.map((value) => ({
    value,
    label: STATUS_LABEL[value],
}));
