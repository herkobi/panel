@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Para Birimleri',
                ])
                @include('admin.settings.currencies.partials.page-buttons', [
                    'first_button' => 'Para Birimleri',
                    'first_link' => 'panel.settings.currencies',
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
                            <h1 class="card-title">Yeni Para Birimi</h1>
                        </div>
                        <form action="{{ route('panel.settings.currency.create.store') }}" method="POST">
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
                                    <label class="col-3 col-form-label required">Para Birimi Adı</label>
                                    <div class="col">
                                        <input type="text" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}" placeholder="Para Birimi Adı">
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">Kullanacağınız para biriminin adını giriniz. Örnek:
                                            Türk Lirası</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">Bilgiler</label>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="col col-form-label required">Sembol</label>
                                                <input type="text" name="symbol"
                                                    class="form-control  @error('symbol') is-invalid @enderror"
                                                    value="{{ old('symbol') }}" placeholder="Sembol">
                                                @error('symbol')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Para birimine ait sembolü giriniz. Örnek:
                                                    Türk Lirasının sembolü: ₺</small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col col-form-label required">Sembol Konumu</label>
                                                <select name="symbol_location" class="form-select" id="symbolLocation">
                                                    <option value="left">Solda</option>
                                                    <option value="right">Sağda</option>
                                                    <option value="left_space">Solda Boşlukla</option>
                                                    <option value="right_space">Sağda Boşlukla</option>
                                                </select>
                                                @error('symbol_location')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Para birimine ait sembolün konumunu
                                                    belirtin.</small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="col col-form-label required">Binlik Ayırıcı</label>
                                                <input type="text" name="thousand_sep"
                                                    class="form-control @error('thousand_sep') is-invalid @enderror"
                                                    value="{{ old('thousand_sep') ? old('thousand_sep') : '.' }}"
                                                    placeholder="Binlik Ayırıcı">
                                                @error('thousand_sep')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Görüntülenen fiyatlarda binlik ayırıcı
                                                    ayarı</small>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="col col-form-label required">Ondalık Ayırıcı</label>
                                                <input type="text" name="decimal_sep"
                                                    class="form-control @error('decimal_sep') is-invalid @enderror"
                                                    value="{{ old('decimal_sep') ? old('decimal_sep') : ',' }}"
                                                    placeholder="Ondalık Ayırıcı">
                                                @error('decimal_sep')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Görüntülenen fiyatlarda ondalık ayırıcı
                                                    ayarı</small>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="col col-form-label required">Ondalık Sayısı</label>
                                                <input type="number" name="decimal_number" min="0" step="1"
                                                    class="form-control @error('decimal_number') is-invalid @enderror"
                                                    value="{{ old('decimal_number') ? old('decimal_number') : '2' }}"
                                                    placeholder="Ondalık Sayısı">
                                                @error('decimal_number')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Görüntülenen fiyatlarda ondalık nokta sayısını
                                                    belirler</small>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="col col-form-label required">ISO Kodu</label>
                                                <input type="text" name="code"
                                                    class="form-control @error('code') is-invalid @enderror"
                                                    value="{{ old('code') }}" placeholder="ISO Kodu">
                                                @error('code')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Para birimine ait ISO kodunu giriniz. ISO
                                                    kod listesine <a href="https://en.wikipedia.org/wiki/ISO_4217"
                                                        target="_blank" rel="noopener">bu adresten</a>
                                                    ulaşabilirsiniz.</small>
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
