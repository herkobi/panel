@extends('layouts.auth')
@section('content')
    <div class="d-flex align-items-center vh-100 bg-image bg-confirm-password">
        <div class="page ms-lg-5">
            <div class="card rounded-4 border-0 shadow login-card">
                <div class="card-body">
                    <div class="mb-4">
                        <a href="{{ route('login') }}" title="{{ Setting::get('title') }}">
                            <img src="/{{ Setting::get('logo') }}" alt="{{ Setting::get('title') }}" class="auth-logo">
                        </a>
                    </div>
                    <h4 class="form-title position-relative pb-3">Hesabınızı Onaylayın</h4>
                    <p class="text-muted mb-3">İşlemi gerçekleştirmek için onayınız gereklidir. Lütfen aşağıdaki forma
                        şifrenizi girerek onaylayınız.</p>
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
                    <form action="{{ route('password.confirm') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
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
                                    class="form-control border-end-0 @error('password') is-invalid @enderror"
                                    placeholder="Şifreniz" autocomplete="off" required>
                                <span class="input-group-text bg-white" onclick="password_show_hide();"
                                    data-bs-toggle="tooltip" aria-label="Şifreyi Göster/Gizle"
                                    data-bs-original-title="Şifreyi Göster/Gizle">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-eye hidepassword pointer d-none">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off showpassword pointer">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" />
                                        <path
                                            d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" />
                                        <path d="M3 3l18 18" />
                                    </svg>
                                </span>
                                @error('password')
                                    <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                @enderror
                            </div>
                            <span class="form-hint">Lütfen şifrenizi giriniz</span>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-danger w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-login-2">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M9 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                                    <path d="M3 12h13l-3 -3" />
                                    <path d="M13 15l3 -3" />
                                </svg>
                                İşlemi Onayla
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
