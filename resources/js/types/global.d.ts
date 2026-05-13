import type { Auth } from '@/types/auth';

declare module '@inertiajs/core' {
    export interface PageProps {
        name: string;
        auth: Auth;
        sidebarOpen: boolean;
        [key: string]: unknown;
    }
}
