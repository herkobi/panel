@extends('layouts.auth')
@section('content')
<div class="card rounded-0 border-0 bg-white auth-card">
    <div class="card-body px-4 py-4">
        <div class="card-logo text-center mb-4">
            <img src="{{asset('herkobi.png')}}" class="img-fluid" alt="Herkobi Panel">
        </div>
        <div class="card-text mb-3">
            <span>Lütfen 2 faktörlü doğrulama kodunu ya da gizli anahtarlarınızdan birini giriniz.</span>
            @if (session('status'))
            <div class="alert alert-info alert-dismissible fade show rounded-0 shadow-none my-2" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
        <div class="card-form">
            <form method="POST" action="/two-factor-challenge" autocomplete="off">
                @csrf
                <div class="mb-2">
                    <div class="input-group">
                        <span class="input-group-text rounded-0 shadow-none bg-white">
                            <i class="ri-key-line"></i>
                        </span>
                        <input type="text" id="code" class="form-control border-start-0 border-end-0 rounded-0 shadow-none" name="code">
                    </div>
                </div>
                <div class="mb-2">
                    <p class="text-muted">{{ __('Or you can enter one of your emergency recovery codes.') }}</p>
                </div>
                <div class="mb-2">
                    <div class="input-group">
                        <span class="input-group-text rounded-0 shadow-none bg-white">
                            <i class="ri-key-2-line"></i>
                        </span>
                        <input type="text" id="recovery-code" class="form-control border-start-0 border-end-0 rounded-0 shadow-none" name="recovery_code">
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
