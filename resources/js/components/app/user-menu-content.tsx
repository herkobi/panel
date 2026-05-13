import { Link, router } from '@inertiajs/react';
import { LogOut, Settings, Bell, UserRoundPen } from 'lucide-react';
import { UserInfo } from '@/components/app/user-info';
import {
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
} from '@/components/ui/dropdown-menu';
import { useMobileNavigation } from '@/hooks/use-mobile-navigation';
import { logout } from '@/routes';
import { account } from '@/routes/app';
import { edit } from '@/routes/app/profile';
import { notifications } from '@/routes/app/profile';
import type { AppUser } from '@/types';

type Props = {
    user: AppUser;
};

export function UserMenuContent({ user }: Props) {
    const cleanup = useMobileNavigation();

    const handleLogout = () => {
        cleanup();
        router.flushAll();
    };

    return (
        <>
            <DropdownMenuLabel className="p-0 font-normal">
                <div className="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                    <UserInfo user={user} showEmail={true} />
                </div>
            </DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuGroup>
                <DropdownMenuItem asChild>
                    <Link
                        className="block w-full cursor-pointer"
                        href={account()}
                        prefetch
                        onClick={cleanup}
                    >
                        <Settings className="mr-2" />
                        Hesabım
                    </Link>
                </DropdownMenuItem>
                <DropdownMenuSeparator />
                <DropdownMenuItem asChild>
                    <Link
                        className="block w-full cursor-pointer"
                        href={edit()}
                        prefetch
                        onClick={cleanup}
                    >
                        <UserRoundPen className="mr-2" />
                        Bilgilerim
                    </Link>
                </DropdownMenuItem>
                <DropdownMenuItem asChild>
                    <Link
                        className="block w-full cursor-pointer"
                        href={notifications()}
                        prefetch
                        onClick={cleanup}
                    >
                        <Bell className="mr-2" />
                        Bildirimler
                    </Link>
                </DropdownMenuItem>
            </DropdownMenuGroup>
            <DropdownMenuSeparator />
            <DropdownMenuItem asChild>
                <Link
                    className="block w-full cursor-pointer"
                    href={logout()}
                    as="button"
                    onClick={handleLogout}
                    data-test="logout-button"
                >
                    <LogOut className="mr-2" />
                    Oturumu Kapat
                </Link>
            </DropdownMenuItem>
        </>
    );
}
