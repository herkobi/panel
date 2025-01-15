<div class="modal modal-blur fade" id="changeStatus" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kullanıcı Durumunu Değiştir</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="{{ route('panel.account.status.update', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-secondary mb-3">Kullanıcı durumunu değiştirmek üzeresiniz. Bu durumda kullanıcının
                        panele erişimini kısıtlayabilir ya da yasaklayabilirsiniz.</div>
                    <div class="mb-3">
                        @foreach (AccountStatus::cases() as $status)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input rounded-0 shadow-none"
                                    id="user-status-{{ $status->value }}" type="radio" name="status"
                                    value="{{ $status->value }}" id="user-status-{{ $status->value }}"
                                    {{ $user->status === $status ? 'checked' : '' }}>
                                <label class="form-check-label" for="user-status-{{ $status->value }}">
                                    {{ $status->title() }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items center justify-content-between w-100">
                        <button type="button" class="btn bg-white border-0 text-dark" data-bs-dismiss="modal">
                            Kapat
                        </button>
                        <button type="submit" class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path
                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z">
                                </path>
                                <path fill-rule="evenodd"
                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z">
                                </path>
                            </svg>
                            Kullanıcı Durumunu Değiştir
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="changeEmail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kullanıcı E-posta Adresini Değiştir</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="{{ route('panel.account.change.email', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()))
                        <div class="text-secondary mb-4">Sisteminizde e-posta adreslerinin onay işlemi açıktır.
                            Yeni girdiğiniz e-posta adresine onaylaması için onay e-postası gönderilecektir.
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Yeni E-posta Adresi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white rounded-0 border-end-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                </svg>
                            </span>
                            <input type="email" class="form-control border-start-0" name="email"
                                placeholder="Yeni E-posta Adresi" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Yeni E-posta Adresi Tekrar</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white rounded-0 border-end-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z" />
                                </svg>
                            </span>
                            <input type="email" class="form-control border-start-0" name="email_confirmation"
                                placeholder="Yeni E-posta Adresi Tekrar" value="{{ old('email_confirmation') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items center justify-content-between w-100">
                        <button type="button" class="btn bg-white border-0 text-dark" data-bs-dismiss="modal">
                            Kapat
                        </button>
                        <button type="submit" class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path
                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z">
                                </path>
                                <path fill-rule="evenodd"
                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z">
                                </path>
                            </svg>
                            E-posta Adresini Değiştir
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="verifyEmail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">E-posta Onay Linki Gönder</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="{{ route('panel.account.verify.email', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-secondary mb-3">Kullanıcı e-posta adresini onaylaması için onay
                        e-postası göndermek üzeresiniz.</div>
                    <label for="userVerifyEmail" class="form-label">Kayıtlı Kullanıcı E-posta Adresi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white rounded-0 border-end-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                            </svg>
                        </span>
                        <input type="email" id="userVerifyEmail" class="form-control border-start-0"
                            name="email" placeholder="Yeni E-posta Adresi"
                            value="{{ old('email', $user->email) }}" required readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items center justify-content-between w-100">
                        <button type="button" class="btn bg-white border-0 text-dark" data-bs-dismiss="modal">
                            Kapat
                        </button>
                        <button type="submit" class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path
                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z">
                                </path>
                                <path fill-rule="evenodd"
                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z">
                                </path>
                            </svg>
                            E-posta Onay Linki Gönder
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@if (!$user->hasVerifiedEmail())
    <div class="modal modal-blur fade" id="checkEmail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">E-posta Adresini Onayla</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('panel.account.check.email', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="text-secondary mb-3">Kullanıcı e-posta adresini onaylayacaksınız.</div>
                        <label for="userUnverifedEmail" class="form-label">Kullanıcının Kayıtlı E-posta Adresi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white rounded-0 border-end-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                </svg>
                            </span>
                            <input type="email" id="userUnverifedEmail" class="form-control border-start-0"
                                name="email" placeholder="E-posta Adresi" value="{{ $user->email }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex align-items center justify-content-between w-100">
                            <button type="button" class="btn bg-white border-0 text-dark" data-bs-dismiss="modal">
                                Kapat
                            </button>
                            <button type="submit" class="btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path
                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z">
                                    </path>
                                    <path fill-rule="evenodd"
                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z">
                                    </path>
                                </svg>
                                E-posta Adresini Onayla
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
<div class="modal modal-blur fade" id="resetPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Şifre Yenileme Linki Gönder</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="{{ route('panel.account.reset.password', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-secondary mb-3">Kullanıcı şifresini yenilemesi için e-posta
                        gönderiyorsunuz. Kullanıcı e-postadaki linke tıklayarak şifresini değiştirebilir.</div>
                    <label for="userVerifedEmail" class="form-label">Kullanıcı e-posta adresi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white rounded-0 border-end-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                            </svg>
                        </span>
                        <input type="email" name="email" id="userVerifedEmail"
                            class="form-control border-start-0" value="{{ $user->email }}" readonly required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <button type="button" class="btn bg-white border-0 text-dark" data-bs-dismiss="modal">
                            Kapat
                        </button>
                        <button type="submit" class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path
                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z">
                                </path>
                                <path fill-rule="evenodd"
                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z">
                                </path>
                            </svg>
                            Şifre Yenileme Linki Gönder
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
