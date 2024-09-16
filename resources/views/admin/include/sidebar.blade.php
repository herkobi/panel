<div class="sidebar">
    <div class="logo">
        <img src="/{{ Setting::get('logo') }}" alt="{{ Setting::get('title') }}" class="img-fluid">
    </div>
    <div class="menu">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('panel.home') ? 'active' : '' }}"
                    href="{{ route('panel.home') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-title="Başlangıç">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-home">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                    </svg>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs(['panel.accounts', 'panel.accounts.*', 'panel.account.*']) ? 'active' : '' }}"
                    href="{{ route('panel.accounts') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-title="Hesaplar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                    </svg>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('panel.tools.*') ? 'active' : '' }}"
                    href="{{ route('panel.tools.cache') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-title="Araçlar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-tools">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 21h4l13 -13a1.5 1.5 0 0 0 -4 -4l-13 13v4"></path>
                        <path d="M14.5 5.5l4 4"></path>
                        <path d="M12 8l-5 -5l-4 4l5 5"></path>
                        <path d="M7 8l-1.5 1.5"></path>
                        <path d="M16 12l5 5l-4 4l-5 -5"></path>
                        <path d="M16 17l-1.5 1.5"></path>
                    </svg>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('panel.settings.*') ? 'active' : '' }}"
                    href="{{ route('panel.settings.general') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-title="Ayarlar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-settings-2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M19.875 6.27a2.225 2.225 0 0 1 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
                        <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                    </svg>
                </a>
            </li>
        </ul>
    </div>
</div>
