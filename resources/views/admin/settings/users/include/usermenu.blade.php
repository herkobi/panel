<ul class="list-group list-group-flush mb-3">
    <li class="list-group-item">
        <a href="#" data-bs-toggle="modal" data-bs-target="#changeStatus">Kullanıcı
            Durumunu Düzenle</a>
    </li>
    @if (!$user->hasVerifiedEmail())
        <li class="list-group-item">
            <a href="#" data-bs-toggle="modal" data-bs-target="#checkEmail">
                E-posta Adresini Onayla
            </a>
        </li>
    @endif
    @if ($user->status == AccountStatus::ACTIVE)
        <li class="list-group-item">
            <a href="#" data-bs-toggle="modal" data-bs-target="#resetPassword">
                Şifre Yenileme Linki Gönder
            </a>
        </li>
    @endif
</ul>
