export const USER_TYPE_VALUES = ['admin', 'member'] as const;

export type UserType = (typeof USER_TYPE_VALUES)[number];

export const USER_TYPE_LABEL: Record<UserType, string> = {
    admin: 'Yönetici',
    member: 'Üye',
};

export const USER_TYPE_OPTIONS = USER_TYPE_VALUES.map((value) => ({
    value,
    label: USER_TYPE_LABEL[value],
}));
