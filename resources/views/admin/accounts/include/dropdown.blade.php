<div class="dropdown">
    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
            <path stroke="none" d="M0 0h24v24H0z" fill="none">
            </path>
            <path
                d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z">
            </path>
            <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
        </svg>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item small" href="#" data-bs-toggle="modal" data-bs-target="#modalStatus">Kullanıcı
                Durumunu Düzenle</a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li>
            <a class="dropdown-item small" href="#" data-bs-toggle="modal"
                data-bs-target="#modalChangeEmail">E-posta Adresini
                Değiştir</a>
        </li>
        <li>
            <a class="dropdown-item small" href="#" data-bs-toggle="modal"
                data-bs-target="#modalVerifyEmail">E-posta Onay
                Linki Gönder</a>
        </li>
        @if (!$user->hasVerifiedEmail())
            <li>
                <a class="dropdown-item small" href="#" data-bs-toggle="modal" data-bs-target="#modalCheckEmail">
                    E-posta Adresini Onayla
                </a>
            </li>
        @endif
        <li>
            <hr class="dropdown-divider">
        </li>
        <li>
            <a class="dropdown-item small" href="#" data-bs-toggle="modal"
                data-bs-target="#modalChangePassword">Kullanıcı Şifresini Değiştir</a>
        </li>
        @if ($user->status == AccountStatus::ACTIVE)
            <li>
                <a class="dropdown-item small" href="#" data-bs-toggle="modal"
                    data-bs-target="#modalResetPassword">
                    Şifre Yenileme Linki Gönder
                </a>
            </li>
        @endif
    </ul>
</div>
