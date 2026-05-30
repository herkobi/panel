import type { Auth } from '@/types/auth';
import type { NavigationGroup } from '@/types/navigation';

export type Branding = {
    name: string;
    slogan: string | null;
    logo: string;
    logo_dark: string;
    favicon: string;
};

declare module '@inertiajs/core' {
    export interface PageProps {
        name: string;
        branding: Branding;
        auth: Auth;
        navigation: NavigationGroup[];
        sidebarOpen: boolean;
        [key: string]: unknown;
    }
}
