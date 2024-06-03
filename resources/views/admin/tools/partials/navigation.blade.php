<div class="dropdown-menu panel-dropdown shadow-none pb-0">
    <span class="dropdown-header">Araçlar</span>
    @if (auth()->user()->hasRole('Super Admin'))
        <a class="dropdown-item {{ request()->routeIs(['panel.tools.health', 'panel.tools.health']) ? 'active' : '' }}"
            href="{{ route('panel.tools.health') }}" title="Sistem Bilgisi">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon dropdown-item-icon">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path
                    d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
                <path d="M12 9h.01" />
                <path d="M11 12h1v4h1" />
            </svg>
            Sistem Bilgisi
        </a>
        <a class="dropdown-item {{ request()->routeIs('panel.tools.logs') ? 'active' : '' }}"
            href="{{ route('panel.tools.logs') }}" title="Sistem Kayıtları">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon dropdown-item-icon">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M4 12h.01" />
                <path d="M4 6h.01" />
                <path d="M4 18h.01" />
                <path d="M8 18h2" />
                <path d="M8 12h2" />
                <path d="M8 6h2" />
                <path d="M14 6h6" />
                <path d="M14 12h6" />
                <path d="M14 18h6" />
            </svg>
            Sistem Kayıtları
        </a>
    @else
        @if (auth()->user()->can('tools.authlogs.management') &&
                !request()->routeIs(['panel.tools.accounts.auth.logs', 'panel.tools.users.auth.logs']))
            <a class="dropdown-item {{ request()->routeIs('panel.tools.accounts.auth.logs') ? 'active' : '' }}"
                href="{{ route('panel.tools.accounts.auth.logs') }}" title="Oturum Kayıtları">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon dropdown-item-icon">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10 9a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                    <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                    <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                    <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                    <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                    <path d="M8 16a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2" />
                </svg>
                Oturum Kayıtları
            </a>
        @endif
        @if (auth()->user()->can('tools.activity.management'))
            <a class="dropdown-item" href="{{ route('panel.tools.accounts.activities') }}" title="Kullanıcı İşlemleri">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon dropdown-item-icon">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                    <path d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                    <path d="M14 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                    <path d="M14 7l6 0" />
                    <path d="M17 4l0 6" />
                </svg>
                Kullanıcı İşlemleri
            </a>
        @endif
        @if (auth()->user()->can('tools.cache.management'))
            <a class="dropdown-item {{ request()->routeIs('panel.tools.cache.cache') ? 'active' : '' }}"
                href="{{ route('panel.tools.cache.cache') }}" title="Önbellek Yönetimi">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon dropdown-item-icon">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 12.75m-4 0a4 1.75 0 1 0 8 0a4 1.75 0 1 0 -8 0" />
                    <path d="M8 12.5v3.75c0 .966 1.79 1.75 4 1.75s4 -.784 4 -1.75v-3.75" />
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                </svg>
                Önbellek Yönetimi
            </a>
        @endif
    @endif
</div>
