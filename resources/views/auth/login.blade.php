@extends('layouts.auth')
@section('content')
<div class="card rounded-0 border-0 bg-white auth-card">
    <div class="card-body px-4 py-4">
        <div class="card-logo text-center mb-4">
            <img src="{{asset('herkobi.png')}}" class="img-fluid" alt="Herkobi Panel">
        </div>
        <div class="card-text mb-3">
            <span>Oturum açmak için aşağıdaki forma bilgilerinizi giriniz.</span>
            @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show rounded-0 shadow-none my-2" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
        <div class="card-form">
            <form method="POST" action="{{route('login')}}" autocomplete="off">
                @csrf
                <div class="mb-2">
                    <div class="input-group">
                        <span class="input-group-text rounded-0 shadow-none bg-white">
                            <i class="ri-mail-check-line"></i>
                        </span>
                        <input type="email" id="emailaddress" placeholder="E-posta Adresiniz" class="form-control border-start-0 rounded-0 shadow-none @error('email') is-invalid @enderror" name="email" required autocomplete="off">
                        @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>
                <div class="mb-2">
                    <div class="input-group">
                        <span class="input-group-text rounded-0 shadow-none bg-white">
                            <i class="ri-lock-password-line"></i>
                        </span>
                        <input type="password" id="password" placeholder="Şifreniz" class="form-control border-start-0 border-end-0 rounded-0 shadow-none @error('password') is-invalid @enderror" name="password" required autocomplete="off">
                        <span class="input-group-text rounded-0 shadow-none bg-white" onclick="password_show_hide();">
                            <i class="ri-eye-off-line showpassword"></i>
                            <i class="ri-eye-line hidepassword d-none"></i>
                        </span>
                        @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>
                <div class="mb-2">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="form-check text-start mb-0">
                            <input class="form-check-input rounded-0 shadow-none" name="remember" type="checkbox" id="remember" >
                            <label class="form-check-label" for="remember">Beni Hatırla</label>
                        </div>
                        <a class="btn btn-link text-decoration-none shadow-none text-muted p-0 password-reset" title="Şifremi Unuttum" href="{{ route('password.request') }}">Şifremi Unuttum</a>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-lg btn-primary w-100 rounded-0 shadow-none text-white">
                        <i class="ri-check-double-line"></i>
                        <span>Oturum Aç</span>
                    </button>
                </div>
                <div class="mb-3 text-center">
                    <a class="btn btn-link text-decoration-none text-muted shadow-none" title="Üye Ol" href="{{ route('register') }}"><i class="ri-user-add-line"></i> Üye Ol</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
