<ul class="list-group list-group-flush mb-3">
    <li class="list-group-item {{ request()->routeIs('panel.tools.logs') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.tools.logs') }}" title="Sistem Ayarları">Sistem Kayıtları</a>
    </li>
    <li class="list-group-item {{ request()->routeIs('panel.tools.users.activities') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.tools.users.activities') }}" title="Kullanıcı İşlemleri">Kullanıcı İşlemleri</a>
    </li>
    <li class="list-group-item {{ request()->routeIs('panel.tools.admins.activities') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.tools.admins.activities') }}" title="Yönetici İşlemleri">Yönetici İşlemleri</a>
    </li>
</ul>
<ul class="list-group list-group-flush mb-3">
    <li class="list-group-item {{ request()->routeIs('panel.tools.users.authLogs') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.tools.users.authLogs') }}" title="Kullanıcı Oturumları">Kullanıcı Oturumları</a>
    </li>
    <li class="list-group-item {{ request()->routeIs('panel.tools.admins.authLogs') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.tools.admins.authLogs') }}" title="Yönetici Oturumları">Yönetici Oturumları</a>
    </li>
    <li class="list-group-item {{ request()->routeIs('panel.tools.passwords.activities') ? 'fw-medium' : '' }}">
        <a href="{{ route('panel.tools.passwords.activities') }}" title="Şifre Yenileme Talepleri">Şifre Yenileme
            Talepleri</a>
    </li>
</ul>
