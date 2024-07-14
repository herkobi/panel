<ul class="navbar-nav mx-md-auto">
    <li class="nav-item {{ request()->routeIs('panel.home') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('panel.home') ? 'text-white' : '' }}" href="{{ route('panel.home') }}"
            title="Başlangıç">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                </svg>
            </span>
            <span class="nav-link-title">
                Başlangıç
            </span>
        </a>
    </li>
    @if (auth()->user()->hasRole('Super Admin'))
        <li class="nav-item {{ request()->routeIs('panel.tools.health') ? 'active' : '' }}">
            <a class="nav-link {{ request()->routeIs('panel.tools.health') ? 'text-white' : '' }}"
                href="{{ route('panel.tools.health') }}" title="Sistem Bilgisi">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path
                            d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z">
                        </path>
                        <path d="M12 9h.01"></path>
                        <path d="M11 12h1v4h1"></path>
                    </svg>
                </span>
                <span class="nav-link-title">
                    Sistem Bilgisi
                </span>
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('panel.tools.logs') ? 'active' : '' }}">
            <a class="nav-link {{ request()->routeIs('panel.tools.logs') ? 'text-white' : '' }}"
                href="{{ route('panel.tools.logs') }}" title="Sistem Kayıtları">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 12h.01"></path>
                        <path d="M4 6h.01"></path>
                        <path d="M4 18h.01"></path>
                        <path d="M8 18h2"></path>
                        <path d="M8 12h2"></path>
                        <path d="M8 6h2"></path>
                        <path d="M14 6h6"></path>
                        <path d="M14 12h6"></path>
                        <path d="M14 18h6"></path>
                    </svg>
                </span>
                <span class="nav-link-title">
                    Kayıtlar
                </span>
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('panel.settings.system') ? 'active' : '' }}">
            <a class="nav-link {{ request()->routeIs('panel.settings.system') ? 'text-white' : '' }}"
                href="{{ route('panel.settings.system') }}" title="Sistem Ayarları">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path
                            d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z">
                        </path>
                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                    </svg>
                </span>
                <span class="nav-link-title">
                    Sistem Ayarları
                </span>
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('panel.users') ? 'active' : '' }}">
            <a class="nav-link {{ request()->routeIs('panel.users') ? 'text-white' : '' }}"
                href="{{ route('panel.users') }}" title="Kullanıcılar">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M9 10a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                        <path d="M6 21v-1a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v1"></path>
                        <path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z">
                        </path>
                    </svg>
                </span>
                <span class="nav-link-title">
                    Kullanıcılar
                </span>
            </a>
        </li>
    @else
        <li class="nav-item {{ request()->routeIs(['panel.accounts', 'panel.account.*']) ? 'active' : '' }}">
            <a class="nav-link {{ request()->routeIs('panel.accounts') ? 'text-white' : '' }}"
                href="{{ route('panel.accounts') }}" title="Hesaplar">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                    </svg>
                </span>
                <span class="nav-link-title">
                    Hesaplar
                </span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#navbar-tools" title="Araçlar" data-bs-toggle="dropdown"
                data-bs-auto-close="outside" role="button" aria-expanded="false">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-tools">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 21h4l13 -13a1.5 1.5 0 0 0 -4 -4l-13 13v4" />
                        <path d="M14.5 5.5l4 4" />
                        <path d="M12 8l-5 -5l-4 4l5 5" />
                        <path d="M7 8l-1.5 1.5" />
                        <path d="M16 12l5 5l-4 4l-5 -5" />
                        <path d="M16 17l-1.5 1.5" />
                    </svg>
                </span>
                <span class="nav-link-title">
                    Araçlar
                </span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('panel.tools.accounts.auth.logs') }}"
                    title="Oturum Kayıtları">
                    Oturum Kayıtları
                </a>
                <a class="dropdown-item" href="{{ route('panel.tools.accounts.activities') }}"
                    title="Kullanıcı İşlemleri">
                    Kullanıcı İşlemleri
                </a>
                <a class="dropdown-item" href="{{ route('panel.tools.cache.cache') }}" title="Sistem Kayıtları">
                    Önbellek Yönetimi
                </a>
            </div>
        </li>
        <li
            class="nav-item {{ request()->routeIs(['panel.settings.*', 'panel.roles', 'panel.permissions', 'panel.permissiongroups', 'panel.pages', 'panel.page.*', 'panel.users', 'panel.user.*']) ? 'active' : '' }} dropdown">
            <a class="nav-link {{ request()->routeIs(['panel.settings.*', 'panel.roles', 'panel.permissions', 'panel.permissiongroups', 'panel.pages', 'panel.page.*', 'panel.users', 'panel.user.*']) ? 'text-white' : '' }} dropdown-toggle"
                href="#navbar-settings" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                aria-expanded="false">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                    </svg>
                </span>
                <span class="nav-link-title">
                    Ayarlar
                </span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('panel.settings.app') }}" title="Uygulama Ayarları">
                    Uygulama Ayarları
                </a>
                <div class="dropend">
                    <a class="dropdown-item dropdown-toggle" href="#definitions" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" role="button" aria-expanded="false">
                        Yetki ve İzinler
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('panel.roles') }}" class="dropdown-item">
                            Yetkiler
                        </a>
                        <a href="{{ route('panel.permissions.user') }}" class="dropdown-item">
                            Kullanıcı İzinleri
                        </a>
                        <a href="{{ route('panel.permissions.admin') }}" class="dropdown-item">
                            Yönetici İzinleri
                        </a>
                    </div>
                </div>
                <div class="dropend">
                    <a class="dropdown-item dropdown-toggle" href="#definitions" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" role="button" aria-expanded="false">
                        Tanımlamalar
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('panel.settings.payments') }}" title="Ödeme Yöntemleri"
                            class="dropdown-item">
                            Ödeme Yöntemleri
                        </a>
                        <a href="{{ route('panel.settings.taxes') }}" title="Vergi Oranları" class="dropdown-item">
                            Vergi Oranları
                        </a>
                        <a href="{{ route('panel.settings.currencies') }}" title="Para Birimleri"
                            class="dropdown-item">
                            Para Birimleri
                        </a>
                        <a href="{{ route('panel.settings.locations.countries') }}" title="Konum Bilgileri"
                            class="dropdown-item">
                            Konum Bilgileri
                        </a>
                        <a href="{{ route('panel.settings.languages') }}" title="Diller" class="dropdown-item">
                            Diller
                        </a>
                    </div>
                </div>
                <a class="dropdown-item" href="{{ route('panel.users') }}" title="Kullanıcılar">
                    Kullanıcılar
                </a>
                <a class="dropdown-item" href="{{ route('panel.pages') }}" title="Sayfalar">
                    Sayfalar & Sözleşmeler
                </a>
            </div>
        </li>
    @endif
</ul>
