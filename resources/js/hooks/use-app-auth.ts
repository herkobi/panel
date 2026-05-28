import type { PageProps } from '@inertiajs/core';
import { usePage } from '@inertiajs/react';
import type { AppAuth } from '@/types/auth';

export function useAppAuth(): AppAuth {
    const { auth } = usePage<PageProps>().props;

    if (auth.type !== 'app') {
        throw new Error('Invalid auth type.');
    }

    return auth;
}
