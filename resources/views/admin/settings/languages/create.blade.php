@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Para Birimleri',
                ])
                @include('admin.settings.languages.partials.page-buttons', [
                    'first_button' => 'Diller',
                    'first_link' => 'panel.settings.languages',
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
                            <h1 class="card-title">Yeni Dil Ekle</h1>
                        </div>
                        <form action="{{ route('panel.settings.language.create.store') }}" method="POST">
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
                                    <label class="col-3 col-form-label required">Yeni Dil Adı</label>
                                    <div class="col">
                                        <input type="text" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}" placeholder="Dil Adı">
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">Kullanacağınız dilin kendi dilindeki karşılığını
                                            giriniz</small>
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
                                        <small class="form-hint">Dil ile ilgili kısa açıklama</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Bilgiler</label>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="col-form-label required">Kısa Kod</label>
                                                <input type="text" name="code"
                                                    class="form-control  @error('code') is-invalid @enderror"
                                                    value="{{ old('code') }}" placeholder="Kısa Kod">
                                                @error('code')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Dile ait kısa kodu giriniz</small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label required">Bölgesel Kod</label>
                                                <input type="text" name="iso_code"
                                                    class="form-control @error('iso_code') is-invalid @enderror"
                                                    value="{{ old('iso_code') }}" placeholder="Bölgesel Kod">
                                                @error('iso_code')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Dile ait bölgesel kodu giriniz. Örnek en_US
                                                    Amerikan
                                                    İngilizcesi, en_GB İngiliz İngilizcesini belirtmek için kullanılır.
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="col-form-label required">Yazı Yönü</label>
                                                <div>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="direction"
                                                            value="ltr" checked>
                                                        <span class="form-check-label">LTR (Soldan Sağa)</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="direction"
                                                            value="rtl">
                                                        <span class="form-check-label">RTL (Sağdan Sola)</span>
                                                    </label>
                                                </div>
                                                @error('direction')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Dile ait bölgesel kodu giriniz. Örnek en_US
                                                    Amerikan İngilizcesi, en_GB İngiliz İngilizcesini belirtmek için
                                                    kullanılır.
                                                </small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label required">Karakter Seti</label>
                                                <input type="text" name="charset"
                                                    class="form-control @error('charset') is-invalid @enderror"
                                                    value="{{ old('charset') ? old('charset') : 'utf-8' }}"
                                                    placeholder="Karakter Seti">
                                                @error('charset')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Dile ait karakter setini giriniz. Örneğin
                                                    Türkçe için utf-8</small>
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
