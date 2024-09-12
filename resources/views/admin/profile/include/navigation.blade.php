<ul class="nav navtab-bg nav-pills flex-column" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route('panel.profile') }}" class="nav-link {{ request()->routeIs('panel.profile') ? 'active' : '' }}">
            <span>Bilgilerim</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="#password" class="nav-link">
            <span>Şifre Değiştir</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="#notifications-form" class="nav-link">
            <span>Oturum Kayıtları</span>
        </a>
    </li>
</ul>
