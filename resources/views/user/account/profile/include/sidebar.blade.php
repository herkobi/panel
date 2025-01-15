<ul class="list-group list-group-flush">
    <li class="list-group-item {{ request()->routeIs('app.profile') ? 'fw-medium' : '' }}">
        <a href="{{ route('app.profile') }}" title="Bilgilerim"">
            Bilgilerim
        </a>
    </li>
    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
        <li class="list-group-item {{ request()->routeIs('app.profile.twofactor') ? 'fw-medium' : '' }}">
            <a href="{{ route('app.profile.twofactor') }}" title="İki Faktörlü Doğrulama"">
                İki Faktörlü Doğrulama
            </a>
        </li>
    @endif
    <li class="list-group-item {{ request()->routeIs('app.profile.activitylogs') ? 'fw-medium' : '' }}">
        <a href="{{ route('app.profile.activitylogs') }}" title="İşlem Kayıtları"">
            İşlem Kayıtları
        </a>
    </li>
    <li class="list-group-item {{ request()->routeIs('app.profile.authlogs') ? 'fw-medium' : '' }}">
        <a href="{{ route('app.profile.authlogs') }}" title="Oturum Kayıtları"">
            Oturum Kayıtları
        </a>
    </li>
</ul>
