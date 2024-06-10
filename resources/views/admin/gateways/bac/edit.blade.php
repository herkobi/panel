@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => config('panel.title'),
                    'title' => __('admin/settings/payments.main.title'),
                ])
                @include('admin.settings.payments.partials.page-buttons', [
                    'first_button' => __('admin/gateways/bac.main.button'),
                    'first_link' => 'panel.gateways.bac',
                    'second_button' => __('admin/gateways/bac.create.button'),
                    'second_link' => 'panel.gateways.bac.create',
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
                            <h1 class="card-title">EFT/Havale Ödeme Bilgisini Düzenle</h1>
                        </div>
                        <form action="{{ route('panel.gateways.bac.update', $bac->id) }}" method="POST">
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
                                                        {{ $bac->status->value == $type->value ? 'checked' : '' }}>
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
                                            value="{{ $bac->title ? $bac->title : old('title') }}" placeholder="Hesap Adı">
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
                                            value="{{ $bac->desc ? $bac->desc : old('desc') }}" placeholder="Açıklama">
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
                                                <option value="{{ $currency->id }}"
                                                    {{ $currency->id == $bac->currency_id ? 'selected' : '' }}>
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
                                                    value="{{ $values['account_name'] ? $values['account_name'] : old('account_name') }}"
                                                    placeholder="Hesap Adı">
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
                                                    value="{{ $values['account_bank'] ? $values['account_bank'] : old('account_bank') }}"
                                                    placeholder="Banka">
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
                                                        value="{{ $values['account_code'] ? $values['account_code'] : old('account_code') }}"
                                                        placeholder="Şube Kodu">
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
                                                        value="{{ $values['account_number'] ? $values['account_number'] : old('account_number') }}"
                                                        placeholder="Hesap Numarası">
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
                                                    value="{{ $values['account_iban'] ? $values['account_iban'] : old('account_iban') }}"
                                                    placeholder="IBAN Numarası">
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
                                                    value="{{ $values['account_swift'] ? $values['account_swift'] : old('account_swift') }}"
                                                    placeholder="SWIFT Kodu">
                                                @error('account_swift')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Hesaba ait SWIFT kodunu giriniz</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="btn-list">
                                    @hasrole('Super Admin')
                                        <a href="#" class="btn btn-outline-danger me-auto" data-bs-toggle="modal"
                                            data-bs-target="#modal-danger">Sil</a>
                                    @endhasrole
                                    <button type="submit" class="btn btn-success">Güncelle</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    <h3>Emin misiniz?</h3>
                    <div class="text-secondary">Bu işlem geri alınamaz. Devam etmek istiyor musunuz?
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn w-100" data-bs-dismiss="modal">
                                    İptal Et
                                </a>
                            </div>
                            <div class="col">
                                <form action="{{ route('panel.gateways.bac.destroy', $bac->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                        Evet, Devam Et
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
