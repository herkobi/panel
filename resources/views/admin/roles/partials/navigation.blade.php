<div class="dropdown-menu panel-dropdown shadow-none pb-0">
    <span class="dropdown-header">Yetki ve İzinler</span>
    <a class="dropdown-item {{ request()->routeIs(['panel.roles', 'panel.role.edit', 'panel.role.detail']) ? 'active' : '' }}"
        href="{{ route('panel.roles') }}" title="Yetkiler">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon icon-tabler icons-tabler-outline"
            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path
                d="M12 21a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3a12 12 0 0 0 8.5 3c.568 1.933 .635 3.957 .223 5.89" />
            <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
            <path d="M19.001 15.5v1.5" />
            <path d="M19.001 21v1.5" />
            <path d="M22.032 17.25l-1.299 .75" />
            <path d="M17.27 20l-1.3 .75" />
            <path d="M15.97 17.25l1.3 .75" />
            <path d="M20.733 20l1.3 .75" />
        </svg>
        Yetkiler
    </a>
    @if (request()->routeIs(['panel.roles', 'panel.role.*']))
        <a class="dropdown-item {{ request()->routeIs('panel.role.create') ? 'active' : '' }} "
            href="{{ route('panel.role.create') }}" title="Yetkiler">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon icon-tabler icons-tabler-outline"
                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path
                    d="M12.462 20.87c-.153 .047 -.307 .09 -.462 .13a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3a12 12 0 0 0 8.5 3a12 12 0 0 1 .11 6.37" />
                <path d="M16 19h6" />
                <path d="M19 16v6" />
            </svg>
            Yetki Ekle
        </a>
        <div class="dropdown-divider my-0"></div>
    @endif
    @if (request()->routeIs(['panel.permissions.*', 'panel.permission.*']))
        <div class="dropdown-divider my-0"></div>
    @endif
    <a class="dropdown-item {{ request()->routeIs('panel.permissions.user') ? 'active' : '' }}"
        href="{{ route('panel.permissions.user') }}" title="İzinler">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon icon-tabler icons-tabler-outline"
            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" />
            <path d="M4 14l8 -3l8 3" />
        </svg>
        Kullanıcı İzinleri
    </a>
    <a class="dropdown-item {{ request()->routeIs('panel.permissions.admin') ? 'active' : '' }}"
        href="{{ route('panel.permissions.admin') }}" title="İzinler">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon icon-tabler icons-tabler-outline"
            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M6 21v-2a4 4 0 0 1 4 -4h2" />
            <path d="M22 16c0 4 -2.5 6 -3.5 6s-3.5 -2 -3.5 -6c1 0 2.5 -.5 3.5 -1.5c1 1 2.5 1.5 3.5 1.5z" />
            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
        </svg>
        Yönetici İzinleri
    </a>
    @if (request()->routeIs(['panel.permissions.*', 'panel.permission.*']))
        <a class="dropdown-item {{ request()->routeIs('panel.permission.create') ? 'active' : '' }}"
            href="{{ route('panel.permission.create') }}" title="Yetkiler">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon icon-tabler icons-tabler-outline"
                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 21a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3a12 12 0 0 0 8.5 3a12.01 12.01 0 0 1 .378 5" />
                <path
                    d="M18 22l3.35 -3.284a2.143 2.143 0 0 0 .005 -3.071a2.242 2.242 0 0 0 -3.129 -.006l-.224 .22l-.223 -.22a2.242 2.242 0 0 0 -3.128 -.006a2.143 2.143 0 0 0 -.006 3.071l3.355 3.296z" />
            </svg>
            İzin Ekle
        </a>
    @endif
</div>
