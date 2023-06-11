@extends('layouts.app')
@section('content')
@include('layouts.partials.page-title', ['title' => 'İki Faktörlü Doğrulama'])
<div class="page-content position-relative mb-4">
    <div class="row">
        <div class="col-md-8">
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
            <div class="card rounded-0 shadow-sm border-0 mb-3">
                <div class="card-header border-0 bg-white pt-3 pb-3">
                    <h4 class="card-title mb-0">İki Faktörlü Doğrulama Bilgileri</h4>
                </div>
                <div class="card-body">
                    @if(! auth()->user()->two_factor_secret)
                    <div class="mb-3 border-bottom pb-3">
                        <div class="row">
                            <label for="two-factor" class="col-md-4 fw-semibold align-self-center">İki Faktörlü Doğrulama</label>
                            <div class="col-md-8">
                                <form method="POST" action="{{ url('panel/two-factor-authentication') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary rounded-0 shadow-none">
                                        {{ __('İki Faktörlü Doğrulamayı Etkinleştir') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="mb-3 border-bottom pb-3">
                        <div class="row">
                            <label for="two-factor" class="col-md-4 fw-semibold align-self-center">İki Faktörlü Doğrulama</label>
                            <div class="col-md-8">
                                <form method="POST" action="{{ url('panel/two-factor-authentication') }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger rounded-0 shadow-none">
                                        {{ __('İki Faktörlü Doğrulamayı Devre Dışı Bırak') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 border-bottom pb-3">
                        <div class="row">
                            <label for="qr-code" class="col-md-4 fw-semibold align-self-center">QR Kod</label>
                            <div class="col-md-8">
                                @if(session('status') == 'two-factor-authentication-enabled')
                                <p>
                                    {{ __('İki faktörlü kimlik doğrulama artık etkin. Telefonunuzun kimlik doğrulayıcı uygulamasını kullanarak aşağıdaki QR kodunu tarayın.') }}
                                </p>
                                <div class="mb-3">
                                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 border-bottom pb-3">
                        <div class="row">
                            <label for="recovery-codes" class="col-md-4 fw-semibold align-self-start">Kurtarma Kodları</label>
                            <div class="col-md-8">
                                <p>
                                    {{ __('Bu kurtarma kodlarını güvenli bir parola yöneticisinde saklayın. İki faktörlü kimlik doğrulama cihazınızın kaybolması durumunda, hesabınıza erişimi kurtarmak için kullanılabilirler.') }}
                                </p>

                                <ul class="ps-3">
                                    @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                    <li>{{ $code }}</li>
                                    @endforeach
                                </ul>
                                <form method="POST" action="{{ url('panel/two-factor-recovery-codes') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-dark rounded-0 shadow-none">
                                        {{ __('Kodları yeniden oluştur') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
