import { createInertiaApp } from '@inertiajs/react';
import 'sonner/dist/styles.css';
import { Toaster } from '@/components/ui/sonner';
import { TooltipProvider } from '@/components/ui/tooltip';
import { initializeTheme } from '@/hooks/use-appearance';
import AppAccountLayout from '@/layouts/app/account/layout';
import AppProfileLayout from '@/layouts/app/profile/layout';
import AppLayout from '@/layouts/app-layout';
import AuthLayout from '@/layouts/auth-layout';
import PanelMembersLayout from '@/layouts/panel/members/layout';
import PanelProfileLayout from '@/layouts/panel/profile/layout';
import PanelGeneralLayout from '@/layouts/panel/settings/general/layout';
import PanelRolesLayout from '@/layouts/panel/settings/roles/layout';
import PanelUsersLayout from '@/layouts/panel/settings/users/layout';
import PanelActivityLayout from '@/layouts/panel/tools/activity/layout';
import PanelCacheLayout from '@/layouts/panel/tools/cache/layout';
import PanelDefinitionsLayout from '@/layouts/panel/tools/definitions/layout';
import PanelLayout from '@/layouts/panel-layout';

const appName = import.meta.env.VITE_APP_NAME || 'Herkobi';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    layout: (name) => {
        switch (true) {
            case name === 'welcome':
                return null;
            case name.startsWith('auth/'):
                return AuthLayout;
            case name.startsWith('app/profile/'):
                return [AppLayout, AppProfileLayout];
            case name.startsWith('app/account/'):
                return [AppLayout, AppAccountLayout];
            case name.startsWith('app/'):
                return [AppLayout];
            case name.startsWith('panel/profile/'):
                return [PanelLayout, PanelProfileLayout];
            case name.startsWith('panel/members/'):
                return [PanelLayout, PanelMembersLayout];
            case name.startsWith('panel/settings/general/'):
                return [PanelLayout, PanelGeneralLayout];
            case name.startsWith('panel/settings/users/'):
                return [PanelLayout, PanelUsersLayout];
            case name.startsWith('panel/settings/roles/'):
                return [PanelLayout, PanelRolesLayout];
            case name.startsWith('panel/tools/activity/'):
                return [PanelLayout, PanelActivityLayout];
            case name.startsWith('panel/tools/cache/'):
                return [PanelLayout, PanelCacheLayout];
            case name.startsWith('panel/tools/definitions/'):
                return [PanelLayout, PanelDefinitionsLayout];
            case name.startsWith('panel/'):
                return [PanelLayout];
            default:
                return AppLayout;
        }
    },
    strictMode: true,
    withApp(app) {
        return (
            <TooltipProvider delayDuration={0}>
                {app}
                <Toaster />
            </TooltipProvider>
        );
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on load...
initializeTheme();
