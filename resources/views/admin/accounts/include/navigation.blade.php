<ul class="nav navtab-bg nav-pills flex-column" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route('panel.accounts') }}"
            class="nav-link {{ request()->routeIs('panel.accounts') ? 'active' : '' }}">
            <span>Aktif Hesaplar</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('panel.accounts.latest') }}"
            class="nav-link {{ request()->routeIs('panel.accounts.latest') ? 'active' : '' }}">
            <span>Yeni Hesaplar</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('panel.accounts.unverified') }}"
            class="nav-link {{ request()->routeIs('panel.accounts.unverified') ? 'active' : '' }}">
            <span>Onaylanmamış Hesaplar</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('panel.accounts.inactive') }}"
            class="nav-link {{ request()->routeIs('panel.accounts.inactive') ? 'active' : '' }}">
            <span>Durgun Hesaplar</span>
        </a>
    </li>
</ul>
