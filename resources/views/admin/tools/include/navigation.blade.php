<ul class="nav navtab-bg nav-pills flex-column" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route('panel.tools.cache') }}"
            class="nav-link {{ request()->routeIs('panel.tools.cache') ? 'active' : '' }}">
            <span>Önbellek Yönetimi</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('panel.tools.user.authLogs') }}"
            class="nav-link {{ request()->routeIs('panel.tools.user.authLogs') ? 'active' : '' }}">
            <span>Kullanıcı Oturumları</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('panel.tools.admin.authLogs') }}"
            class="nav-link {{ request()->routeIs('panel.tools.admin.authLogs') ? 'active' : '' }}">
            <span>Yönetici Oturumları</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('panel.tools.logs') }}"
            class="nav-link {{ request()->routeIs('panel.tools.logs') ? 'active' : '' }}">
            <span>İşlem Kayıtları</span>
        </a>
    </li>
</ul>
