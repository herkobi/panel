<ul class="list-group list-group-flush">
    <li class="list-group-item {{ request()->routeIs('app.profile') ? 'fw-medium' : '' }}">
        <a href="{{ route('app.profile') }}" title="Bilgilerim">
            Hesap Bilgileri
        </a>
    </li>
</ul>
