@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Vergi Bilgileri',
                ])
                @include('admin.settings.taxes.partials.page-buttons', [
                    'first_button' => 'Vergi Oranları',
                    'first_link' => 'panel.settings.taxes',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.settings.partials.definitions')
                    @include('admin.settings.partials.navigation')
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">Yeni Vergi</h1>
                        </div>
                        <form action="{{ route('panel.settings.tax.create.store') }}" method="POST">
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
                                    <label class="col-3 col-form-label required">Vergi Adı</label>
                                    <div class="col">
                                        <input type="text" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}" placeholder="Vergi Adı">
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">Kullanacağınız vergi oranının tam adını giriniz. Örnek:
                                            Katma Değer Vergisi</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Kısa Kod</label>
                                    <div class="col">
                                        <input type="text" name="code"
                                            class="form-control  @error('code') is-invalid @enderror"
                                            value="{{ old('code') }}" placeholder="Kısa Kod">
                                        @error('code')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">Vergiye ait tanımlama kodunu giriniz. Örnek:
                                            KDV</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Vergi Oranı</label>
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="input-group-text">%</span>
                                            <input type="text" name="value"
                                                class="form-control @error('value') is-invalid @enderror"
                                                value="{{ old('value') }}" placeholder="Vergi Oranı">
                                        </div>
                                        @error('value')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">Vergi oranını giriniz. </small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">Açıklama</label>
                                    <div class="col">
                                        <input type="text" name="desc"
                                            class="form-control @error('desc') is-invalid @enderror"
                                            value="{{ old('desc') }}" placeholder="Açıklama">
                                        @error('desc')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">Vergi ile ilgili kısa açıklama</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">Vergi Bölgesi</label>
                                    <div class="col">
                                        <select class="form-select shadow-none @error('country_id') is-invalid @enderror"
                                            name="country_id">
                                            <option>Lütfen Seçiniz</option>
                                            @foreach ($countries as $key => $country)
                                                <option value="{{ $key }}">
                                                    {{ $country }}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">Vergi hangi ülkelerde geçerli.</small>
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
