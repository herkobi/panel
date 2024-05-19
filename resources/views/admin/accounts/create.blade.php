@extends('layouts.panel')
@section('css')
    <style>
        /* Geçiş efekti için CSS */
        #passwordArea {
            transition: opacity 0.5s ease-in-out;
            /* Opaklık geçişi, 0.5 saniye süre, yumuşak giriş-çıkış */
            opacity: 1;
            /* Başlangıçta görünür */
        }

        /* Gizleme sınıfı için CSS */
        .d-hide {
            display: none;
            opacity: 0;
            /* Opaklık 0 yaparak gizli hale getir */
            pointer-events: none;
            /* Tıklama ve etkileşimi engelle */
        }
    </style>
@endsection
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Hesaplar',
                ])
                @include('admin.accounts.partials.page-buttons', [
                    'first_button' => 'Hesaplar',
                    'first_link' => 'panel.accounts',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">Yeni Hesap Ekle</h1>
                        </div>
                        <form action="{{ route('panel.account.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <label class="col-3 col-form-label">Hesap Bilgileri</label>
                                    <div class="col">
                                        <div class="mb-2">
                                            <label class="col-form-label required">Hesap Yetkisi</label>
                                            <div class="row">
                                                @foreach ($roles as $role)
                                                    <div class="col-md-4">
                                                        <div class="mb-1">
                                                            <label class="form-check">
                                                                <input class="form-check-input" name="role[]"
                                                                    type="checkbox" value="{{ $role->name }}"
                                                                    {{ config('panel.userrole') == $role->id ? 'checked' : '' }}>
                                                                <span class="form-check-label">
                                                                    {{ $role->name }}
                                                                </span>
                                                                <span class="form-check-description">
                                                                    {{ $role->desc }}
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="col-form-label required">Ad</label>
                                                    <input type="text" name="name"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        value="{{ old('name') }}" placeholder="Ad">
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                    @enderror
                                                    <small class="form-hint">Kullanıcının adını giriniz</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label class="col-form-label required">Soyad</label>
                                                    <input type="text" name="surname"
                                                        class="form-control @error('surname') is-invalid @enderror"
                                                        value="{{ old('surname') }}" placeholder="Soyad">
                                                    @error('surname')
                                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                    @enderror
                                                    <small class="form-hint">Kullanıcının soyadını giriniz</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="col-form-label required">E-posta Adresi</label>
                                            <input type="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" placeholder="E-posta Adresi">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                            <small class="form-hint">Kullanıcının e-posta adresini giriniz</small>
                                        </div>
                                        <fieldset id="passwordArea" class="form-fieldset">
                                            <div class="mb-3">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <label class="col-form-label required">Şifre</label>
                                                    <button type="button" onclick="generatePassword()"
                                                        class="btn btn-sm btn-link link-secondary randompassword rounded-none shadow-none">Şifre
                                                        Oluştur</button>
                                                </div>
                                                <div class="input-group input-group-flat">
                                                    <input type="password" id="password" name="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        placeholder="Şifreniz" autocomplete="off">
                                                    <span class="input-group-text" onclick="password_show_hide();"
                                                        data-bs-toggle="tooltip" aria-label="Şifreyi Göster"
                                                        data-bs-original-title="Şifreyi Göster">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-eye showpassword pointer">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                            <path
                                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
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
                                        </fieldset>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <label class="col-3 col-form-label">Hesap İşlemleri</label>
                                    <div class="col col-form-label">
                                        <div class="mb-3 divide-y">
                                            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()))
                                                <div>
                                                    <label class="row">
                                                        <span class="col">Onay E-postası İste</span>
                                                        <span class="col-auto">
                                                            <label class="form-check form-check-single form-switch">
                                                                <input class="form-check-input" name="verifyemail"
                                                                    type="checkbox">
                                                            </label>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            <div>
                                                <label class="row">
                                                    <span class="col">Bilgileri E-posta İle Gönder</span>
                                                    <span class="col-auto">
                                                        <label class="form-check form-check-single form-switch">
                                                            <input class="form-check-input" name="sendemail"
                                                                type="checkbox">
                                                        </label>
                                                    </span>
                                                </label>
                                            </div>
                                            <div>
                                                <label class="row">
                                                    <span class="col">Kullanıcı Durumunu Pasif Yap</span>
                                                    <span class="col-auto">
                                                        <label class="form-check form-check-single form-switch">
                                                            <input class="form-check-input" name="status"
                                                                type="checkbox">
                                                        </label>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3">
                    @include('admin.accounts.partials.navigation')
                </div>
            </div>
        </div>
    </div>
    @if (Session::has('error') || $errors->any())
        <div class="modal modal-blur fade" id="modal-danger" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-body text-center py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 9v4" />
                            <path
                                d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" />
                            <path d="M12 16h.01" />
                        </svg>
                        <h3>Hata</h3>
                        @if ($errors->any())
                            <div class="text-secondary">
                                <ul class="list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="text-secondary">İşleminizi gerçekleştirirken bir sorun oluştu, lütfen tekrar
                                deneyiniz.
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <div class="w-100 text-center">
                            <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                Kapat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="module">
            var errorModal = new bootstrap.Modal(document.getElementById('modal-danger'), {})
            errorModal.toggle()
        </script>
    @endif
@endsection

@section('js')
    <script>
        window.onload(generatePassword());

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
