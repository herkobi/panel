@extends('layouts.auth-password')
@section('content')
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <img src="{{ asset('herkobi.png') }}" alt="Herkobi" height="56">
                            </div>
                            <h2 class="h2 mb-3">E-posta Adresinizi Onaylayın</h2>
                            <p class="text-muted mb-3">Şifrenizi yenilemek için aşağıdaki forma e-posta adresinizi giriniz.
                            </p>
                            @if (session('status') == 'verification-link-sent')
                                <div class="alert alert-success alert-dismissible mb-3" role="alert">
                                    <div class="d-flex">
                                        <div>
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
                            {{ __('Before proceeding, please check your email for a verification link.') }}
                            {{ __('If you did not receive the email') }},
                            <div class="d-flex align-items-center justify-content-between my-3 w-100">
                                <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Tekrar Onay Kodu
                                        Gönder</button>
                                </form>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger"
                                        onclick="event.preventDefault(); this.closest('form').submit();">Oturumu
                                        Kapat</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
