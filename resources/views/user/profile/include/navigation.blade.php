<ul class="nav navtab-bg nav-pills flex-column" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route('app.profile') }}" class="nav-link {{ request()->routeIs('app.profile') ? 'active' : '' }}">
            <span>Bilgilerim</span>
        </a>
    </li>
    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
        <li class="nav-item" role="presentation">
            <a href="{{ route('app.profile.twofactor') }}"
                class="nav-link {{ request()->routeIs('app.profile.twofactor') ? 'active' : '' }}">
                <span>İki Faktörlü Doğrulama</span>
            </a>
        </li>
    @endif
    <li class="nav-item" role="presentation">
        <a href="{{ route('app.profile.activitylogs') }}"
            class="nav-link {{ request()->routeIs('app.profile.activitylogs') ? 'active' : '' }}">
            <span>İşlem Kayıtları</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('app.profile.authlogs') }}"
            class="nav-link {{ request()->routeIs('app.profile.authlogs') ? 'active' : '' }}">
            <span>Oturum Kayıtları</span>
        </a>
    </li>
</ul>
