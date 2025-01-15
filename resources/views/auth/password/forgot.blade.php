@extends('layouts.auth')
@section('content')
    <div class="auth-form">
        <div class="card shadow-sm">
            <div class="card-body p-3">
                <div class="mb-4">
                    <img src="{{ Setting::getFullPath('logo') }}" alt="{{ Setting::get('title') }}" class="img-fluid">
                </div>
                <h2 class="form-title position-relative pb-3">Şifremi Unuttum</h2>
                <p class="text-muted mb-3">Şifrenizi yenilemek için aşağıdaki forma e-posta adresinizi
                    giriniz ve <span class="fw-medium">"Şifremi Yenile"</span> butonuna basınız.</p>
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible mb-3" role="alert">
                        <div class="d-flex">
                            <div class="me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                    <path
                                        d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                </svg>
                            </div>
                            <div>
                                {{ session('status') }}
                            </div>
                        </div>
                        <a class="btn-close pointer" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif
                <form action="{{ route('password.email') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 rounded-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-envelope" viewBox="0 0 16 16">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                </svg>
                            </span>
                            <input id="email" type="email" name="email"
                                class="form-control border-start-0"
                                placeholder="E-posta Adresiniz" autocomplete="off" required>
                        </div>
                        <span class="form-hint small">Lütfen e-posta adresinizi giriniz</span>
                        @error('email')
                            <div class="invalid-feedback" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-check2-square" viewBox="0 0 16 16">
                                <path
                                    d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z" />
                                <path
                                    d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0" />
                            </svg>
                            Şifremi Yenile
                        </button>
                    </div>
                </form>
                <div class="text-center text-danger mt-3">
                    <a href="{{ route('login') }}" title="Üye Ol" class="link" tabindex="-1">Giriş Yap</a>
                </div>
            </div>
        </div>
    </div>
@endsection
