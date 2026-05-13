export const USER_STATUS_VALUES = ['active', 'passive', 'draft'] as const;

export type UserStatus = (typeof USER_STATUS_VALUES)[number];

export const USER_STATUS_LABEL: Record<UserStatus, string> = {
    active: 'Aktif',
    passive: 'Pasif',
    draft: 'Kısıtlı',
};

export const USER_STATUS_OPTIONS = USER_STATUS_VALUES.map((value) => ({
    value,
    label: USER_STATUS_LABEL[value],
}));
