<div class="dropdown-menu panel-dropdown shadow-none">
    <span class="dropdown-header">Oturum Kayıtları</span>
    <a class="dropdown-item {{ request()->routeIs('panel.tools.accounts.auth.logs') ? 'active' : '' }}"
        href="{{ route('panel.tools.accounts.auth.logs') }}" title="Ödeme Yöntemleri">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon dropdown-item-icon">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" />
            <path d="M6.201 18.744a4 4 0 0 1 3.799 -2.744h4a4 4 0 0 1 3.798 2.741" />
            <path
                d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
        </svg>
        Hesap Oturumları
    </a>
    <a class="dropdown-item {{ request()->routeIs('panel.tools.users.auth.logs') ? 'active' : '' }}"
        href="{{ route('panel.tools.users.auth.logs') }}" title="Vergi Bilgileri">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon dropdown-item-icon">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path
                d="M13.163 2.168l8.021 5.828c.694 .504 .984 1.397 .719 2.212l-3.064 9.43a1.978 1.978 0 0 1 -1.881 1.367h-9.916a1.978 1.978 0 0 1 -1.881 -1.367l-3.064 -9.43a1.978 1.978 0 0 1 .719 -2.212l8.021 -5.828a1.978 1.978 0 0 1 2.326 0z" />
            <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" />
            <path d="M6 20.703v-.703a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.707" />
        </svg>
        Kullanıcı Oturumları
    </a>
</div>
