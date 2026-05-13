import { router, usePage } from '@inertiajs/react';
import { useCallback, useEffect, useRef } from 'react';
import { toast } from 'sonner';
import type { FlashMessages, FlashToast } from '@/types/ui';

export function useFlashToast(): void {
    const page = usePage<{ flash?: FlashMessages }>();
    const lastToastRef = useRef<string | null>(null);
    const toastCounterRef = useRef<number>(0);
    const resetLastToastRef = useRef<ReturnType<typeof setTimeout> | null>(
        null,
    );

    const showToastMessage = useCallback(
        (type: FlashToast['type'], message?: string | null): void => {
            if (!message) {
                return;
            }

            const key = `${type}:${message}`;

            if (lastToastRef.current === key) {
                return;
            }

            lastToastRef.current = key;

            if (resetLastToastRef.current) {
                clearTimeout(resetLastToastRef.current);
            }

            resetLastToastRef.current = setTimeout(() => {
                if (lastToastRef.current === key) {
                    lastToastRef.current = null;
                }

                resetLastToastRef.current = null;
            }, 100);

            toastCounterRef.current += 1;

            toast[type](message, {
                id: `${key}:${Date.now()}:${toastCounterRef.current}`,
            });
        },
        [],
    );

    const showFlash = useCallback(
        (flashData: unknown): void => {
            const data = flashData as FlashMessages | undefined;

            if (!data) {
                return;
            }

            if (data.toast) {
                showToastMessage(data.toast.type, data.toast.message);

                return;
            }

            showToastMessage('success', data.success);
            showToastMessage('error', data.error);
            showToastMessage('warning', data.warning);
            showToastMessage('info', data.info);
        },
        [showToastMessage],
    );

    useEffect(() => {
        showFlash(page.flash);
    }, [page.flash, showFlash]);

    useEffect(() => {
        showFlash(page.props.flash);
    }, [page.props.flash, showFlash]);

    useEffect(() => {
        return router.on('flash', (event) => {
            showFlash((event as CustomEvent).detail?.flash);
        });
    }, [showFlash]);

    useEffect(() => {
        return () => {
            if (resetLastToastRef.current) {
                clearTimeout(resetLastToastRef.current);
            }
        };
    }, []);
}
