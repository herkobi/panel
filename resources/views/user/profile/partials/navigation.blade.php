<a href="{{ route('app.profile') }}"
    class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('app.profile') ? 'active' : '' }} py-3">Kişisel
    Bilgiler</a>
@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
    <a href="{{ route('app.profile.twofactor') }}"
        class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('app.profile.twofactor') ? 'active' : '' }} py-3">İki
        Faktörlü Doğrulama</a>
@endif
<a href="{{ route('app.profile.activity') }}"
    class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('app.profile.activity') ? 'active' : '' }} py-3">Hesap
    Etkinliği</a>
<a href="{{ route('app.profile.authlogs') }}"
    class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('app.profile.authlogs') ? 'active' : '' }} py-3">Oturum
    Kayıtları</a>
