<ul class="list-group list-group-flush">
    <li class="list-group-item {{ request()->routeIs('panel.settings.general') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.settings.general') }}" title="Genel Ayarlar">Genel Ayarlar</a>
    </li>
    <li class="list-group-item {{ request()->routeIs('panel.settings.system') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.settings.system') }}" title="Sistem Ayarları">Sistem Ayarları</a>
    </li>
</ul>
