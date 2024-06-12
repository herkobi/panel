@extends('layouts.app')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                @include('user.layout.page-header', [
                    'subtitle' => config('panel.title'),
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
                            <h4 class="subheader">Kişisel Bilgiler</h4>
                            <div class="list-group list-group-transparent">
                                @include('user.profile.partials.navigation')
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body px-5">
                            <h2 class="profile-section-title border-bottom fw-normal pb-3 mb-5">Kişisel Bilgiler</h2>
                            <form action="{{ route('panel.profile.update') }}" method="POST" class="form mb-5">
                                @csrf
                                <div class="row mb-3">
                                    <label class="col-3 col-form-label required">Ad Soyad</label>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ $user->name ? $user->name : old('name') }}"
                                                    aria-describedby="ad" placeholder="Ad">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <input type="text"
                                                    class="form-control @error('surname') is-invalid @enderror"
                                                    name="surname"
                                                    value="{{ $user->surname ? $user->surname : old('surname') }}"
                                                    aria-describedby="soyad" placeholder="Soyad">
                                                @error('surname')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <small class="form-hint">Adınızı ve soyadınızı giriniz.</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-3 col-form-label required">Görev</label>
                                    <div class="col">
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            name="title" value="{{ $user->title ? $user->title : old('title') }}"
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
                                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
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
                                            <div class="col-10">
                                                <input type="email" class="form-control" value="{{ $user->email }}"
                                                    aria-describedby="emailHelp" placeholder="E-posta Adresi" disabled>
                                            </div>
                                            <div class="col-2">
                                                <a href="#" id="changeEmail" class="btn px-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-mail-cog me-2">
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
                                                    Değiştir
                                                </a>
                                            </div>
                                        </div>
                                        <small class="form-hint">E-posta Adresiniz. E-posta adresinizi değiştirmek
                                            için yandaki butona tıklayınız.</small>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <label class="col-3 col-form-label">Hakkında</label>
                                    <div class="col">
                                        <textarea class="form-control" name="about" aria-describedby="about" placeholder="Hakkında">{{ $user->about ? $user->about : old('about') }}</textarea>
                                        <small class="form-hint">Kendiniz ile ilgili kısa bir açıklama
                                            giriniz.</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="border-top p-3 bg-gray-300 text-end">
                                            <button type="submit" class="btn btn-success">Güncelle</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form action="{{ route('panel.profile.password.update') }}" method="post">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col">
                                        <h3 class="profile-section-title border-bottom fw-normal pb-2 mb-2">Şifre Yenileme
                                        </h3>
                                        <small>Şifrenizi yenilemek isterseniz aşağıdaki alandan yeni şifre
                                            oluşturunuz. Eğer değiştirmeyeceksiniz boş bırakınız. Şifrenizi değiştirmek için
                                            öncelikle kullanmış olduğunuz şifreyi girmeniz gereklidir.</small>
                                        <div class="my-3">
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
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="border-top p-3 bg-gray-300 text-end">
                                            <button type="submit" class="btn btn-success">Güncelle</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-changeEmail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kullanıcı Bilgileri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('panel.profile.email.update', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()))
                            <div class="alert alert-info shadow-none mb-5" role="alert">
                                <div class="d-flex">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 9v4"></path>
                                            <path
                                                d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                            </path>
                                            <path d="M12 16h.01"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="alert-title">Bilgilendirme</h4>
                                        <div class="text-secondary">Sisteminizde e-posta adreslerinin onay işlemi açıktır.
                                            Yeni girdiğiniz e-posta adresine onaylaması için onay e-postası gönderilecektir.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Yeni E-posta Adresi</label>
                                    <input type="email" class="form-control" name="email"
                                        placeholder="Yeni E-posta Adresiniz">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Yeni E-posta Adresi Tekrar</label>
                                    <input type="email" class="form-control" name="email_confirmation"
                                        placeholder="Yeni E-posta Adresi Tekrar">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">
                            İptal Et
                        </button>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
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
@endsection
@section('js')
    <script>
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

        document.querySelector('#changeEmail').addEventListener('click', function() {
            new bootstrap.Modal(document.getElementById('modal-changeEmail')).show();
        });
    </script>
@endsection
