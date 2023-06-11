<ul class="sidebar-menu">
    <li class="menu-item {{ request()->routeIs('panel.home') ? 'active' : '' }}">
        <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.home') }}" title="Başlangıç">
            <i class="ri-home-smile-2-line"></i> <span class="align-middle">Başlangıç</span>
        </a>
    </li>
    @hasrole(['Super Admin', 'Admin'])
    <li class="menu-header">Kullanıcılar</li>
    <li class="menu-item {{ request()->routeIs('panel.users') ? 'active' : '' }}">
        <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.users') }}" title="Kullanıcılar">
            <i class="ri-user-line"></i> <span class="align-middle">Kullanıcılar</span>
        </a>
    </li>
    @endhasallroles
    @hasrole('Super Admin')
    <li class="menu-header">Yöneticiler</li>
    <li class="menu-item {{ request()->routeIs('panel.admins') ? 'active' : '' }}">
        <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.admins') }}" title="Yöneticiler">
            <i class="ri-user-line"></i> <span class="align-middle">Yöneticiler</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('panel.create.admin') ? 'active' : '' }}">
        <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.create.admin') }}" title="Yeni Yönetici">
            <i class="ri-user-add-line"></i> <span class="align-middle">Yeni Yönetici</span>
        </a>
    </li>
    @endhasrole
    @hasrole(['Super Admin', 'Admin'])
    <li class="menu-header">Ayarlar</li>
    <li class="menu-item {{ request()->routeIs('panel.settings') ? 'active' : '' }}">
        <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.settings') }}" title="Genel Ayarlar">
            <i class="ri-settings-line"></i> <span class="align-middle">Genel Ayarlar</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('panel.roles') ? 'active' : '' }}">
        <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.roles') }}" title="Yetkiler">
            <i class="ri-secure-payment-line"></i> <span class="align-middle">Yetkiler</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('panel.permissions') ? 'active' : '' }}">
        <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.permissions') }}" title="İzinler">
            <i class="ri-fingerprint-line"></i> <span class="align-middle">İzinler</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('panel.permission.groups') ? 'active' : '' }}">
        <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.permission.groups') }}" title="İzin Grupları">
            <i class="ri-file-shield-2-line"></i> <span class="align-middle">İzin Grupları</span>
        </a>
    </li>
    @endhasrole
    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
    <li class="menu-item {{ request()->routeIs('panel.twofactor') ? 'active' : '' }}">
        <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.twofactor') }}" title="2 Faktörlü Doğrulama">
            <i class="ri-phone-lock-line"></i> <span class="align-middle">2 Faktörlü Doğrulama</span>
        </a>
    </li>
    @endif
</ul>
