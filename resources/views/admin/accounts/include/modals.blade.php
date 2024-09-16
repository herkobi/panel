<div class="modal modal-blur fade" id="modalStatus" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kullanıcı Durumunu Değiştir</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="{{ route('panel.settings.user.status.update', $user->id) }}" method="POST">
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
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                        İptal Et
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm ms-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                            <path d="M16 5l3 3" />
                        </svg>
                        Kullanıcı Durumunu Değiştir
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modalChangeEmail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kullanıcı E-posta Adresini Değiştir</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="{{ route('panel.settings.user.change.email', $user->id) }}" method="POST">
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
                            <span class="input-group-text bg-white border-right-0 pe-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                    <path d="M3 7l9 6l9 -6" />
                                </svg>
                            </span>
                            <input type="email" class="form-control border-left-0" name="email"
                                placeholder="Yeni E-posta Adresi" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Yeni E-posta Adresi Tekrar</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-right-0 pe-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="currentColor"
                                    class="icon icon-tabler icons-tabler-filled icon-tabler-mail">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M22 7.535v9.465a3 3 0 0 1 -2.824 2.995l-.176 .005h-14a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-9.465l9.445 6.297l.116 .066a1 1 0 0 0 .878 0l.116 -.066l9.445 -6.297z" />
                                    <path
                                        d="M19 4c1.08 0 2.027 .57 2.555 1.427l-9.555 6.37l-9.555 -6.37a2.999 2.999 0 0 1 2.354 -1.42l.201 -.007h14z" />
                                </svg>
                            </span>
                            <input type="email" class="form-control border-left-0" name="email_confirmation"
                                placeholder="Yeni E-posta Adresi Tekrar" value="{{ old('email_confirmation') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                        İptal Et
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm ms-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                            <path d="M16 5l3 3" />
                        </svg>
                        E-posta Adresini Değiştir
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modalVerifyEmail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">E-posta Onay Linki Gönder</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="{{ route('panel.settings.user.verify.email', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-secondary mb-3">Kullanıcı e-posta adresini onaylaması için onay
                        e-postası göndermek üzeresiniz.</div>
                    <label for="userVerifyEmail" class="form-label">Kayıtlı Kullanıcı E-posta Adresi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-right-0 pe-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                <path d="M3 7l9 6l9 -6" />
                            </svg>
                        </span>
                        <input type="email" id="userVerifyEmail" class="form-control border-left-0" name="email"
                            placeholder="Yeni E-posta Adresi" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items center justify-content between w-100">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                            Kapat
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto text-dark-50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
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
    <div class="modal modal-blur fade" id="modalCheckEmail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">E-posta Adresini Onayla</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('panel.settings.user.check.email', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="text-secondary mb-3">Kullanıcı e-posta adresini onaylayacaksınız.</div>
                        <label for="userUnverifedEmail" class="form-label">Kullanıcının Kayıtlı E-posta Adresi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-right-0 pe-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                    <path d="M3 7l9 6l9 -6" />
                                </svg>
                            </span>
                            <input type="email" id="userUnverifedEmail" class="form-control border-left-0"
                                name="email" placeholder="E-posta Adresi" value="{{ $user->email }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex align-items center justify-content between w-100">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                                Kapat
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm ms-auto text-dark-50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                                E-posta Onay Linki Gönder
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
<div class="modal modal-blur fade" id="modalChangePassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kullanıcı Şifresini Değiştir</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="{{ route('panel.settings.user.change.password', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-secondary mb-3">Kullanıcı şifresini değiştirmek üzeresiniz. Kullanıcıya yeni
                        şifre ile ilgili bilgilendirme e-postası gönderilecektir.
                    </div>
                    <fieldset id="passwordArea" class="form-fieldset">
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="col-form-label required">Şifre</label>
                                <button type="button" onclick="generatePassword()"
                                    class="btn btn-sm btn-link link-secondary randompassword rounded-none shadow-none">Şifre
                                    Oluştur</button>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 pe-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-key">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" />
                                        <path d="M15 9h.01" />
                                    </svg>
                                </span>
                                <input type="password" id="password" name="password"
                                    class="form-control border-start-0 @error('password') is-invalid @enderror"
                                    placeholder="Şifreniz" autocomplete="off" required>
                                <span class="input-group-text" onclick="password_show_hide();"
                                    data-bs-toggle="tooltip" aria-label="Şifreyi Göster"
                                    data-bs-original-title="Şifreyi Göster">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-eye showpassword pointer">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off hidepassword pointer d-none">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" />
                                        <path
                                            d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" />
                                        <path d="M3 3l18 18" />
                                    </svg>
                                </span>
                            </div>
                            <small class="form-hint">Kullanıcı şifresini giriniz</small>
                            @error('password')
                                <div class="invalid-feedback" role="alert">{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="col-form-label required">Şifre Onayı</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 pe-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="currentColor"
                                        class="icon icon-tabler icons-tabler-filled icon-tabler-key">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M14.52 2c1.029 0 2.015 .409 2.742 1.136l3.602 3.602a3.877 3.877 0 0 1 0 5.483l-2.643 2.643a3.88 3.88 0 0 1 -4.941 .452l-.105 -.078l-5.882 5.883a3 3 0 0 1 -1.68 .843l-.22 .027l-.221 .009h-1.172c-1.014 0 -1.867 -.759 -1.991 -1.823l-.009 -.177v-1.172c0 -.704 .248 -1.386 .73 -1.96l.149 -.161l.414 -.414a1 1 0 0 1 .707 -.293h1v-1a1 1 0 0 1 .883 -.993l.117 -.007h1v-1a1 1 0 0 1 .206 -.608l.087 -.1l1.468 -1.469l-.076 -.103a3.9 3.9 0 0 1 -.678 -1.963l-.007 -.236c0 -1.029 .409 -2.015 1.136 -2.742l2.643 -2.643a3.88 3.88 0 0 1 2.741 -1.136m.495 5h-.02a2 2 0 1 0 0 4h.02a2 2 0 1 0 0 -4" />
                                    </svg>
                                </span>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control border-start-0 @error('password_confirmation') is-invalid @enderror"
                                    placeholder="Şifreyi Tekrar Giriniz" autocomplete="off" required>
                                <span class="input-group-text" onclick="password_conf_show_hide();"
                                    data-bs-toggle="tooltip" aria-label="Şifreyi Göster"
                                    data-bs-original-title="Şifreyi Göster">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-eye showpassword_conf pointer">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off hidepassword_conf pointer d-none">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" />
                                        <path
                                            d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" />
                                        <path d="M3 3l18 18" />
                                    </svg>
                                </span>
                            </div>
                            <small class="form-hint">Kullanıcı şifresini tekrar giriniz</small>
                            @error('password_confirmation')
                                <div class="invalid-feedback" role="alert">{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                            Kapat
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>
                            Kullanıcı Şifresini Değiştir
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modalResetPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Şifre Yenileme Linki Gönder</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="{{ route('panel.settings.user.reset.password', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-secondary mb-3">Kullanıcı şifresini yenilemesi için e-posta
                        gönderiyorsunuz. Kullanıcı e-postadaki linke tıklayarak şifresini değiştirebilir.</div>
                    <label for="userVerifedEmail" class="form-label">Kullanıcı e-posta adresi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 pe-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-square-asterisk">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                <path d="M12 8.5v7" />
                                <path d="M9 10l6 4" />
                                <path d="M9 14l6 -4" />
                            </svg>
                        </span>
                        <input type="email" name="email" id="userVerifedEmail"
                            class="form-control border-start-0" value="{{ $user->email }}" readonly required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                            Kapat
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>
                            Şifre Yenileme Linki Gönder
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@section('js')
    <script>
        window.onload = function() {
            generatePassword();
        };

        /*
         * Şifre Oluşturucu
         * Şifre değiştirme alanında otomatik şifre oluşturur
         */
        function generatePassword() {
            var length = 16; // Şifre uzunluğu
            var charset =
                "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+?><:{}[]"; // Karakter dizisi
            var randPassword = "";

            // En az bir adet sembol, büyük harf, küçük harf ve rakam içermesi için flag'ler
            var hasSymbol = false;
            var hasUpperCase = false;
            var hasLowerCase = false;
            var hasDigit = false;

            // Şifre oluşturulması
            while (randPassword.length < length || !hasSymbol || !hasUpperCase || !hasLowerCase || !hasDigit) {
                // Karakter dizisinden rastgele bir karakter seç
                var randomChar = charset.charAt(Math.floor(Math.random() * charset.length));
                // Şifre karakterlerinin gereksinimlerini kontrol et
                if ("!@#$%^&*()_+?><:{}[]".includes(randomChar)) {
                    hasSymbol = true;
                } else if ("abcdefghijklmnopqrstuvwxyz".includes(randomChar)) {
                    hasLowerCase = true;
                } else if ("ABCDEFGHIJKLMNOPQRSTUVWXYZ".includes(randomChar)) {
                    hasUpperCase = true;
                } else if ("0123456789".includes(randomChar)) {
                    hasDigit = true;
                }
                // Şifreye karakteri ekle
                randPassword += randomChar;
            }

            // Oluşturulan şifreyi input alanına yerleştir
            document.getElementById("password").value = randPassword;
        }
        /*
         * Show/Hide Password
         */
        function password_show_hide() {
            const x = document.getElementById("password");
            const show_eye = document.querySelector(".showpassword");
            const hide_eye = document.querySelector(".hidepassword");
            hide_eye.classList.remove("d-none");
            if (x.type === "password") {
                x.type = "text";
                show_eye.style.display = "none";
                hide_eye.style.display = "block";
            } else {
                x.type = "password";
                show_eye.style.display = "block";
                hide_eye.style.display = "none";
            }
        }

        function password_conf_show_hide() {
            const y = document.getElementById("password_confirmation");
            const show_conf_eye = document.querySelector(".showpassword_conf");
            const hide_conf_eye = document.querySelector(".hidepassword_conf");
            hide_conf_eye.classList.remove("d-none");
            if (y.type === "password") {
                y.type = "text";
                show_conf_eye.style.display = "none";
                hide_conf_eye.style.display = "block";
            } else {
                y.type = "password";
                show_conf_eye.style.display = "block";
                hide_conf_eye.style.display = "none";
            }
        }
    </script>
@endsection
