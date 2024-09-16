<ul class="nav navtab-bg nav-pills flex-column" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route('panel.settings.general') }}"
            class="nav-link {{ request()->routeIs('panel.settings.general') ? 'active' : '' }}">
            <span>Genel Ayarlar</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('panel.settings.users') }}"
            class="nav-link {{ request()->routeIs(['panel.settings.users', 'panel.settings.user.*']) ? 'active' : '' }}">
            <span>Yönetici Hesapları</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('panel.settings.pages') }}"
            class="nav-link {{ request()->routeIs(['panel.settings.pages', 'panel.settings.page.*']) ? 'active' : '' }}">
            <span>Sayfalar &amp; Sözleşmeler</span>
        </a>
    </li>
</ul>
