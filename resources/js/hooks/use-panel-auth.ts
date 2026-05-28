import type { PageProps } from '@inertiajs/core';
import { usePage } from '@inertiajs/react';
import type { PanelAuth } from '@/types/auth';

export function usePanelAuth(): PanelAuth {
    const { auth } = usePage<PageProps>().props;

    if (auth.type !== 'panel') {
        throw new Error('Invalid auth type..');
    }

    return auth;
}
