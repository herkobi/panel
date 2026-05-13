import { useFlashToast } from '@/hooks/use-flash-toast';
import PanelLayoutTemplate from '@/layouts/panel/app-sidebar-layout';
import type { BreadcrumbItem } from '@/types';

export default function PanelLayout({
    breadcrumbs = [],
    children,
}: {
    breadcrumbs?: BreadcrumbItem[];
    children: React.ReactNode;
}) {
    useFlashToast();

    return (
        <PanelLayoutTemplate breadcrumbs={breadcrumbs}>
            {children}
        </PanelLayoutTemplate>
    );
}
