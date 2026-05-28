import type { Method } from '@inertiajs/core';
import { router } from '@inertiajs/react';
import { useState } from 'react';
import type { ReactNode } from 'react';

import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';

type RouteAction = { url: string; method: Method };

type ConfirmDeleteProps = {
    action: RouteAction;
    title: string;
    description?: string;
    confirmLabel?: string;
    cancelLabel?: string;
    preserveScroll?: boolean;
    children: ReactNode;
};

export function ConfirmDelete({
    action,
    title,
    description,
    confirmLabel = 'Sil',
    cancelLabel = 'Vazgeç',
    preserveScroll = true,
    children,
}: ConfirmDeleteProps) {
    const [open, setOpen] = useState(false);
    const [processing, setProcessing] = useState(false);

    const handleConfirm = (event: React.MouseEvent<HTMLButtonElement>) => {
        event.preventDefault();
        setProcessing(true);

        router.visit(action.url, {
            method: action.method,
            preserveScroll,
            onFinish: () => {
                setProcessing(false);
                setOpen(false);
            },
        });
    };

    return (
        <AlertDialog open={open} onOpenChange={setOpen}>
            <AlertDialogTrigger asChild>{children}</AlertDialogTrigger>
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>{title}</AlertDialogTitle>
                    {description && (
                        <AlertDialogDescription>
                            {description}
                        </AlertDialogDescription>
                    )}
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel disabled={processing}>
                        {cancelLabel}
                    </AlertDialogCancel>
                    <AlertDialogAction
                        onClick={handleConfirm}
                        disabled={processing}
                        className="bg-destructive text-white hover:bg-destructive/90 focus-visible:ring-destructive/30"
                    >
                        {confirmLabel}
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    );
}
