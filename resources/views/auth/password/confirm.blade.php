@extends('layouts.auth')
@section('content')
<div class="card rounded-0 border-0 bg-white auth-card">
    <div class="card-body px-4 py-4">
        <div class="card-logo text-center mb-4">
            <img src="{{asset('herkobi.png')}}" class="img-fluid" alt="Herkobi Panel">
        </div>
        <div class="card-text mb-3">
            <span>Bu işlemi gerçekleştirmek için şifrenizi girmeniz gerekmektedir.</span>
            @if (session('status'))
            <div class="alert alert-info alert-dismissible fade show rounded-0 shadow-none my-2" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
        <div class="card-form">
            <form method="POST" action="{{route('password.confirm')}}" autocomplete="off">
                @csrf
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
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-lg btn-primary w-100 rounded-0 shadow-none text-white">
                        <i class="ri-check-double-line"></i>
                        <span>İşlemi Onayla</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
