<ul class="sidebar-menu">
    <li class="menu-item {{ request()->routeIs('panel.admin') ? 'active' : '' }}">
        <a href="{{ route('panel.admin') }}" title="{{ __('admin-navigation.dashboard') }}"
            class="d-flex align-items-center justify-content-start">
            <i class="ri-home-smile-2-line"></i> <span class="align-middle">{{ __('admin-navigation.dashboard') }}</span>
        </a>
    </li>
    @hasrole(['Super Admin', 'Admin'])
        <li class="menu-header">{{ __('admin-navigation.users') }}</li>
        <li class="menu-item {{ request()->routeIs('panel.users') ? 'active' : '' }}">
            <a href="{{ route('panel.users') }}" title="{{ __('admin-navigation.users') }}"
                class="d-flex align-items-center justify-content-start">
                <i class="ri-user-line"></i> <span class="align-middle">{{ __('admin-navigation.users') }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('panel.user.tags') ? 'active' : '' }}">
            <a href="{{ route('panel.user.tags') }}" title="{{ __('admin-navigation.tags') }}"
                class="d-flex align-items-center justify-content-start">
                <i class="ri-hashtag"></i> <span class="align-middle">{{ __('admin-navigation.tags') }}</span>
            </a>
        </li>
    @endhasallroles
    @hasrole('Super Admin')
        <li class="menu-header">{{ __('admin-navigation.admins') }}</li>
        <li class="menu-item {{ request()->routeIs('panel.admins') ? 'active' : '' }}">
            <a href="{{ route('panel.admins') }}" title="{{ __('admin-navigation.admins') }}"
                class="d-flex align-items-center justify-content-start">
                <i class="ri-user-line"></i> <span class="align-middle">{{ __('admin-navigation.admins') }}</span>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('panel.create.admin') ? 'active' : '' }}">
            <a href="{{ route('panel.create.admin') }}" title="{{ __('admin-navigation.add-admin') }}"
                class="d-flex align-items-center justify-content-start">
                <i class="ri-user-add-line"></i> <span class="align-middle">{{ __('admin-navigation.add-admin') }}</span>
            </a>
        </li>
    @endhasrole
    @hasrole(['Super Admin', 'Admin'])
        <li class="menu-header">{{ __('admin-navigation.settings') }}</li>
        @if (Helper::checkUserSettings())
            <li class="menu-item {{ request()->routeIs('panel.general.user.settings') ? 'active' : '' }}">
                <a href="{{ route('panel.general.user.settings') }}" title="{{ __('admin-navigation.general-settings') }}"
                    class="d-flex align-items-center justify-content-start">
                    <i class="ri-settings-line"></i> <span
                        class="align-middle">{{ __('admin-navigation.general-settings') }}</span>
                </a>
            </li>
        @endif
        @hasrole('Super Admin')
            <li class="menu-item {{ request()->routeIs('panel.system.settings') ? 'active' : '' }}">
                <a href="{{ route('panel.system.settings') }}" title="{{ __('admin-navigation.system-settings') }}"
                    class="d-flex align-items-center justify-content-start">
                    <i class="ri-settings-2-line"></i> <span
                        class="align-middle">{{ __('admin-navigation.system-settings') }}</span>
                </a>
            </li>
        @endhasrole
        <li class="menu-item">
            <a data-bs-target="#roles" data-bs-toggle="collapse" title="{{ __('admin-navigation.role-and-permissions') }}"
                class="d-flex align-items-center justify-content-start collapsed" aria-expanded="false">
                <i class="ri-secure-payment-line"></i> <span
                    class="align-middle">{{ __('admin-navigation.role-and-permissions') }}</span>
            </a>
            <ul id="roles" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                @can('role-list')
                    <li class="menu-item"><a href="{{ route('panel.roles') }}" title="{{ __('admin-navigation.roles') }}""
                            class="menu-link">{{ __('admin-navigation.roles') }}</a></li>
                @endcan
                @can('permission-list')
                    <li class="menu-item"><a href="{{ route('panel.permissions') }}"
                            title="{{ __('admin-navigation.permissions') }}"
                            class="menu-link">{{ __('admin-navigation.permissions') }}</a></li>
                @endcan
                @can('permissiongroup-list')
                    <li class="menu-item"><a href="{{ route('panel.permission.groups') }}"
                            title="{{ __('admin-navigation.permission-groups') }}"
                            class="menu-link">{{ __('admin-navigation.permission-groups') }}</a>
                    </li>
                @endcan
            </ul>
        </li>
    @endhasrole
    @hasrole('Super Admin')
        <li class="menu-item">
            <a href="{{ route('panel.system-logs') }}" title="{{ __('admin-navigation.system-logs') }}"
                class="d-flex align-items-center justify-content-start">
                <i class="ri-bubble-chart-line"></i> <span
                    class="align-middle">{{ __('admin-navigation.system-logs') }}</span>
            </a>
        </li>
    @endhasrole
    @hasrole(['Super Admin', 'Admin'])
        <li class="menu-item">
            <a data-bs-target="#user-logs" data-bs-toggle="collapse" title="{{ __('admin-navigation.user-logs') }}"
                class="d-flex align-items-center justify-content-start collapsed" aria-expanded="false">
                <i class="ri-profile-line"></i> <span class="align-middle">{{ __('admin-navigation.user-logs') }}</span>
            </a>
            <ul id="user-logs" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                <li class="menu-item"><a href="{{ route('panel.user.activity') }}"
                        title="{{ __('admin-navigation.user-app-logs') }}"
                        class="menu-link">{{ __('admin-navigation.user-app-logs') }}</a>
                </li>
                <li class="menu-item"><a href="" title="{{ __('admin-navigation.user-auth-logs') }}"
                        class="menu-link">{{ __('admin-navigation.user-auth-logs') }}</a>
                </li>
            </ul>
        </li>
    @endhasrole
    @hasrole('Super Admin')
        <li class="menu-item">
            <a data-bs-target="#admin-logs" data-bs-toggle="collapse" title="{{ __('admin-navigation.admin-logs') }}"
                class="d-flex align-items-center justify-content-start collapsed" aria-expanded="false">
                <i class="ri-folder-user-line"></i> <span
                    class="align-middle">{{ __('admin-navigation.admin-logs') }}</span>
            </a>
            <ul id="admin-logs" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                <li class="menu-item"><a href="{{ route('panel.admin.activity') }}"
                        title="{{ __('admin-navigation.admin-app-logs') }}"
                        class="menu-link">{{ __('admin-navigation.admin-app-logs') }}</a></li>
                <li class="menu-item"><a href="" title="{{ __('admin-navigation.admin-auth-logs') }}"
                        class="menu-link">{{ __('admin-navigation.admin-auth-logs') }}</a></li>
            </ul>
        </li>
    @endhasrole
    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
        <li class="menu-item {{ request()->routeIs('panel.twofactor') ? 'active' : '' }}">
            <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.twofactor') }}"
                title="{{ __('admin-navigation.2fa') }}">
                <i class="ri-phone-lock-line"></i> <span class="align-middle">{{ __('admin-navigation.2fa') }}</span>
            </a>
        </li>
    @endif
</ul>
