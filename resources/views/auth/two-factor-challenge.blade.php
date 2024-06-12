@extends('layouts.auth-password')
@section('content')
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="card-body">
                <div class="text-center mb-4">
                    <a href="{{ route('login') }}" class="navbar-brand navbar-brand-autodark">
                        <img src="{{ asset('herkobi.png') }}" height="56" alt="Herkobi Panel">
                    </a>
                </div>
                <h2 class="h3 mb-3">İki Faktörlü Doğrulama</h2>
                <p class="text-muted mb-3">Lütfen 2 faktörlü doğrulama kodunu ya da gizli anahtarlarınızdan birini giriniz.
                </p>
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <div class="d-flex">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
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
                        <label class="form-label">Doğrulama Kodu</label>
                        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                            placeholder="Doğrulama Kodu" autocomplete="off">
                        @error('code')
                            <div class="invalid-feedback" role="alert">{{ $code }}</div>
                        @enderror
                    </div>
                    <div class="hr-text">YA DA</div>
                    <div class="mb-3">
                        <label class="form-label">Gizli Anahtar</label>
                        <input type="text" name="recovery_code"
                            class="form-control @error('recovery_code') is-invalid @enderror" placeholder="Gizli Anahtar"
                            autocomplete="off">
                        @error('recovery_code')
                            <div class="invalid-feedback" role="alert">{{ $recovery_code }}</div>
                        @enderror
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">İşlemi Onayla</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
