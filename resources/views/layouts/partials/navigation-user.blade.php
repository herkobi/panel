<ul class="sidebar-menu">
    <li class="menu-item {{ request()->routeIs('panel.home') ? 'active' : '' }}">
        <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.home') }}" title="Başlangıç">
            <i class="ri-home-smile-2-line"></i> <span class="align-middle">Başlangıç</span>
        </a>
    </li>
    <li class="menu-header">Ayarlar</li>
    <li class="menu-item {{ request()->routeIs('panel.settings') ? 'active' : '' }}">
        <a class="d-flex align-items-center justify-content-start" href="{{ route('panel.app.settings') }}"
            title="Genel Ayarlar">
            <i class="ri-settings-line"></i> <span class="align-middle">Genel Ayarlar</span>
        </a>
    </li>
    <li class="menu-item">
        <a href="" class="d-flex align-items-center justify-content-start">
            <i class="ri-archive-2-line"></i> <span class="align-middle">Uygulama Kayıtları</span>
        </a>
    </li>
    <li class="menu-item">
        <a href="" class="d-flex align-items-center justify-content-start">
            <i class="ri-git-repository-private-line"></i> <span class="align-middle">Oturum Kayıtları</span>
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
