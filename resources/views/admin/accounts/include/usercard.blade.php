<div class="card mb-3">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between w-100">
            <h2 class="m-0">{{ $user->name . ' ' . $user->surname }}</h2>
            <div class="user-meta">
                @if ($user->status->value == 1)
                    <span
                        class="badge bg-success small">{{ AccountStatus::fromValue($user->status->value)?->title() ?? 'Unknown Status' }}</span>
                @else
                    <span
                        class="badge bg-danger small">{{ AccountStatus::fromValue($user->status->value)?->title() ?? 'Unknown Status' }}</span>
                @endif
            </div>
        </div>
        <span>{{ $user->meta->title }}</span>
    </div>
    <div class="card-body">
        <div class="email-area mb-3">
            <div class="d-flex align-items-center justify-content-between w-100">
                <span class="fw-medium d-block">E-posta Adresi</span>
                <div>
                    <a href="#" title="E-posta Adresini Değiştir" class="text-primary text-decoration-none me-2"
                        data-bs-toggle="modal" data-bs-target="#changeEmail">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path
                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                            <path fill-rule="evenodd"
                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                        </svg>
                    </a>
                    <a href="#" title="E-posta Onay Linkini Gönder" class="text-primary text-decoration-none"
                        data-bs-toggle="modal" data-bs-target="#verifyEmail">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-envelope-check" viewBox="0 0 16 16">
                            <path
                                d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z" />
                            <path
                                d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686" />
                        </svg>
                    </a>
                </div>
            </div>
            <span>{{ $user->email }}</span>
        </div>
        <div class="account-area mb-3">
            <div class="fw-medium d-block">Hesap Açılış Tarihi</div>
            <span>{{ $user->created_at }}</span>
        </div>
        <div class="lastLogin mb-3">
            <div class="fw-medium d-block">Son Oturum Tarihi</div>
            <span>{{ $user->last_login_at }}</span>
        </div>
        <div class="loginIp mb-3">
            <div class="fw-medium d-block">Son Oturum IP Adresi</div>
            <span>{{ $user->last_login_ip }}</span>
        </div>
        <div class="createdBy mb-3">
            <div class="fw-medium d-block">Hesabı Açan</div>
            <span>{{ $user->created_by_name }}</span>
        </div>
    </div>
</div>
