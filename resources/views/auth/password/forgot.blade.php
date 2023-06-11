@extends('layouts.auth')
@section('content')
<div class="card rounded-0 border-0 bg-white auth-card">
    <div class="card-body px-4 py-4">
        <div class="card-logo text-center mb-4">
            <img src="{{asset('herkobi.png')}}" class="img-fluid" alt="Herkobi Panel">
        </div>
        <div class="card-text mb-3">
            <span>Şifrenizi yenilemek için aşağıdaki forma e-posta adresinizi giriniz.</span>
            @if (session('status'))
            <div class="alert alert-success my-2" role="alert">
                {{ session('status') }}
            </div>
            @endif
        </div>
        <div class="card-form">
            <form method="POST" action="{{route('password.email')}}" autocomplete="off">
                @csrf
                <div class="mb-2">
                    <div class="input-group">
                        <span class="input-group-text rounded-0 shadow-none bg-white">
                            <i class="ri-mail-check-line"></i>
                        </span>
                        <input type="email" id="emailaddress" placeholder="E-posta Adresiniz" class="form-control border-start-0 rounded-0 shadow-none @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="off">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-2">
                    <button type="submit" class="btn btn-lg btn-primary w-100 rounded-0 shadow-none text-white">
                        <i class="ri-check-double-line"></i>
                        <span>Şifremi Yenile</span>
                    </button>
                </div>
                <div class="mb-3 text-center">
                    <a class="btn btn-link text-decoration-none shadow-none text-muted" title="Oturum Aç" href="{{ route('login') }}"><i class="ri-user-follow-line"></i> Oturum Aç</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
