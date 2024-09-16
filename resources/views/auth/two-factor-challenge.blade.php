@extends('layouts.auth')
@section('content')
    <div class="d-flex align-items-center vh-100 bg-image bg-2fa">
        <div class="page ms-lg-5">
            <div class="card rounded-4 border-0 shadow register-card">
                <div class="card-body">
                    <div class="mb-4">
                        <a href="{{ route('login') }}" title="{{ Setting::get('title') }}">
                            <img src="{{ Setting::get('logo') }}" alt="{{ Setting::get('title') }}" class="auth-logo">
                        </a>
                    </div>
                    <h4 class="form-title position-relative pb-3">İki Faktörlü Doğrulama</h4>
                    <p class="text-muted mb-3">Lütfen 2 faktörlü doğrulama kodunu ya da gizli anahtarlarınızdan birini
                        giriniz.</p>
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <div class="d-flex">
                                <div class="me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                        <path d="M12 8v4"></path>
                                        <path d="M12 16h.01"></path>
                                    </svg>
                                </div>
                                <div>
                                    {{ session('status') }}
                                </div>
                            </div>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    @endif
                    <form action="/two-factor-challenge" method="POST" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-auth-2fa">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 16h-4l3.47 -4.66a2 2 0 1 0 -3.47 -1.54" />
                                        <path d="M10 16v-8h4" />
                                        <path d="M10 12l3 0" />
                                        <path d="M17 16v-6a2 2 0 0 1 4 0v6" />
                                        <path d="M17 13l4 0" />
                                    </svg>
                                </span>
                                <input type="text" name="code"
                                    class="form-control @error('code') is-invalid @enderror" placeholder="Doğrulama Kodu"
                                    autocomplete="off">
                                @error('code')
                                    <div class="invalid-feedback" role="alert">{{ $code }}</div>
                                @enderror
                            </div>
                            <span class="form-hint">Lütfen güvenlik kodunu giriniz</span>
                        </div>
                        <div class="hr-text">YA DA</div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-file-barcode">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                        <path d="M8 13h1v3h-1z" />
                                        <path d="M12 13v3" />
                                        <path d="M15 13h1v3h-1z" />
                                    </svg>
                                </span>
                                <input type="text" name="recovery_code"
                                    class="form-control @error('recovery_code') is-invalid @enderror"
                                    placeholder="Gizli Anahtar" autocomplete="off">
                                @error('recovery_code')
                                    <div class="invalid-feedback" role="alert">{{ $recovery_code }}</div>
                                @enderror
                            </div>
                            <span class="form-hint">Eğer güvenlik anahtarınıza erişemiyorsanız Kurtarma Kodlarından birini
                                girerekte oturum açabilirsiniz.</span>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-danger w-100">İşlemi Onayla</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
