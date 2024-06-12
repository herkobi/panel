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
                    'first_button' => __('admin/gateways/cc.main.button'),
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
                            <h1 class="card-title">{{ __('admin/gateways/paytr/update.page.title') }}</h1>
                        </div>
                        <form action="{{ route('panel.gateways.paytr.update', $paytr->id) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label
                                        class="col-3 col-form-label required">{{ __('admin/gateways/paytr/update.form.status.label') }}</label>
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
                                    <label
                                        class="col-3 col-form-label required">{{ __('admin/gateways/paytr/update.form.name.label') }}</label>
                                    <div class="col">
                                        <input type="text" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ $paytr->title ? $paytr->title : old('title') }}"
                                            placeholder="{{ __('admin/gateways/paytr/update.form.name.placeholder') }}">
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small
                                            class="form-hint">{{ __('admin/gateways/paytr/update.form.name.helper') }}</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label
                                        class="col-3 col-form-label required">{{ __('admin/gateways/paytr/update.form.desc.label') }}</label>
                                    <div class="col">
                                        <input type="text" name="desc"
                                            class="form-control @error('desc') is-invalid @enderror"
                                            value="{{ $paytr->desc ? $paytr->desc : old('desc') }}"
                                            placeholder="{{ __('admin/gateways/paytr/update.form.desc.placeholder') }}">
                                        @error('desc')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small
                                            class="form-hint">{{ __('admin/gateways/paytr/update.form.desc.helper') }}</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label
                                        class="col-3 col-form-label required">{{ __('admin/gateways/paytr/update.form.currency.label') }}</label>
                                    <div class="col">
                                        <select class="form-select shadow-none @error('currency_id') is-invalid @enderror"
                                            name="currency_id">
                                            <option>{{ __('admin/gateways/paytr/update.form.currency.placeholder') }}
                                            </option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}"
                                                    {{ $currency->id == $paytr->currency_id ? 'selected' : '' }}>
                                                    {{ $currency->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('currency_id')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small
                                            class="form-hint">{{ __('admin/gateways/paytr/update.form.currency.helper') }}</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label
                                        class="col-3 col-form-label">{{ __('admin/gateways/paytr/update.form.cc.section') }}</label>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label
                                                class="col-form-label required">{{ __('admin/gateways/paytr/update.form.cc.account.label') }}</label>
                                            <div class="col">
                                                <input type="text" name="merchant_id"
                                                    class="form-control @error('merchant_id') is-invalid @enderror"
                                                    value="{{ $values['merchant_id'] ? $values['merchant_id'] : old('merchant_id') }}"
                                                    placeholder="Mağaza No">
                                                @error('merchant_id')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small
                                                    class="form-hint">{{ __('admin/gateways/paytr/update.form.cc.account.helper') }}</small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label
                                                class="col-form-label required">{{ __('admin/gateways/paytr/update.form.cc.key.label') }}</label>
                                            <div class="col">
                                                <input type="text" name="merchant_key"
                                                    class="form-control @error('merchant_key') is-invalid @enderror"
                                                    value="{{ $values['merchant_key'] ? $values['merchant_key'] : old('merchant_key') }}"
                                                    placeholder="Mağaza Parolası">
                                                @error('merchant_key')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small
                                                    class="form-hint">{{ __('admin/gateways/paytr/update.form.cc.key.helper') }}</small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label
                                                class="col-form-label required">{{ __('admin/gateways/paytr/update.form.cc.secret.label') }}</label>
                                            <div class="col">
                                                <input type="text" name="merchant_salt"
                                                    class="form-control @error('merchant_salt') is-invalid @enderror"
                                                    value="{{ $values['merchant_salt'] ? $values['merchant_salt'] : old('merchant_salt') }}"
                                                    placeholder="Mağaza Gizli Anahtar">
                                                @error('merchant_salt')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small
                                                    class="form-hint">{{ __('admin/gateways/paytr/update.form.cc.secret.helper') }}</small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label
                                                class="col-form-label required">{{ __('admin/gateways/paytr/update.form.cc.success.url') }}</label>
                                            <div class="col">
                                                <input type="text" name="merchant_ok_url"
                                                    class="form-control @error('merchant_ok_url') is-invalid @enderror"
                                                    value="{{ $values['merchant_ok_url'] ? $values['merchant_ok_url'] : old('merchant_ok_url') }}"
                                                    placeholder="Başarılı Dönüş Adresi">
                                                @error('merchant_ok_url')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small
                                                    class="form-hint">{{ __('admin/gateways/paytr/update.form.cc.success.url.helper') }}</small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label
                                                class="col-form-label required">{{ __('admin/gateways/paytr/update.form.cc.wrong.url') }}</label>
                                            <div class="col">
                                                <input type="text" name="merchant_fail_url"
                                                    class="form-control @error('merchant_fail_url') is-invalid @enderror"
                                                    value="{{ $values['merchant_fail_url'] ? $values['merchant_fail_url'] : old('merchant_fail_url') }}"
                                                    placeholder="Hatalı Dönüş Adresi">
                                                @error('merchant_fail_url')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small
                                                    class="form-hint">{{ __('admin/gateways/paytr/update.form.cc.wrong.url.helper') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit"
                                    class="btn btn-success">{{ __('admin/gateways/paytr/update.form.cc.update.button') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
