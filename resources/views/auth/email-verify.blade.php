@extends('layouts.auth')
@section('content')
    <div class="auth-form big-form">
        <div class="card shadow-sm">
            <div class="card-body p-3">
                <div class="mb-4">
                    <img src="{{ Setting::getFullPath('logo') }}" alt="{{ Setting::get('title') }}" class="img-fluid">
                </div>
                <h2 class="form-title position-relative pb-3">E-posta Adresinizi Onaylayın</h2>
                <p class="text-muted mb-3">Hesabınıza giriş yapmak için e-posta adresinizin onaylı olması gerekir.
                    Lütfen size gönderilen e-postadaki onay linkine tıklayarak e-posta adresinizi onaylayın.</p>
                @if (session('status') == 'verification-link-sent')
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
                                <p class="text-muted mb-3">E-posta onayı başarılı bir şekilde gönderildi. Bir kaç dakika
                                    içerisinde e-posta gelmiş olur. Lütfen spam/istenmeyen posta klasörünüde kontrol edin.
                                </p>
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
                        <button type="submit" class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-envelope-check" viewBox="0 0 16 16">
                                <path
                                    d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z" />
                                <path
                                    d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686" />
                            </svg>
                            Onay Kodunu Tekrar Gönder
                        </button>
                    </form>
                    <form class="ms-1" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                <path fill-rule="evenodd"
                                    d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                            </svg>
                            Oturumu Kapat
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
