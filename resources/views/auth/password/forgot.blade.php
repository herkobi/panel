@extends('layouts.auth')
@section('content')
    <div class="d-flex align-items-center vh-100 bg-image bg-forgot-password">
        <div class="page ms-lg-5">
            <div class="card rounded-4 border-0 shadow login-card">
                <div class="card-body">
                    <div class="mb-4">
                        <a href="{{ route('login') }}" title="{{ Setting::get('title') }}">
                            <img src="{{ Setting::get('logo') }}" alt="{{ Setting::get('title') }}" class="auth-logo">
                        </a>
                    </div>
                    <h4 class="form-title position-relative pb-3">Şifremi Unuttum</h4>
                    <p class="text-muted mb-3">Şifrenizi yenilemek için aşağıdaki forma e-posta adresinizi
                        giriniz ve "Şifremi Yenile" butonuna basınız.</p>
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible mb-3" role="alert">
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
                            <a class="btn-close pointer" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    @endif
                    <form action="{{ route('password.email') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
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
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="E-posta Adresiniz" value="{{ old('email') }}" autocomplete="off" required>
                                @error('email')
                                    <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                @enderror
                            </div>
                            <span class="form-hint">Lütfen e-posta adresinizi giriniz</span>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-danger w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-lock-open">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M5 11m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                                    <path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                    <path d="M8 11v-5a4 4 0 0 1 8 0" />
                                </svg>
                                Şifremi Yenile
                            </button>
                        </div>
                    </form>
                    <div class="text-center text-danger mt-3">
                        <a href="{{ route('login') }}" title="Oturum Aç" class="link" tabindex="-1">Oturum
                            Aç</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
