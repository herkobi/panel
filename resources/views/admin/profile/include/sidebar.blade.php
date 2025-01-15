<ul class="list-group list-group-flush">
    <li class="list-group-item {{ request()->routeIs('panel.profile') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.profile') }}" title="Bilgilerim"">
            Bilgilerim
        </a>
    </li>
    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
        <li class="list-group-item {{ request()->routeIs('panel.profile.twofactor') ? 'fw-medium' : '' }}">
            <a href="{{ route('panel.profile.twofactor') }}" title="İki Faktörlü Doğrulama"">
                İki Faktörlü Doğrulama
            </a>
        </li>
    @endif
    <li class="list-group-item {{ request()->routeIs('panel.profile.activitylogs') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.profile.activitylogs') }}" title="İşlem Kayıtları"">
            İşlem Kayıtları
        </a>
    </li>
    <li class="list-group-item {{ request()->routeIs('panel.profile.authlogs') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.profile.authlogs') }}" title="Oturum Kayıtları"">
            Oturum Kayıtları
        </a>
    </li>
</ul>
