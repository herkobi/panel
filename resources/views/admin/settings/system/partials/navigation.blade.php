<div class="dropdown-menu panel-dropdown shadow-none">
    <span class="dropdown-header">Ayarlar</span>
    @if (auth()->user()->can('app.management'))
        <a class="dropdown-item" href="{{ route('panel.pages') }}" title="Uygulama Ayarları">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-notebook">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M6 4h11a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-11a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1m3 0v18" />
                <path d="M13 8l2 0" />
                <path d="M13 12l2 0" />
            </svg>
            Uygulama Ayarları
        </a>
    @endif
    <a class="dropdown-item" href="{{ route('panel.page.create') }}" title="Sistem Ayarları">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24"
            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
            stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
            <path d="M16 5l3 3"></path>
        </svg>
        Sistem Ayarları
    </a>
</div>
