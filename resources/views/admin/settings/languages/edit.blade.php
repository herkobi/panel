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
                    'second_button' => 'Yeni Dil Ekle',
                    'second_link' => 'panel.settings.language.create',
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
                            <h1 class="card-title">{{ $language->title }} Dili Bilgilerini Düzenle</h1>
                        </div>
                        <form action="{{ route('panel.settings.language.update', $language->id) }}" method="POST">
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
                                                        {{ $language->status->value == $type->value ? 'checked' : '' }}>
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
                                            value="{{ $language->title ? $language->title : old('title') }}"
                                            placeholder="Dil Adı">
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
                                            value="{{ $language->desc ? $language->desc : old('desc') }}"
                                            placeholder="Açıklama">
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
                                                    value="{{ $language->code ? $language->code : old('code') }}"
                                                    placeholder="Kısa Kod">
                                                @error('code')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Dile ait kısa kodu giriniz</small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label required">Bölgesel Kod</label>
                                                <input type="text" name="iso_code"
                                                    class="form-control @error('iso_code') is-invalid @enderror"
                                                    value="{{ $language->iso_code ? $language->iso_code : old('iso_code') }}"
                                                    placeholder="Bölgesel Kod">
                                                @error('iso_code')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Dile ait bölgesel kodu giriniz. Örnek en_US
                                                    Amerikan İngilizcesi, en_GB İngiliz İngilizcesini belirtmek için
                                                    kullanılır.
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="col-form-label required">Yazı Yönü</label>
                                                <div>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="direction"
                                                            value="ltr"
                                                            {{ 'ltr' == $language->direction ? 'checked' : '' }}>
                                                        <span class="form-check-label">LTR (Soldan Sağa)</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="direction"
                                                            value="rtl"
                                                            {{ 'rtl' == $language->direction ? 'checked' : '' }}>
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
                                                    value="{{ $language->charset ? $language->charset : (old('charset') ? old('charset') : 'utf-8') }}"
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
                            @if (config('panel.language') != $language->code)
                                <div class="card-footer">
                                    <div class="btn-list">
                                        @if (auth()->user()->can('language.update'))
                                            <a href="#" class="btn btn-outline-danger me-auto"
                                                data-bs-toggle="modal" data-bs-target="#modal-danger">Sil</a>
                                        @endif
                                        <button type="submit" class="btn btn-success">Güncelle</button>
                                    </div>
                                </div>
                            @else
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-success">Güncelle</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (auth()->user()->can('language.update'))
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
                                    <form action="{{ route('panel.settings.language.destroy', $language->id) }}"
                                        method="POST">
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
    @endif
@endsection
