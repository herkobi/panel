<ul class="list-group list-group-flush mb-3">
    <li class="list-group-item">
        <a href="{{ route('panel.accounts.draft') }}"
            class="text-decoration-none {{ request()->routeIs('panel.accounts.draft') ? 'active' : '' }}">
            Duraklatılmış Hesaplar
        </a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('panel.accounts.passive') }}"
            class="text-decoration-none {{ request()->routeIs('panel.accounts.passive') ? 'active' : '' }}">
            Dondurulmuş Hesaplar
        </a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('panel.accounts.deleted') }}"
            class="text-decoration-none {{ request()->routeIs('panel.accounts.deleted') ? 'active' : '' }}">
            Silinmiş Hesaplar
        </a>
    </li>
</ul>
