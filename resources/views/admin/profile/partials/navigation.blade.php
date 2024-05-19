<a href="{{ route('panel.profile') }}"
    class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('panel.profile') ? 'active' : '' }} py-3">Kişisel
    Bilgiler</a>
<a href="{{ route('panel.profile.settings') }}"
    class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('panel.profile.settings') ? 'active' : '' }} py-3">Hesap
    Bilgileri</a>
@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
    <a href="{{ route('panel.profile.twofactor') }}"
        class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('panel.profile.twofactor') ? 'active' : '' }} py-3">İki
        Faktörlü Doğrulama</a>
@endif
<a href="{{ route('panel.profile.activity') }}"
    class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('panel.profile.activity') ? 'active' : '' }} py-3">Hesap
    Aktivitesi</a>
<a href="{{ route('panel.profile.authlogs') }}"
    class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('panel.profile.authlogs') ? 'active' : '' }} py-3">Oturum
    Kayıtları</a>
