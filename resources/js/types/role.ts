/** Roller listesindeki özet satır (RoleResource). */
export type RoleItem = {
    uuid: string;
    name: string;
    is_system: boolean;
    permissions_count: number;
    users_count: number;
    created_at: string;
};

/** Rol detay/düzenleme ekranının modeli. */
export type RoleDetail = {
    uuid: string;
    name: string;
    is_system: boolean;
    permissions: string[];
    users_count?: number;
};

/** Kullanıcıya rol atama select'lerinde kullanılan minimal rol seçeneği. */
export type RoleOption = {
    name: string;
};
