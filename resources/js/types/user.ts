import type { UserStatus, UserType } from '@/types';

export type AppUser = {
    id: string;
    name: string;
    avatar?: string | null;
    email: string;
    user_type: UserType;
    status: UserStatus;
    email_verified_at: string | null;
    last_login_at?: string | null;
    media_directory?: string | null;
    two_factor_enabled?: boolean;
    unread_notifications_count?: number;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
};

export type PanelUser = {
    id: string;
    name: string;
    avatar?: string | null;
    email: string;
    user_type: UserType;
    status: UserStatus;
    email_verified_at: string | null;
    last_login_at?: string | null;
    media_directory?: string | null;
    two_factor_enabled?: boolean;
    unread_notifications_count?: number;
    roles?: string[];
    permissions?: string[];
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
};
