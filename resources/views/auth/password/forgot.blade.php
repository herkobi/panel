@extends('layouts.auth-password')
@section('content')
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="card card-md">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('herkobi.png') }}" alt="Herkobi" height="56">
                    </div>
                    <h2 class="h3 mb-3">Şifre Yenile</h2>
                    <p class="text-muted mb-3">Şifrenizi yenilemek için aşağıdaki forma e-posta adresinizi giriniz.</p>
                    @if (session('status'))
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
                    <form class="form" action="{{ route('password.email') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">E-posta Adresi</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ $email ?? old('email') }}" placeholder="E-posta Adresiniz" autocomplete="off"
                                required>
                            @error('email')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                    <path d="M3 7l9 6l9 -6" />
                                </svg>
                                Şifremi Sıfırla
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center text-muted mt-3">
                <a href="{{ route('login') }}">Oturum Aç</a>
            </div>
        </div>
    </div>
@endsection
