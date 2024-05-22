@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Profil Bilgileri',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-md-3 border-end">
                        <div class="card-body">
                            <h4 class="subheader">Profil Bilgileri</h4>
                            <div class="list-group list-group-transparent">
                                @include('admin.profile.partials.navigation')
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body">
                            <div class="mb-5">
                                <form action="" method="POST" class="card">
                                    @csrf
                                    <div class="card-header">
                                        <h2 class="card-title">Kişisel Bilgiler</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <label class="col-3 col-form-label required">Profil Resmi</label>
                                            <div class="col">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="avatar avatar-xl"
                                                            style="background-image: url(./static/avatars/000m.jpg)"></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="#" class="btn">
                                                            Resmi Değiştir
                                                        </a>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="#" class="btn btn-ghost-danger">
                                                            Kaldır
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-3 col-form-label required">Ad Soyad</label>
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <input type="text"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            name="name"
                                                            value="{{ $user->name ? $user->name : old('name') }}"
                                                            aria-describedby="ad" placeholder="Ad">
                                                        @error('name')
                                                            <span class="invalid-feedback"
                                                                role="alert">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="text"
                                                            class="form-control @error('surname') is-invalid @enderror"
                                                            name="surname"
                                                            value="{{ $user->surname ? $user->surname : old('surname') }}"
                                                            aria-describedby="soyad" placeholder="Soyad">
                                                        @error('surname')
                                                            <span class="invalid-feedback"
                                                                role="alert">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <small class="form-hint">Adınızı ve soyadınızı giriniz.</small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-3 col-form-label required">Görev</label>
                                            <div class="col">
                                                <input type="text"
                                                    class="form-control @error('title') is-invalid @enderror" name="title"
                                                    value="{{ $user->title ? $user->title : old('title') }}"
                                                    aria-describedby="title" placeholder="Görev">
                                                @error('title')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Lütfen görevinizi giriniz.</small>
                                            </div>
                                            @if (!$user->hasVerifiedEmail())
                                                <div class="alert alert-info shadow-none mb-5" role="alert">
                                                    <div class="d-flex">
                                                        <div>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon"
                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                </path>
                                                                <path d="M12 9v4"></path>
                                                                <path
                                                                    d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                                                </path>
                                                                <path d="M12 16h.01"></path>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h4 class="alert-title">Bilgilendirme</h4>
                                                            <div class="text-secondary">E-posta adresiniz
                                                                onaylı değil. E-posta onay linkini tekrar göndermek için <a
                                                                    href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-verifyEmail">tıklayınız.</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-3 col-form-label required">E-posta Adresi</label>
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-11">
                                                        <input type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            name="email"
                                                            value="{{ $user->email ? $user->email : old('email') }}"
                                                            aria-describedby="emailHelp" placeholder="E-posta Adresi"
                                                            readonly>
                                                        @error('email')
                                                            <span class="invalid-feedback"
                                                                role="alert">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-1">
                                                        <button type="button" class="btn px-2" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                                            data-bs-title="E-posta adresini değiştirmek için tıklayınız.">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-mail-cog m-0">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M12 19h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v5" />
                                                                <path d="M3 7l9 6l9 -6" />
                                                                <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                                <path d="M19.001 15.5v1.5" />
                                                                <path d="M19.001 21v1.5" />
                                                                <path d="M22.032 17.25l-1.299 .75" />
                                                                <path d="M17.27 20l-1.3 .75" />
                                                                <path d="M15.97 17.25l1.3 .75" />
                                                                <path d="M20.733 20l1.3 .75" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <small class="form-hint">E-posta Adresiniz. E-posta adresinizi değiştirmek
                                                    için yandaki butona tıklayınız.</small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-3 col-form-label">Hakkında</label>
                                            <div class="col">
                                                <textarea class="form-control" name="about" aria-describedby="about" placeholder="Hakkında">{{ $user->about ? $user->about : old('about') }}</textarea>
                                                <small class="form-hint">Kendiniz ile ilgili kısa bir açıklama
                                                    giriniz.</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button type="submit" class="btn btn-success">Güncelle</button>
                                    </div>
                                </form>
                            </div>
                            <div class="mb-3">
                                <form action="" method="POST" class="card">
                                    <div class="card-header">
                                        <h2 class="card-title">Şifre Değiştir</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <label class="col-3 col-form-label">Şifre Değiştir</label>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <label class="col-form-label required">Kullandığınız Şifre</label>
                                                    </div>
                                                    <div class="input-group input-group-flat">
                                                        <input type="password" id="oldpassword" name="old_password"
                                                            class="form-control @error('old_password') is-invalid @enderror"
                                                            placeholder="Kullandığınız Şifre" autocomplete="off">
                                                    </div>
                                                    <small class="form-hint">Kullandığınız şifrenizi giriniz</small>
                                                    @error('old_password')
                                                        <div class="invalid-feedback" role="alert">{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <label class="col-form-label required">Yeni Şifreniz</label>
                                                        <button type="button" onclick="generatePassword()"
                                                            class="btn btn-sm btn-link link-secondary randompassword rounded-none shadow-none">Şifre
                                                            Oluştur</button>
                                                    </div>
                                                    <div class="input-group input-group-flat">
                                                        <input type="text" id="password" name="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            placeholder="Şifreniz" autocomplete="off">
                                                    </div>
                                                    <small class="form-hint">Yeni şifrenizi giriniz</small>
                                                    @error('password')
                                                        <div class="invalid-feedback" role="alert">{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <label class="col-form-label required">Yeni Şifrenizi Tekrar
                                                            Giriniz</label>
                                                    </div>
                                                    <div class="input-group input-group-flat">
                                                        <input type="text" id="password_confirmation"
                                                            name="password_confirmation"
                                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                                            placeholder="Şifreniz" autocomplete="off">
                                                    </div>
                                                    <small class="form-hint">Yeni şifrenizi tekrar giriniz</small>
                                                    @error('password_confirmation')
                                                        <div class="invalid-feedback" role="alert">{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button type="submit" class="btn btn-success">Güncelle</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    </script>
@endsection
