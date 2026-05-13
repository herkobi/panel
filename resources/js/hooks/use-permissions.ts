import { usePanelAuth } from '@/hooks/use-panel-auth';

/**
 * Panel tarafının yetki ve rol kontrolü için tipli helper'lar.
 * Tüm hook'lar `usePanelAuth()` üzerinden çalışır; auth.user.roles ve
 * auth.user.permissions, HandleInertiaRequests middleware'inde paylaşılır.
 */

export function useCan(permission: string): boolean {
    const { user } = usePanelAuth();

    return user?.permissions?.includes(permission) ?? false;
}

export function useHasRole(role: string | string[]): boolean {
    const { user } = usePanelAuth();
    const userRoles = user?.roles ?? [];
    const needles = Array.isArray(role) ? role : [role];

    return needles.some((r) => userRoles.includes(r));
}

export function useIsSuperAdmin(): boolean {
    return useHasRole('Super Admin');
}
