<div class="page-menu border-bottom mb-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav justify-content-start">
                    <li class="nav-item {{ request()->routeIs('panel.tools.config.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('panel.tools.config.countries') }}"
                            title="Yapılandırma Araçları">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-nut" viewBox="0 0 20 20">
                                <path
                                    d="m11.42 2 3.428 6-3.428 6H4.58L1.152 8 4.58 2zM4.58 1a1 1 0 0 0-.868.504l-3.428 6a1 1 0 0 0 0 .992l3.428 6A1 1 0 0 0 4.58 15h6.84a1 1 0 0 0 .868-.504l3.429-6a1 1 0 0 0 0-.992l-3.429-6A1 1 0 0 0 11.42 1z" />
                                <path
                                    d="M6.848 5.933a2.5 2.5 0 1 0 2.5 4.33 2.5 2.5 0 0 0-2.5-4.33m-1.78 3.915a3.5 3.5 0 1 1 6.061-3.5 3.5 3.5 0 0 1-6.062 3.5z" />
                            </svg>
                            Yapılandırma Araçları
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('panel.tools.cache') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('panel.tools.cache') }}" title="Önbellek Yönetimi">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-file-earmark-zip" viewBox="0 0 20 20">
                                <path
                                    d="M5 7.5a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v.938l.4 1.599a1 1 0 0 1-.416 1.074l-.93.62a1 1 0 0 1-1.11 0l-.929-.62a1 1 0 0 1-.415-1.074L5 8.438zm2 0H6v.938a1 1 0 0 1-.03.243l-.4 1.598.93.62.929-.62-.4-1.598A1 1 0 0 1 7 8.438z" />
                                <path
                                    d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1h-2v1h-1v1h1v1h-1v1h1v1H6V5H5V4h1V3H5V2h1V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z" />
                            </svg>
                            Önbellek Yönetimi
                        </a>
                    </li>
                    <li
                        class="nav-item {{ request()->routeIs(['panel.tools.logs', 'panel.tools.admins.*', 'panel.tools.users.*', 'panel.tools.passwords.*']) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('panel.tools.logs') }}" title="Sistem Kayıtları">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-record-circle" viewBox="0 0 20 20">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path d="M11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            </svg>
                            Sistem Kayıtları
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
