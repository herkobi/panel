import { AppShell } from '@/components/app-shell';
import { AppContent } from '@/components/panel/app-content';
import { AppHeader } from '@/components/panel/app-header';
import type { PanelLayoutProps } from '@/types';

export default function AppHeaderLayout({
    children,
    breadcrumbs,
}: PanelLayoutProps) {
    return (
        <AppShell variant="header">
            <AppHeader breadcrumbs={breadcrumbs} />
            <AppContent variant="header">{children}</AppContent>
        </AppShell>
    );
}
