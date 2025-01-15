@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Ayarlar',
    ])
    @include('admin.settings.include.navigation')
    <div class="page-content">
        <div class="container">
            <div class="page-form row">
                <div class="col-lg-10 offset-lg-1">
                    <h3 class="form-title border-bottom mb-3 pb-3">Yeni Yönetici</h3>
                    <form action="{{ route('panel.settings.user.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label for="title" class="col-form-label col-lg-2 col-md-3">Ad Soyad</label>
                            <div class="col-lg-10 col-md-9">
                                <div class="row">
                                    <div class="col-lg-6 mb-1">
                                        <div class="input-group">
                                            <div class="input-group-text rounded-0 border-end-0 bg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input type="text" name="name" id="name"
                                                class="form-control rounded-0 border-start-0"
                                                placeholder="Kullanıcı Adını Giriniz" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-1">
                                        <div class="input-group">
                                            <div class="input-group-text rounded-0 border-end-0 bg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
                                                    <path
                                                        d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4">
                                                    </path>
                                                    <path
                                                        d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input type="text" name="surname" id="surname"
                                                class="form-control rounded-0 border-start-0"
                                                placeholder="Kullanıcı Soyadını Giriniz" value="{{ old('surname') }}">
                                        </div>
                                    </div>
                                </div>
                                <span class="form-hint small">Kullanıcı ad soyadı giriniz</span>
                                @error(['name', 'surname'])
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="title" class="col-form-label col-lg-2 col-md-3">Görev</label>
                            <div class="col-lg-10 col-md-9">
                                <div class="input-group">
                                    <div class="input-group-text rounded-0 border-end-0 bg-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-blockquote-left" viewBox="0 0 16 16">
                                            <path
                                                d="M2.5 3a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1zm5 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm-5 3a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1zm.79-5.373q.168-.117.444-.275L3.524 6q-.183.111-.452.287-.27.176-.51.428a2.4 2.4 0 0 0-.398.562Q2 7.587 2 7.969q0 .54.217.873.217.328.72.328.322 0 .504-.211a.7.7 0 0 0 .188-.463q0-.345-.211-.521-.205-.182-.568-.182h-.282q.036-.305.123-.498a1.4 1.4 0 0 1 .252-.37 2 2 0 0 1 .346-.298zm2.167 0q.17-.117.445-.275L5.692 6q-.183.111-.452.287-.27.176-.51.428a2.4 2.4 0 0 0-.398.562q-.165.31-.164.692 0 .54.217.873.217.328.72.328.322 0 .504-.211a.7.7 0 0 0 .188-.463q0-.345-.211-.521-.205-.182-.568-.182h-.282a1.8 1.8 0 0 1 .118-.492q.087-.194.257-.375a2 2 0 0 1 .346-.3z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="text" name="title" id="title"
                                        class="form-control rounded-0 border-start-0" placeholder="Görev Giriniz"
                                        value="{{ old('title') }}">
                                </div>
                                <span class="form-hint small">Kullanıcı görevi giriniz</span>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-form-label col-lg-2 col-md-3">E-posta Adresi</label>
                            <div class="col-lg-10 col-md-9">
                                <div class="input-group">
                                    <div class="input-group-text rounded-0 border-end-0 bg-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                            <path
                                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="email" name="email" id="email"
                                        class="form-control rounded-0 border-start-0" placeholder="E-posta Adresi Giriniz"
                                        value="{{ old('email') }}">
                                </div>
                                <span class="form-hint small">E-posta adresini giriniz</span>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-10 col-mg-9 offset-lg-2 offset-md-3">
                                <div class="bg-light p-3">
                                    <div class="d-flex align-items-center justify-content-between w-100">
                                        <label for="password" class="col-form-label pt-0">Şifre</label>
                                        <button type="button" onclick="generatePassword()"
                                            class="btn btn-sm btn-link link-secondary randompassword text-decoration-none rounded-none shadow-none">Şifre
                                            Oluştur</button>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-text rounded-0 border-end-0 bg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-key-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2M2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2">
                                                </path>
                                            </svg>
                                        </div>
                                        <input type="password" name="password" id="password"
                                            class="form-control rounded-0 border-start-0 border-end-0"
                                            placeholder="Şifre Giriniz" autocomplete="off">
                                        <div class="input-group-text rounded-0 border-start-0 bg-white"
                                            onclick="password_show_hide();" data-bs-toggle="tooltip"
                                            aria-label="Şifreyi Göster" data-bs-original-title="Şifreyi Göster">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-eye-slash showpassword pointer"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z">
                                                </path>
                                                <path
                                                    d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829">
                                                </path>
                                                <path
                                                    d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z">
                                                </path>
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-eye hidepassword pointer d-none"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z">
                                                </path>
                                                <path
                                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <span class="form-hint small">Kullanıcı şifresi giriniz</span>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-10 col-mg-9 offset-lg-2 offset-md-3">
                                <h5 class="border-bottom mb-3 pb-2">Hesap İşlemleri</h5>
                                <div class="form-check form-switch border-bottom pb-2 mb-2">
                                    <label class="form-check-label" for="checkVerifyEmail">Onay E-postası
                                        Gönder</label>
                                    <input class="form-check-input" type="checkbox" name="verifyemail" role="switch"
                                        id="checkVerifyEmail">
                                </div>
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
                        <div class="row mb-5">
                            <div class="col-lg-10 col-mg-9 offset-lg-2 offset-md-3">
                                <button type="submit" class="btn rounded-1 px-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-floppy" viewBox="0 0 20 20">
                                        <path d="M11 2H9v3h2z"></path>
                                        <path
                                            d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z">
                                        </path>
                                    </svg>
                                    KAYDET
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
