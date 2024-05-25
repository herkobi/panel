@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'İki Faktörlü Doğrulama',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-md-3 border-end">
                        <div class="card-body">
                            <h4 class="subheader">Profil Bilgileri</h4>
                            <div class="list-group list-group-transparent">
                                @include('admin.profile.partials.navigation')
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body">
                            <h2 class="profile-section-title border-bottom fw-normal pb-3 mb-5">İki Faktörlü Doğrulama</h2>
                            @if (!auth()->user()->two_factor_secret)
                                <h3 class="card-title mt-4">Etkinleştir</h3>
                                <p class="card-subtitle">İki faktörlü doğrulama ile oturum açmak için lütfen
                                    etkinleştiriniz.</p>
                                <div>
                                    <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                                        @csrf
                                        <button type="submit" class="btn">
                                            {{ __('İki Faktörlü Doğrulamayı Etkinleştir') }}
                                        </button>
                                    </form>
                                </div>
                            @else
                                <h3 class="card-title mt-4">QR Kod</h3>
                                <p class="card-subtitle">İki faktörlü kimlik doğrulama artık etkin. Telefonunuzun kimlik
                                    doğrulayıcı uygulamasını kullanarak aşağıdaki QR kodunu tarayın.</p>
                                <div class="mb-3">
                                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                                </div>
                                <h3 class="card-title mt-4">Kurtarma Kodları</h3>
                                <p class="card-subtitle">Bu kurtarma kodlarını güvenli bir parola yöneticisinde saklayın.
                                    İki faktörlü kimlik doğrulama cihazınızın kaybolması durumunda, hesabınıza erişimi
                                    kurtarmak için kullanabilirsiniz.</p>
                                <ul class="ps-3">
                                    @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                        <li>{{ $code }}</li>
                                    @endforeach
                                </ul>
                                <form method="POST" action="{{ url('user/two-factor-recovery-codes') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-dark">
                                        {{ __('Kodları yeniden oluştur') }}
                                    </button>
                                </form>
                                <hr>
                                <h3 class="card-title mt-4">Devre Dışı Bırak</h3>
                                <p class="card-subtitle">İki faktörlü doğrulamayı devre dışı bırakmak için aşağıdaki
                                    butona tıklayınız.</p>
                                <div>
                                    <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            {{ __('İki Faktörlü Doğrulamayı Devre Dışı Bırak') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
