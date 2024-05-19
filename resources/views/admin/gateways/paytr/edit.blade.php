@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Ödeme Yöntemleri',
                ])
                @include('admin.settings.payments.partials.page-buttons', [
                    'first_button' => 'Kredi Kartı Ödeme Yöntemleri',
                    'first_link' => 'panel.gateways.cc',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.settings.payments.partials.payments')
                    @include('admin.settings.partials.navigation')
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">Paytr Bilgilerini Düzenle</h1>
                        </div>
                        <form action="{{ route('panel.gateways.paytr.update', $paytr->id) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Durum</label>
                                    <div class="col">
                                        <div>
                                            @foreach (Status::cases() as $type)
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status"
                                                        value="{{ $type->value }}"
                                                        {{ $paytr->status->value == $type->value ? 'checked' : '' }}>
                                                    <span
                                                        class="form-check-label">{{ Status::getTitle($type->value) }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Hesap Adı</label>
                                    <div class="col">
                                        <input type="text" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ $paytr->title ? $paytr->title : old('title') }}"
                                            placeholder="Hesap Adı">
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">Ödeme sistemi için bir isim giriniz. Örnek:
                                            Eft/Havale Ödeme</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Açıklama</label>
                                    <div class="col">
                                        <input type="text" name="desc"
                                            class="form-control @error('desc') is-invalid @enderror"
                                            value="{{ $paytr->desc ? $paytr->desc : old('desc') }}" placeholder="Açıklama">
                                        @error('desc')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">Ödeme adımında gösterilecek açıklama metni</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Para Birimi</label>
                                    <div class="col">
                                        <select class="form-select shadow-none @error('currency_id') is-invalid @enderror"
                                            name="currency_id">
                                            <option>Lütfen Seçiniz</option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}"
                                                    {{ $currency->id == $paytr->currency_id ? 'selected' : '' }}>
                                                    {{ $currency->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('currency_id')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">Hesabın ait olduğu para birimini seçiniz.</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">Hesap Bilgileri</label>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-form-label required">Mağaza No</label>
                                            <div class="col">
                                                <input type="text" name="merchant_id"
                                                    class="form-control @error('merchant_id') is-invalid @enderror"
                                                    value="{{ $values['merchant_id'] ? $values['merchant_id'] : old('merchant_id') }}"
                                                    placeholder="Mağaza No">
                                                @error('merchant_id')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Mağazaya ait numarayı giriniz</small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-form-label required">Mağaza Parolası</label>
                                            <div class="col">
                                                <input type="text" name="merchant_key"
                                                    class="form-control @error('merchant_key') is-invalid @enderror"
                                                    value="{{ $values['merchant_key'] ? $values['merchant_key'] : old('merchant_key') }}"
                                                    placeholder="Mağaza Parolası">
                                                @error('merchant_key')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Mağaza parolasını giriniz</small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-form-label required">Mağaza Gizli Anahtar</label>
                                            <div class="col">
                                                <input type="text" name="merchant_salt"
                                                    class="form-control @error('merchant_salt') is-invalid @enderror"
                                                    value="{{ $values['merchant_salt'] ? $values['merchant_salt'] : old('merchant_salt') }}"
                                                    placeholder="Mağaza Gizli Anahtar">
                                                @error('merchant_salt')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Mağaza gizli anahtar bilgisini giriniz</small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-form-label required">Başarılı Dönüş Adresi</label>
                                            <div class="col">
                                                <input type="text" name="merchant_ok_url"
                                                    class="form-control @error('merchant_ok_url') is-invalid @enderror"
                                                    value="{{ $values['merchant_ok_url'] ? $values['merchant_ok_url'] : old('merchant_ok_url') }}"
                                                    placeholder="Başarılı Dönüş Adresi">
                                                @error('merchant_ok_url')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Ödeme başarılı olduğunda gösterilecek
                                                    sayfa</small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-form-label required">Hatalı Dönüş Adresi</label>
                                            <div class="col">
                                                <input type="text" name="merchant_fail_url"
                                                    class="form-control @error('merchant_fail_url') is-invalid @enderror"
                                                    value="{{ $values['merchant_fail_url'] ? $values['merchant_fail_url'] : old('merchant_fail_url') }}"
                                                    placeholder="Hatalı Dönüş Adresi">
                                                @error('merchant_fail_url')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Ödeme hatalı olduğunda gösterilecek sayfa</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-success">Güncelle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (Session::has('error') || $errors->any())
        <div class="modal modal-blur fade" id="modal-danger" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-body text-center py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 9v4" />
                            <path
                                d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" />
                            <path d="M12 16h.01" />
                        </svg>
                        <h3>Hata</h3>
                        @if ($errors->any())
                            <div class="text-secondary">
                                <ul class="list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="text-secondary">{{ Session::get('error') }}</div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <div class="w-100 text-center">
                            <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                Kapat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="module">
            var successModal = new bootstrap.Modal(document.getElementById('modal-danger'), {})
            successModal.toggle()
        </script>
    @endif
@endsection
