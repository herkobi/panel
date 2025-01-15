<ul class="list-group list-group-flush mb-3">
    <li class="list-group-item {{ request()->routeIs('panel.accounts') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.accounts') }}" title="Aktif Hesaplar">
            Aktif Hesaplar
        </a>
    </li>
    <li class="list-group-item {{ request()->routeIs('panel.accounts.latest') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.accounts.latest') }}" title="Yeni Hesaplar">
            Yeni Hesaplar
        </a>
    </li>
    <li class="list-group-item {{ request()->routeIs('panel.accounts.unverified') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.accounts.unverified') }}" title="Onaylanmamış Hesaplar">
            Onaylanmamış Hesaplar
        </a>
    </li>
    <li class="list-group-item {{ request()->routeIs('panel.accounts.inactive') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.accounts.inactive') }}" title="Durgun Hesaplar">
            Durgun Hesaplar
        </a>
    </li>
</ul>
<ul class="list-group list-group-flush mb-3">
    <li class="list-group-item {{ request()->routeIs('panel.accounts.draft') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.accounts.draft') }}" title="">
            Duraklatılmış Hesaplar
        </a>
    </li>
    <li class="list-group-item {{ request()->routeIs('panel.accounts.passive') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.accounts.passive') }}" title="">
            Dondurulmuş Hesaplar
        </a>
    </li>
    <li class="list-group-item {{ request()->routeIs('panel.accounts.deleted') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.accounts.deleted') }}" title="">
            Silinmiş Hesaplar
        </a>
    </li>
</ul>
