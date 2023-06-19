<ul class="sidebar-menu">
    <li class="menu-item {{ request()->routeIs('panel.home') ? 'active' : '' }}">
        <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.home') }}" title="Başlangıç">
            <i class="ri-home-smile-2-line"></i> <span class="align-middle">Başlangıç</span>
        </a>
    </li>
    @hasrole(['Super Admin', 'Admin'])
        <li class="menu-header">Kullanıcılar</li>
        <li class="menu-item {{ request()->routeIs('panel.users') ? 'active' : '' }}">
            <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.users') }}"
                title="Kullanıcılar">
                <i class="ri-user-line"></i> <span class="align-middle">Kullanıcılar</span>
            </a>
        </li>
    @endhasallroles
    @hasrole('Super Admin')
        <li class="menu-header">Yöneticiler</li>
        <li class="menu-item {{ request()->routeIs('panel.admins') ? 'active' : '' }}">
            <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.admins') }}"
                title="Yöneticiler">
                <i class="ri-user-line"></i> <span class="align-middle">Yöneticiler</span>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('panel.create.admin') ? 'active' : '' }}">
            <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.create.admin') }}"
                title="Yeni Yönetici">
                <i class="ri-user-add-line"></i> <span class="align-middle">Yeni Yönetici</span>
            </a>
        </li>
    @endhasrole
    @hasrole(['Super Admin', 'Admin'])
        <li class="menu-header">Ayarlar</li>
        @can('settings-list')
            <li class="menu-item {{ request()->routeIs('panel.settings') ? 'active' : '' }}">
                <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.settings') }}"
                    title="Genel Ayarlar">
                    <i class="ri-settings-line"></i> <span class="align-middle">Genel Ayarlar</span>
                </a>
            </li>
        @endcan
        <li class="menu-item">
            <a data-bs-target="#roles" data-bs-toggle="collapse"
                class="d-flex align-items-center justify-content-start collapsed" aria-expanded="false">
                <i class="ri-secure-payment-line"></i> <span class="align-middle">Yetki ve İzinler</span>
            </a>
            <ul id="roles" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                @can('role-list')
                    <li class="menu-item"><a class="menu-link" href="{{ route('panel.roles') }}">Yetkiler</a></li>
                @endcan
                @can('permission-list')
                    <li class="menu-item"><a class="menu-link" href="{{ route('panel.permissions') }}">İzinler</a></li>
                @endcan
                @can('permissiongroup-list')
                    <li class="menu-item"><a class="menu-link" href="{{ route('panel.permission.groups') }}">İzin Grupları</a></li>
                @endcan
            </ul>
        </li>
    @endhasrole
    <li class="menu-item">
        <a href="" class="d-flex align-items-center justify-content-start">
            <i class="ri-bubble-chart-line"></i> <span class="align-middle">Sistem Kayıtları</span>
        </a>
    </li>
    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
        <li class="menu-item {{ request()->routeIs('panel.twofactor') ? 'active' : '' }}">
            <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.twofactor') }}"
                title="2 Faktörlü Doğrulama">
                <i class="ri-phone-lock-line"></i> <span class="align-middle">2 Faktörlü Doğrulama</span>
            </a>
        </li>
    @endif
</ul>
