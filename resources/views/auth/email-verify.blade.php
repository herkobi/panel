@extends('layouts.auth')
@section('content')
<div class="card rounded-0 border-0 bg-white auth-card">
    <div class="card-body px-4 py-4">
        <div class="card-logo text-center mb-4">
            <img src="{{asset('herkobi.png')}}" class="img-fluid" alt="Herkobi Panel">
        </div>
        <div class="card-text mb-3">
            <h4 class="card-title mb-2">E-posta Adresinizi Onaylayın</h4>
            @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
            @endif

            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }},
            <div class="d-flex align-items-center justify-content-between my-3 w-100">
            <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary rounded-0 shadow-none">Tekrar Onay Kodu Gönder</button>
            </form>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger rounded-0 shadow-none" onclick="event.preventDefault(); this.closest('form').submit();">Oturumu Kapat</button>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection
