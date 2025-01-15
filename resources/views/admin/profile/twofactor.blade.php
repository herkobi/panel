@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Profil Bilgileri',
    ])
    <div class="page-content mt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.profile.include.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="page-form">
                        <h3 class="form-title border-bottom mb-3 pb-3">İki Faktörlü Doğrulama</h3>
                        @if (!auth()->user()->two_factor_secret)
                            <h3 class="card-title mt-4">Etkinleştir</h3>
                            <p class="card-subtitle mb-3">İki faktörlü doğrulama ile oturum açmak için lütfen
                                etkinleştiriniz.</p>
                            <div>
                                <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-qr-code" viewBox="0 0 20 20">
                                            <path d="M2 2h2v2H2z" />
                                            <path d="M6 0v6H0V0zM5 1H1v4h4zM4 12H2v2h2z" />
                                            <path d="M6 10v6H0v-6zm-5 1v4h4v-4zm11-9h2v2h-2z" />
                                            <path
                                                d="M10 0v6h6V0zm5 1v4h-4V1zM8 1V0h1v2H8v2H7V1zm0 5V4h1v2zM6 8V7h1V6h1v2h1V7h5v1h-4v1H7V8zm0 0v1H2V8H1v1H0V7h3v1zm10 1h-1V7h1zm-1 0h-1v2h2v-1h-1zm-4 0h2v1h-1v1h-1zm2 3v-1h-1v1h-1v1H9v1h3v-2zm0 0h3v1h-2v1h-1zm-4-1v1h1v-2H7v1z" />
                                            <path d="M7 12h1v3h4v1H7zm9 2v2h-3v-1h2v-1z" />
                                        </svg>
                                        {{ __('İki Faktörlü Doğrulamayı Etkinleştir') }}
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="row mb-5">
                                <div class="col-lg-4 col-md-5 mb-4">
                                    <h3 class="card-title">QR Kod</h3>
                                    <p class="card-subtitle">İki faktörlü kimlik doğrulama artık etkin. Telefonunuzun kimlik
                                        doğrulayıcı uygulamasını kullanarak yandaki QR kodunu tarayın.</p>
                                </div>
                                <div class="col-lg-6 col-md-4 offset-lg-2 offset-md-3">
                                    <div class="mb-3">
                                        {!! auth()->user()->twoFactorQrCodeSvg() !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-lg-4 col-md-5 mb-4">
                                    <h3 class="card-title">Kurtarma Kodları</h3>
                                    <p class="card-subtitle">Bu kurtarma kodlarını güvenli bir parola yöneticisinde
                                        saklayın.</p>
                                    <p class="card-subtitle">İki faktörlü kimlik doğrulama cihazınızın kaybolması durumunda,
                                        hesabınıza erişimi kurtarmak için kullanabilirsiniz.</p>
                                </div>
                                <div class="col-lg-6 col-md-4 offset-lg-2 offset-md-3">
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-4">
                                            <ul class="list-unstyled mb-2">
                                                @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                                    <li>{{ $code }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <form method="POST" action="{{ url('user/two-factor-recovery-codes') }}">
                                                @csrf
                                                <button type="submit" class="btn btn-dark">
                                                    {{ __('Kodları yeniden oluştur') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-lg-4 col-md-5 mb-4">
                                    <h3 class="card-title">Devre Dışı Bırak</h3>
                                    <p class="card-subtitle">İki faktörlü doğrulamayı devre dışı bırakmak için aşağıdaki
                                        butona tıklayınız.</p>
                                </div>
                                <div class="col-lg-6 col-md-4 offset-lg-2 offset-md-3">
                                    <div class="mb-3">
                                        <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                {{ __('İki Faktörlü Doğrulamayı Devre Dışı Bırak') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
