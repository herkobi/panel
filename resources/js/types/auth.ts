import type { AppUser, PanelUser } from '@/types/user';

export type AppAuth = {
    type: 'app';
    user: AppUser | null;
};

export type PanelAuth = {
    type: 'panel';
    user: PanelUser | null;
};

export type Auth = AppAuth | PanelAuth;

export type TwoFactorSetupData = {
    svg: string;
    url: string;
};

export type TwoFactorSecretKey = {
    secretKey: string;
};
