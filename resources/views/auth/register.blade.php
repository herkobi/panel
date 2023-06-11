@extends('layouts.auth')
@section('content')
<div class="card rounded-0 border-0 bg-white auth-card">
    <div class="card-body px-4 py-4">
        <div class="card-logo text-center mb-4">
            <img src="{{asset('herkobi.png')}}" class="img-fluid" alt="Herkobi Panel">
        </div>
        <div class="card-text mb-3">
            <span>Lütfen üye olmak için aşağıdaki formu doldurunuz.</span>
            @if (session('status'))
            <div class="alert alert-success my-2" role="alert">
                {{ session('status') }}
            </div>
            @endif
        </div>
        <div class="card-form">
            <form method="POST" action="{{route('register')}}" autocomplete="off">
                @csrf
                <div class="mb-2">
                    <div class="input-group">
                        <span class="input-group-text rounded-0 shadow-none bg-white">
                            <i class="ri-user-line"></i>
                        </span>
                        <input type="text" id="name" placeholder="Ad Soyad" class="form-control border-start-0 rounded-0 shadow-none @error('name') is-invalid @enderror" name="name" required autocomplete="off" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-2">
                    <div class="input-group">
                        <span class="input-group-text rounded-0 shadow-none bg-white">
                            <i class="ri-mail-check-line"></i>
                        </span>
                        <input type="email" id="emailaddress" placeholder="E-posta Adresiniz" class="form-control border-start-0 rounded-0 shadow-none @error('email') is-invalid @enderror" name="email" required autocomplete="off">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-2">
                    <div class="input-group">
                        <span class="input-group-text rounded-0 shadow-none bg-white">
                            <i class="ri-key-line"></i>
                        </span>
                        <input type="password" id="password" placeholder="Şifreniz" class="form-control border-start-0 border-end-0 rounded-0 shadow-none @error('password') is-invalid @enderror" name="password" required autocomplete="off">
                        <span class="input-group-text rounded-0 shadow-none bg-white" onclick="password_show_hide();">
                            <i class="ri-eye-off-line showpassword"></i>
                            <i class="ri-eye-line hidepassword d-none"></i>
                        </span>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-2">
                    <div class="input-group">
                        <span class="input-group-text rounded-0 shadow-none bg-white">
                            <i class="ri-key-2-line"></i>
                        </span>
                        <input type="password" id="password_confirmation" placeholder="Şifrenizi Tekrar Giriniz" class="form-control border-start-0 border-end-0 rounded-0 shadow-none @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="off">
                        <span class="input-group-text rounded-0 shadow-none bg-white" onclick="password_conf_show_hide();">
                            <i class="ri-eye-off-line showpassword_conf"></i>
                            <i class="ri-eye-line hidepassword_conf d-none"></i>
                        </span>
                        @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-2">
                    <div class="form-check text-start mb-3">
                        <input class="form-check-input rounded-0 shadow-none" name="remember" type="checkbox" id="tos" required>
                        <label class="form-check-label" for="remember">Kullanım sözleşmesini kabul ediyorum.</label>
                    </div>
                </div>
                <div class="mb-2">
                    <button type="submit" class="btn btn-lg btn-primary w-100 rounded-0 shadow-none text-white">
                        <i class="ri-check-double-line"></i>
                        <span>Üye Ol</span>
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
