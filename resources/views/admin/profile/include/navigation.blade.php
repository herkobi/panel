<ul class="nav navtab-bg nav-pills flex-column" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route('panel.profile') }}" class="nav-link {{ request()->routeIs('panel.profile') ? 'active' : '' }}">
            <span>Bilgilerim</span>
        </a>
    </li>
    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
        <li class="nav-item" role="presentation">
            <a href="{{ route('panel.profile.twofactor') }}"
                class="nav-link {{ request()->routeIs('panel.profile.twofactor') ? 'active' : '' }}">
                <span>İki Faktörlü Doğrulama</span>
            </a>
        </li>
    @endif
    <li class="nav-item" role="presentation">
        <a href="{{ route('panel.profile.activitylogs') }}"
            class="nav-link {{ request()->routeIs('panel.profile.activitylogs') ? 'active' : '' }}">
            <span>İşlem Kayıtları</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('panel.profile.authlogs') }}"
            class="nav-link {{ request()->routeIs('panel.profile.authlogs') ? 'active' : '' }}">
            <span>Oturum Kayıtları</span>
        </a>
    </li>
</ul>
