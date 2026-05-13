import { AppShell } from '@/components/app-shell';
import { AppContent } from '@/components/panel/app-content';
import { AppSidebar } from '@/components/panel/app-sidebar';
import { AppSidebarHeader } from '@/components/panel/app-sidebar-header';
import type { PanelLayoutProps } from '@/types';

export default function AppSidebarLayout({
    children,
    breadcrumbs = [],
}: PanelLayoutProps) {
    return (
        <AppShell variant="sidebar">
            <AppSidebar />
            <AppContent variant="sidebar" className="overflow-x-hidden">
                <AppSidebarHeader breadcrumbs={breadcrumbs} />
                {children}
            </AppContent>
        </AppShell>
    );
}
