@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Profil Bilgileri',
    ])
    <div class="page-content flex-grow-1 d-flex flex-column shadow-sm">
        <div class="row flex-grow-1">
            <div class="col-20 col-lg-3 col-md-3">
                <div class="page-menu rounded-2">
                    @include('admin.profile.include.navigation')
                </div>
            </div>
            <div class="col-80 col-lg-9 col-md-9">
                <div class="card h-100 border-0 mb-5">
                    <div class="card-header border-0 bg-white p-0 mb-3">
                        <div class="d-flex align-items-center justify-content-between w-100 border-bottom pb-2">
                            <h1 class="card-title">İki Faktörlü Doğrulama</h1>
                        </div>
                    </div>
                    <div class="card-body">
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
                            <div class="row">
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
