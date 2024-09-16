@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Kullanıcılar',
    ])
    <div class="page-content flex-grow-1 d-flex flex-column shadow-sm">
        <div class="row flex-grow-1">
            <div class="col-20 col-lg-3 col-md-3">
                <div class="page-menu rounded-2 mb-3">
                    @include('admin.accounts.include.navigation')
                </div>
                <div class="account-menu">
                    @include('admin.accounts.include.account-navigation')
                </div>
            </div>
            <div class="col-80 col-lg-9 col-md-9">
                <div class="card h-100 border-0 mb-5">
                    <div class="card-header border-0 bg-white p-0 mb-3">
                        <div class="d-flex align-items-center justify-content-between w-100 border-bottom pb-2">
                            <h1 class="card-title">Kullanıcı Hesabı Ekle</h1>
                            <a href="{{ route('panel.accounts') }}" class="btn btn-primary btn-sm rounded-sm">Kullanıcı
                                Hesapları</a>
                        </div>
                    </div>
                    <form action="{{ route('panel.account.store') }}" method="post">
                        @csrf
                        <div class="card-body border-0 bg-white px-0">
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4"><span class="fw-bold">Kullanıcı Bilgileri</span></div>
                                <div class="col-lg-9 col-md-8">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="userName" class="form-label">Ad</label>
                                            <div class="input-group">
                                                <span class="input-group-text border-end-0 pe-0 bg-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                                    </svg>
                                                </span>
                                                <input type="text" id="userName" name="name"
                                                    class="form-control border-start-0 @error('name') is-invalid @enderror"
                                                    placeholder="Kullanıcı Adı" value="{{ old('name') }}" required>
                                            </div>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                            <small class="form-hint">Lütfen kullanıcının adını giriniz.</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="userSurname" class="form-label">Soyad</label>
                                            <div class="input-group">
                                                <span class="input-group-text border-end-0 pe-0 bg-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                                        <path d="M16 19h6"></path>
                                                        <path d="M19 16v6"></path>
                                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                                                    </svg>
                                                </span>
                                                <input type="text" name="surname" id="userSurname"
                                                    class="form-control border-start-0 @error('surname') is-invalid @enderror"
                                                    placeholder="Kullanıcı Soyadı" value="{{ old('surname') }}" required>
                                            </div>
                                            @error('surname')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                            <small class="form-hint">Lütfen kullanıcının soyadını giriniz.</small>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="userTitle" class="form-label">Görev</label>
                                        <div class="input-group">
                                            <span class="input-group-text border-end-0 pe-0 bg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-text-size">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M3 7v-2h13v2" />
                                                    <path d="M10 5v14" />
                                                    <path d="M12 19h-4" />
                                                    <path d="M15 13v-1h6v1" />
                                                    <path d="M18 12v7" />
                                                    <path d="M17 19h2" />
                                                </svg>
                                            </span>
                                            <input type="text" name="title" id="userTitle"
                                                class="form-control border-start-0 @error('title') is-invalid @enderror"
                                                placeholder="Kullanıcı Görevi" value="{{ old('title') }}">
                                        </div>
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">Kullanıcının görevini giriniz.</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="userEmail" class="form-label">E-posta Adresi</label>
                                        <div class="input-group">
                                            <span class="input-group-text border-end-0 pe-0 bg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                                    <path d="M3 7l9 6l9 -6" />
                                                </svg>
                                            </span>
                                            <input type="email" name="email" id="userEmail"
                                                class="form-control border-start-0 @error('email') is-invalid @enderror"
                                                placeholder="Kullanıcı E-posta Adresi" value="{{ old('email') }}">
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">Lütfen kullanıcının e-posta adresini giriniz.</small>
                                    </div>
                                    <div class="mb-5">
                                        <fieldset id="passwordArea" class="form-fieldset p-3 bg-info-subtle">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="col-form-label required">Kullanıcı Şifresi</label>
                                                <button type="button" onclick="generatePassword()"
                                                    class="btn btn-sm btn-link link-secondary randompassword rounded-none shadow-none">Şifre
                                                    Oluştur</button>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-text border-end-0 pe-0 bg-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-key">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" />
                                                        <path d="M15 9h.01" />
                                                    </svg>
                                                </span>
                                                <input type="password" id="password" name="password"
                                                    class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                                                    placeholder="Şifreniz" autocomplete="off">
                                                <span class="input-group-text border-start-0 ps-0 bg-white"
                                                    onclick="password_show_hide();" data-bs-toggle="tooltip"
                                                    aria-label="Şifreyi Göster" data-bs-original-title="Şifreyi Göster">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-eye showpassword pointer">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                        <path
                                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off hidepassword pointer d-none">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" />
                                                        <path
                                                            d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" />
                                                        <path d="M3 3l18 18" />
                                                    </svg>
                                                </span>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback" role="alert">{{ $message }}
                                                </div>
                                            @enderror
                                            <small class="form-hint">Kullanıcı şifresini giriniz</small>
                                        </fieldset>
                                    </div>
                                    <div class="col-12">
                                        <hr class="mt-0 mb-4">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4"><span class="fw-bold">Hesap İşlemleri</span></div>
                                <div class="col-lg-9 col-md-8">
                                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()))
                                        <div class="form-check form-switch border-bottom pb-2 mb-2">
                                            <label class="form-check-label" for="checkVerifyEmail">Onay E-postası
                                                Gönder</label>
                                            <input class="form-check-input" type="checkbox" name="verifyemail"
                                                role="switch" id="checkVerifyEmail">
                                        </div>
                                    @endif
                                    <div class="form-check form-switch border-bottom pb-2 mb-2">
                                        <label class="form-check-label" for="sendEmail">Bilgileri E-posta Adresine
                                            Gönder</label>
                                        <input class="form-check-input" type="checkbox" name="sendemail" role="switch"
                                            id="sendEmail">
                                    </div>
                                    <div class="form-check form-switch">
                                        <label class="form-check-label" for="status">Kullanıcı Durumunu Pasif
                                            Yap</label>
                                        <input class="form-check-input" type="checkbox" name="status" role="switch"
                                            id="status">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-9 offset-lg-3 col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                        </path>
                                        <path d="M16 5l3 3"></path>
                                    </svg>
                                    Kullanıcıyı Kaydet
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        window.onload = function() {
            generatePassword();
        };

        /* şifre Oluşturucu */
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
    </script>
@endsection
