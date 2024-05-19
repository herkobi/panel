<div class="dropdown-menu panel-dropdown shadow-none pb-0">
    <span class="dropdown-header">Sistem Kullanıcıları</span>
    <a class="dropdown-item {{ request()->routeIs(['panel.users', 'panel.user.edit']) ? 'active' : '' }}"
        href="{{ route('panel.users') }}" title="Kullanıcılar">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-square">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M9 10a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
            <path d="M6 21v-1a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v1" />
            <path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z" />
        </svg>
        Kullanıcılar
    </a>
    <a class="dropdown-item {{ request()->routeIs('panel.user.create') ? 'active' : '' }}"
        href="{{ route('panel.user.create') }}" title="Yeni Kullanıcı">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users-plus">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M5 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
            <path d="M3 21v-2a4 4 0 0 1 4 -4h4c.96 0 1.84 .338 2.53 .901" />
            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            <path d="M16 19h6" />
            <path d="M19 16v6" />
        </svg>
        Yeni Kullanıcı Ekle
    </a>
</div>
