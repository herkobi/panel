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
                    'first_button' => 'EFT/Havale Ödeme Yöntemleri',
                    'first_link' => 'panel.gateways.bac',
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
                            <h1 class="card-title">EFT/Havale Ödeme Bilgisi Ekle</h1>
                        </div>
                        <form action="{{ route('panel.gateways.bac.create.store') }}" method="POST">
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
                                                        {{ 1 == $type->value ? 'checked' : '' }}>
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
                                            value="{{ old('title') }}" placeholder="Hesap Adı">
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
                                            value="{{ old('desc') }}" placeholder="Açıklama">
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
                                            @foreach ($currencies as $key => $currency)
                                                <option value="{{ $currency->id }}">
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
                                            <label class="col-form-label required">Hesap Adı</label>
                                            <div class="col">
                                                <input type="text" name="account_name"
                                                    class="form-control @error('account_name') is-invalid @enderror"
                                                    value="{{ old('account_name') }}" placeholder="Hesap Adı">
                                                @error('account_name')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Hesap sahibinin adını giriniz</small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-form-label required">Banka</label>
                                            <div class="col">
                                                <input type="text" name="account_bank"
                                                    class="form-control @error('account_bank') is-invalid @enderror"
                                                    value="{{ old('account_bank') }}" placeholder="Banka">
                                                @error('account_bank')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Hesabın bulunduğu bankayı giriniz</small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-md-4">
                                                <label class="col-form-label">Şube Kodu</label>
                                                <div class="col">
                                                    <input type="text" name="account_code"
                                                        class="form-control @error('account_code') is-invalid @enderror"
                                                        value="{{ old('account_code') }}" placeholder="Şube Kodu">
                                                    @error('account_code')
                                                        <span class="invalid-feedback"
                                                            role="alert">{{ $message }}</span>
                                                    @enderror
                                                    <small class="form-hint">Hesaba ait şube kodunu giriniz</small>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="col-form-label">Hesap Numarası</label>
                                                <div class="col">
                                                    <input type="text" name="account_number"
                                                        class="form-control @error('account_number') is-invalid @enderror"
                                                        value="{{ old('account_number') }}" placeholder="Hesap Numarası">
                                                    @error('account_number')
                                                        <span class="invalid-feedback"
                                                            role="alert">{{ $message }}</span>
                                                    @enderror
                                                    <small class="form-hint">Hesap numarasını giriniz</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-form-label">IBAN Numarası</label>
                                            <div class="col">
                                                <input type="text" name="account_iban"
                                                    class="form-control @error('account_iban') is-invalid @enderror"
                                                    value="{{ old('account_iban') }}" placeholder="IBAN Numarası">
                                                @error('account_iban')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Hesaba ait IBAN numarasını giriniz</small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-form-label">SWIFT Kodu</label>
                                            <div class="col">
                                                <input type="text" name="account_swift"
                                                    class="form-control @error('account_swift') is-invalid @enderror"
                                                    value="{{ old('account_swift') }}" placeholder="SWIFT Kodu">
                                                @error('account_swift')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Hesaba ait SWIFT kodunu giriniz</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
