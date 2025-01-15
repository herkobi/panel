<ul class="list-group list-group-flush mb-3">
    <li class="list-group-item {{ request()->routeIs('panel.tools.config.countries') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.tools.config.countries') }}" title="Ülke Bilgileri">Ülke Bilgileri</a>
    </li>
    <li class="list-group-item {{ request()->routeIs('panel.tools.config.languages') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.tools.config.languages') }}" title="Sistem Dilleri">Sistem Dilleri</a>
    </li>
</ul>
