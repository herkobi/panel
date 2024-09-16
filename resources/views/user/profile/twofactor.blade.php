@extends('layouts.app')
@section('content')
    <div class="container h-100">
        @include('user.include.header', [
            'title' => 'Profil Bilgileri',
        ])
        <div class="page-content flex-grow-1 d-flex flex-column shadow-sm h-100">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="page-menu rounded-2">
                                @include('user.profile.include.navigation')
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h2 class="border-bottom mb-4 pb-3">İki Faktörlü Doğrulama</h2>
                            @if (!auth()->user()->two_factor_secret)
                                <h3 class="card-title mt-4">Etkinleştir</h3>
                                <p class="card-subtitle mb-3">İki faktörlü doğrulama ile oturum açmak için lütfen
                                    etkinleştiriniz.</p>
                                <div>
                                    <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-auth-2fa">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 16h-4l3.47 -4.66a2 2 0 1 0 -3.47 -1.54" />
                                                <path d="M10 16v-8h4" />
                                                <path d="M10 12l3 0" />
                                                <path d="M17 16v-6a2 2 0 0 1 4 0v6" />
                                                <path d="M17 13l4 0" />
                                            </svg>
                                            {{ __('İki Faktörlü Doğrulamayı Etkinleştir') }}
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="row mb-5">
                                    <div class="col-lg-4 col-md-5 mb-4">
                                        <h3>QR Kod</h3>
                                        <p class="card-subtitle">İki faktörlü kimlik doğrulama artık etkin.
                                            Telefonunuzun kimlik
                                            doğrulayıcı uygulamasını kullanarak yandaki QR kodunu tarayın.</p>
                                    </div>
                                    <div class="col-lg-8 col-md-7">
                                        <div class="mb-3">
                                            {!! auth()->user()->twoFactorQrCodeSvg() !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-lg-4 col-md-5 mb-4">
                                        <h3>Kurtarma Kodları</h3>
                                        <p class="card-subtitle mb-3">Bu kurtarma kodlarını güvenli bir parola
                                            yöneticisinde saklayın.</p>
                                        <p class="card-subtitle">İki faktörlü kimlik doğrulama cihazınızın
                                            kaybolması durumunda, hesabınıza erişimi kurtarmak için kullanabilirsiniz.</p>
                                    </div>
                                    <div class="col-lg-8 col-md-7">
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
                                <div class="row">
                                    <div class="col-lg-4 col-md-5 mb-4">
                                        <h3>Devre Dışı Bırak</h3>
                                        <p class="card-subtitle">İki faktörlü doğrulamayı devre dışı bırakmak için
                                            aşağıdaki butona tıklayınız.</p>
                                    </div>
                                    <div class="col-lg-8 col-md-7">
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
    </div>
@endsection
