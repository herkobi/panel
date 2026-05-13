import { AppContent } from '@/components/app/app-content';
import { AppSidebar } from '@/components/app/app-sidebar';
import { AppSidebarHeader } from '@/components/app/app-sidebar-header';
import { AppShell } from '@/components/app-shell';
import type { AppLayoutProps } from '@/types';

export default function AppSidebarLayout({
    children,
    breadcrumbs = [],
}: AppLayoutProps) {
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
