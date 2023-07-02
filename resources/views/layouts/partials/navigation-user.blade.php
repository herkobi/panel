<ul class="sidebar-menu">
    <li class="menu-item {{ request()->routeIs('panel.home') ? 'active' : '' }}">
        <a href="{{ route('panel.home') }}" title="{{ __('user-navigation.dashboard') }}"
            class="d-flex align-items-center justify-content-start">
            <i class="ri-home-smile-2-line"></i> <span class="align-middle">{{ __('user-navigation.dashboard') }}</span>
        </a>
    </li>
    <li class="menu-header">{{ __('user-navigation.settings') }}</li>
    <li class="menu-item {{ request()->routeIs('panel.settings') ? 'active' : '' }}">
        <a href="{{ route('panel.app.settings') }}" title="{{ __('user-navigation.general-settings') }}"
            class="d-flex align-items-center justify-content-start">
            <i class="ri-settings-line"></i> <span
                class="align-middle">{{ __('user-navigation.general-settings') }}</span>
        </a>
    </li>
    <li class="menu-item">
        <a href="" title="{{ __('user-navigation.user-app-logs') }}"
            class="d-flex align-items-center justify-content-start">
            <i class="ri-archive-2-line"></i> <span
                class="align-middle">{{ __('user-navigation.user-app-logs') }}</span>
        </a>
    </li>
    <li class="menu-item">
        <a href="" title="{{ __('user-navigation.user-auth-logs') }}"
            class="d-flex align-items-center justify-content-start">
            <i class="ri-git-repository-private-line"></i> <span
                class="align-middle">{{ __('user-navigation.user-auth-logs') }}</span>
        </a>
    </li>
    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
        <li class="menu-item {{ request()->routeIs('panel.twofactor') ? 'active' : '' }}">
            <a href="{{ route('panel.twofactor') }}" title="{{ __('user-navigation.twofa') }}"
                class="d-flex align-items-center justify-content-start">
                <i class="ri-phone-lock-line"></i> <span class="align-middle">{{ __('user-navigation.twofa') }}</span>
            </a>
        </li>
    @endif
</ul>
