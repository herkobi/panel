@extends('layouts.app')
@section('content')
    <div class="container h-100">
        @include('user.include.header', [
            'title' => 'Profil Bilgileri',
        ])
        <div class="page-content flex-grow-1 d-flex flex-column shadow-sm">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="page-menu rounded-2">
                                @include('user.profile.include.navigation')
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h2 class="border-bottom mb-4 pb-3">Kullanıcı Bilgileri</h2>
                            <div class="profile-data">
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4">
                                        <span class="fw-bold">Kişisel Bilgiler</span>
                                    </div>
                                    <div class="col-lg-9 col-md-8">
                                        <form action="{{ route('panel.profile.update', $user->id) }}" method="POST"
                                            class="form mb-5">
                                            @csrf
                                            <div class="position-relative border-bottom mb-3 pb-3">
                                                <div class="row mb-2">
                                                    <div class="col-lg-6 mb-1">
                                                        <label class="col-form-label pt-0 required">Ad</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-white border-end-0 pe-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                                </svg>
                                                            </span>
                                                            <input type="text"
                                                                class="form-control border-start-0 @error('name') is-invalid @enderror"
                                                                name="name" value="{{ old('name', $user->name) }}"
                                                                aria-describedby="ad" placeholder="Ad" required>
                                                        </div>
                                                        <span class="form-hint small">Adınızı giriniz</span>
                                                        @error('name')
                                                            <span class="invalid-feedback"
                                                                role="alert">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6 mb-1">
                                                        <label class="col-form-label pt-0 required">Soyad</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-white border-end-0 pe-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                                    <path d="M16 19h6" />
                                                                    <path d="M19 16v6" />
                                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                                                </svg>
                                                            </span>
                                                            <input type="text"
                                                                class="form-control border-start-0 @error('surname') is-invalid @enderror"
                                                                name="surname" value="{{ old('surname', $user->surname) }}"
                                                                aria-describedby="soyad" placeholder="Soyad" required>
                                                        </div>
                                                        <span class="form-hint small">Soyadınızı giriniz.</span>
                                                        @error('surname')
                                                            <span class="invalid-feedback"
                                                                role="alert">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Görev</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white border-end-0 pe-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
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
                                                        <input type="text"
                                                            class="form-control border-start-0 @error('title') is-invalid @enderror"
                                                            name="title" value="{{ old('title', $user->meta->title) }}"
                                                            aria-describedby="title" placeholder="Görev">
                                                    </div>
                                                    <span class="form-hint small">Lütfen görevinizi giriniz.</span>
                                                    @error('title')
                                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path
                                                                d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                                                            </path>
                                                            <path
                                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                            </path>
                                                            <path d="M16 5l3 3"></path>
                                                        </svg>
                                                        Bilgilerimi Güncelle
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="mail-data">
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4">
                                        <span class="fw-bold">E-posta İşlemleri</span>
                                    </div>
                                    <div class="col-lg-9 col-md-8">
                                        <div class="position-relative border-bottom mb-3 pb-3">
                                            @if (!$user->hasVerifiedEmail())
                                                <div class="alert alert-info shadow-none mb-5" role="alert">
                                                    <div class="d-flex">
                                                        <div class="me-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon alert-icon" width="24" height="24"
                                                                viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none"
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
                                            <div class="row mb-2">
                                                <div class="col-9 mb-1">
                                                    <div class="input-group">
                                                        <span class="input-group-text border-end-0 pe-0 disabled">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
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
                                                        <input type="email" class="form-control border-start-0"
                                                            value="{{ $user->email }}" aria-describedby="emailHelp"
                                                            placeholder="E-posta Adresi" disabled>
                                                    </div>
                                                    <span class="form-hint small">E-posta Adresiniz. E-posta adresinizi
                                                        değiştirmek için yandaki butona tıklayınız.</span>
                                                </div>
                                                <div class="col-3 mb-1">
                                                    <a href="#" id="changeEmail"
                                                        class="btn btn-outline-dark float-end w-100 px-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="password-data">
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4">
                                        <span class="fw-bold">Şifre İşlemleri</span>
                                    </div>
                                    <div class="col-lg-9 col-md-8">
                                        <form action="{{ route('panel.profile.password.update', $user->id) }}"
                                            method="post">
                                            @csrf
                                            <div class="position-relative">
                                                <div class="alert alert-light shadow-none mb-3" role="alert">
                                                    <div class="d-flex">
                                                        <div class="me-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon alert-icon" width="24" height="24"
                                                                viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none"
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
                                                            <h4 class="alert-title">Şifre Yenileme</h4>
                                                            <p class="text-secondary">Şifrenizi yenilemek isterseniz
                                                                aşağıdaki alandan yeni şifre oluşturunuz. Eğer
                                                                değiştirmeyeceksiniz boş bırakınız.
                                                            </p>
                                                            <p class="text-secondary">Şifrenizi değiştirmek için
                                                                öncelikle kullandığınız şifreyi girmeniz gerekir.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label required">Kullandığınız Şifre</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white border-end-0 pe-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
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
                                                        <input type="password" id="oldpassword" name="old_password"
                                                            class="form-control border-start-0 @error('old_password') is-invalid @enderror"
                                                            placeholder="Kullandığınız Şifre" autocomplete="off" required>
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
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white border-end-0 pe-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-key">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" />
                                                                <path d="M15 9h.01" />
                                                            </svg>
                                                        </span>
                                                        <input type="text" id="password" name="password"
                                                            class="form-control border-start-0 @error('password') is-invalid @enderror"
                                                            placeholder="Şifreniz" autocomplete="off" required>
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
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white border-end-0 pe-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 24 24" fill="currentColor"
                                                                class="icon icon-tabler icons-tabler-filled icon-tabler-key">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M14.52 2c1.029 0 2.015 .409 2.742 1.136l3.602 3.602a3.877 3.877 0 0 1 0 5.483l-2.643 2.643a3.88 3.88 0 0 1 -4.941 .452l-.105 -.078l-5.882 5.883a3 3 0 0 1 -1.68 .843l-.22 .027l-.221 .009h-1.172c-1.014 0 -1.867 -.759 -1.991 -1.823l-.009 -.177v-1.172c0 -.704 .248 -1.386 .73 -1.96l.149 -.161l.414 -.414a1 1 0 0 1 .707 -.293h1v-1a1 1 0 0 1 .883 -.993l.117 -.007h1v-1a1 1 0 0 1 .206 -.608l.087 -.1l1.468 -1.469l-.076 -.103a3.9 3.9 0 0 1 -.678 -1.963l-.007 -.236c0 -1.029 .409 -2.015 1.136 -2.742l2.643 -2.643a3.88 3.88 0 0 1 2.741 -1.136m.495 5h-.02a2 2 0 1 0 0 4h.02a2 2 0 1 0 0 -4" />
                                                            </svg>
                                                        </span>
                                                        <input type="text" id="password_confirmation"
                                                            name="password_confirmation"
                                                            class="form-control border-start-0 @error('password_confirmation') is-invalid @enderror"
                                                            placeholder="Şifreniz" autocomplete="off" required>
                                                    </div>
                                                    <small class="form-hint">Yeni şifrenizi tekrar giriniz</small>
                                                    @error('password_confirmation')
                                                        <div class="invalid-feedback" role="alert">{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path
                                                                d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                                                            </path>
                                                            <path
                                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                            </path>
                                                            <path d="M16 5l3 3"></path>
                                                        </svg>
                                                        Şifremi Değiştir
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
                    <h5 class="modal-title">E-posta Adresini Değiştir</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('app.profile.email.update', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()))
                            <div class="alert alert-info shadow-none mb-5" role="alert">
                                <div class="d-flex">
                                    <div class="me-2">
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
                                        placeholder="Yeni E-posta Adresiniz" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Yeni E-posta Adresi Tekrar</label>
                                    <input type="email" class="form-control" name="email_confirmation"
                                        placeholder="Yeni E-posta Adresi Tekrar" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm" data-bs-dismiss="modal">
                            İptal Et
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto">
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
