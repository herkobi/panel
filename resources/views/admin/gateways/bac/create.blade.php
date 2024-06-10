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
                            <h1 class="card-title">{{ __('admin/gateways/bac/create.page.title') }}</h1>
                        </div>
                        <form action="{{ route('panel.gateways.bac.create.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label
                                        class="col-3 col-form-label required">{{ __('admin/gateways/bac/create.form.account.status.label') }}</label>
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
                                    <label
                                        class="col-3 col-form-label required">{{ __('admin/gateways/bac/create.form.name.label') }}</label>
                                    <div class="col">
                                        <input type="text" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}"
                                            placeholder="{{ __('admin/gateways/bac/create.form.name.placeholder') }}">
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small
                                            class="form-hint">{{ __('admin/gateways/bac/create.form.name.helper') }}</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label
                                        class="col-3 col-form-label required">{{ __('admin/gateways/bac/create.form.desc.label') }}</label>
                                    <div class="col">
                                        <input type="text" name="desc"
                                            class="form-control @error('desc') is-invalid @enderror"
                                            value="{{ old('desc') }}"
                                            placeholder="{{ __('admin/gateways/bac/create.form.desc.placeholder') }}">
                                        @error('desc')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small
                                            class="form-hint">{{ __('admin/gateways/bac/create.form.desc.helper') }}</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label
                                        class="col-3 col-form-label required">{{ __('admin/gateways/bac/create.form.currency.label') }}</label>
                                    <div class="col">
                                        <select class="form-select shadow-none @error('currency_id') is-invalid @enderror"
                                            name="currency_id">
                                            <option>{{ __('admin/gateways/bac/create.form.currency.placeholder') }}
                                            </option>
                                            @foreach ($currencies as $key => $currency)
                                                <option value="{{ $currency->id }}">
                                                    {{ $currency->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('currency_id')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small
                                            class="form-hint">{{ __('admin/gateways/bac/create.form.currency.helper') }}</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label
                                        class="col-3 col-form-label">{{ __('admin/gateways/bac/create.form.bac.section') }}</label>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label
                                                class="col-form-label required">{{ __('admin/gateways/bac/create.form.bac.account.label') }}</label>
                                            <div class="col">
                                                <input type="text" name="account_name"
                                                    class="form-control @error('account_name') is-invalid @enderror"
                                                    value="{{ old('account_name') }}"
                                                    placeholder="{{ __('admin/gateways/bac/create.form.bac.account.placeholder') }}">
                                                @error('account_name')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small
                                                    class="form-hint">{{ __('admin/gateways/bac/create.form.bac.account.helper') }}</small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label
                                                class="col-form-label required">{{ __('admin/gateways/bac/create.form.bac.bank.label') }}</label>
                                            <div class="col">
                                                <input type="text" name="account_bank"
                                                    class="form-control @error('account_bank') is-invalid @enderror"
                                                    value="{{ old('account_bank') }}"
                                                    placeholder="{{ __('admin/gateways/bac/create.form.bac.bank.placeholder') }}">
                                                @error('account_bank')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small
                                                    class="form-hint">{{ __('admin/gateways/bac/create.form.bac.bank.helper') }}</small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-form-label">{{ __('admin/gateways/bac/create.form.bac.branch.label') }}</label>
                                                <div class="col">
                                                    <input type="text" name="account_code"
                                                        class="form-control @error('account_code') is-invalid @enderror"
                                                        value="{{ old('account_code') }}"
                                                        placeholder="{{ __('admin/gateways/bac/create.form.bac.branch.placeholder') }}">
                                                    @error('account_code')
                                                        <span class="invalid-feedback"
                                                            role="alert">{{ $message }}</span>
                                                    @enderror
                                                    <small
                                                        class="form-hint">{{ __('admin/gateways/bac/create.form.bac.branch.helper') }}</small>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <label
                                                    class="col-form-label">{{ __('admin/gateways/bac/create.form.bac.number.label') }}</label>
                                                <div class="col">
                                                    <input type="text" name="account_number"
                                                        class="form-control @error('account_number') is-invalid @enderror"
                                                        value="{{ old('account_number') }}"
                                                        placeholder="{{ __('admin/gateways/bac/create.form.bac.number.placeholder') }}">
                                                    @error('account_number')
                                                        <span class="invalid-feedback"
                                                            role="alert">{{ $message }}</span>
                                                    @enderror
                                                    <small
                                                        class="form-hint">{{ __('admin/gateways/bac/create.form.bac.number.helper') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label
                                                class="col-form-label">{{ __('admin/gateways/bac/create.form.bac.iban.label') }}</label>
                                            <div class="col">
                                                <input type="text" name="account_iban"
                                                    class="form-control @error('account_iban') is-invalid @enderror"
                                                    value="{{ old('account_iban') }}"
                                                    placeholder="{{ __('admin/gateways/bac/create.form.bac.iban.placeholder') }}">
                                                @error('account_iban')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small
                                                    class="form-hint">{{ __('admin/gateways/bac/create.form.bac.iban.helper') }}</small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label
                                                class="col-form-label">{{ __('admin/gateways/bac/create.form.bac.swift.label') }}</label>
                                            <div class="col">
                                                <input type="text" name="account_swift"
                                                    class="form-control @error('account_swift') is-invalid @enderror"
                                                    value="{{ old('account_swift') }}"
                                                    placeholder="{{ __('admin/gateways/bac/create.form.bac.swift.placeholder') }}">
                                                @error('account_swift')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small
                                                    class="form-hint">{{ __('admin/gateways/bac/create.form.bac.swift.helper') }}</small>
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
