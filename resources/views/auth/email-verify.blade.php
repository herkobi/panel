@extends('layouts.auth')
@section('content')
    <div class="d-flex align-items-center vh-100 bg-image bg-email-verify">
        <div class="page ms-lg-5">
            <div class="card rounded-4 border-0 shadow register-card">
                <div class="card-body">
                    <div class="mb-4">
                        <a href="{{ route('login') }}" title="{{ Setting::get('title') }}">
                            <img src="/{{ Setting::get('logo') }}" alt="{{ Setting::get('title') }}" class="auth-logo">
                        </a>
                    </div>
                    <h4 class="form-title position-relative pb-3">E-posta Adresinizi Onaylayın</h4>
                    <p class="text-muted mb-3">Hesabınıza giriş yapmak için e-posta adresinizin onaylı olması gerekir.
                        Lütfen size gönderilen e-postadaki onay linkine tıklayarak e-posta adresinizi onaylayın.</p>
                    @if (session('status') == 'verification-link-sent')
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
                                    <p class="text-muted mb-3">E-posta onayı başarılı bir şekilde gönderildi.
                                        Bir kaç dakika içerisinde e-posta gelmiş olur. Lütfen spam/istenmeyen posta
                                        klasörünüde kontrol edin.</p>
                                </div>
                            </div>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    @endif
                    <p class="text-muted mb-3">Eğer onay kodu gelmediyse aşağıdaki butona tıklayarak tekrar talep
                        edebilirsiniz. Talep etmeden önce e-postanızdaki "Spam" / "İstenmeyen Posta" klasörünü kontrol
                        etmeyi unutmayınız.</p>
                    <div class="d-flex align-items-center justify-content-between my-3 w-100">
                        <form class="d-inline me-1" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-mail-forward">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 18h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5" />
                                    <path d="M3 6l9 6l9 -6" />
                                    <path d="M15 18h6" />
                                    <path d="M18 15l3 3l-3 3" />
                                </svg>
                                Onay Kodunun Tekrar Gönder
                            </button>
                        </form>
                        <form class="ms-1" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-logout">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                    <path d="M9 12h12l-3 -3" />
                                    <path d="M18 15l3 -3" />
                                </svg>
                                Oturumu Kapat
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
