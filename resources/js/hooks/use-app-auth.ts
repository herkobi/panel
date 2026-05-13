import { usePage } from '@inertiajs/react';
import type { AppAuth, Auth } from '@/types/auth';

type SharedPageProps = {
    auth: Auth;
    [key: string]: unknown;
};

export function useAppAuth(): AppAuth {
    const { auth } = usePage<SharedPageProps>().props;

    if (auth.type !== 'app') {
        throw new Error('Invalid auth type.');
    }

    return auth;
}
