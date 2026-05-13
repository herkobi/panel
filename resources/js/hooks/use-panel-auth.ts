import { usePage } from '@inertiajs/react';
import type { PanelAuth, Auth } from '@/types/auth';

type SharedPageProps = {
    auth: Auth;
    [key: string]: unknown;
};

export function usePanelAuth(): PanelAuth {
    const { auth } = usePage<SharedPageProps>().props;

    if (auth.type !== 'panel') {
        throw new Error('Invalid auth type..');
    }

    return auth;
}
