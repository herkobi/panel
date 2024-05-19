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
                            <h1 class="card-title">Para Birimi Bilgilerini Düzenle</h1>
                        </div>
                        <form action="{{ route('panel.settings.currency.update', $currency->id) }}" method="POST">
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
                                                        {{ $currency->status->value == $type->value ? 'checked' : '' }}>
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
                                            value="{{ $currency->title ? $currency->title : old('title') }}"
                                            placeholder="Para Birimi Adı">
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
                                                    value="{{ $currency->symbol ? $currency->symbol : old('symbol') }}"
                                                    placeholder="Sembol">
                                                @error('symbol')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                                <small class="form-hint">Para birimine ait sembolü giriniz. Örnek:
                                                    Türk Lirasının sembolü: ₺</small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col col-form-label required">Sembol Konumu</label>
                                                <select name="symbol_location" class="form-select" id="symbolLocation">
                                                    <option value="left"
                                                        {{ 'left' === $currency->symbol_location ? 'selected' : '' }}>Solda
                                                    </option>
                                                    <option value="right"
                                                        {{ 'right' === $currency->symbol_location ? 'selected' : '' }}>
                                                        Sağda
                                                    </option>
                                                    <option value="left_space"
                                                        {{ 'left_space' === $currency->symbol_location ? 'selected' : '' }}>
                                                        Solda Boşlukla</option>
                                                    <option value="right_space"
                                                        {{ 'right_space' === $currency->symbol_location ? 'selected' : '' }}>
                                                        Sağda Boşlukla</option>
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
                                                    value="{{ $currency->thousand_sep ? $currency->thousand_sep : (old('thousand_sep') ? old('thousand_sep') : '.') }}"
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
                                                    value="{{ $currency->decimal_sep ? $currency->decimal_sep : (old('decimal_sep') ? old('decimal_sep') : ',') }}"
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
                                                    value="{{ $currency->decimal_number ? $currency->decimal_number : (old('decimal_number') ? old('decimal_number') : 2) }}"
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
                                                    value="{{ $currency->code ? $currency->code : old('code') }}"
                                                    placeholder="ISO Kodu" {{ config('panel.currency') != $currency->code ? '' : 'readonly' }}>
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
                                @if (config('panel.currency') != $currency->code)
                                    <div class="card-footer">
                                        <div class="btn-list">
                                            @hasrole('Super Admin')
                                                <a href="#" class="btn btn-outline-danger me-auto"
                                                    data-bs-toggle="modal" data-bs-target="#modal-danger">Sil</a>
                                            @endhasrole
                                            <button type="submit" class="btn btn-success">Güncelle</button>
                                        </div>
                                    </div>
                                @else
                                    <div class="card-footer text-end">
                                        <button type="submit" class="btn btn-success">Güncelle</button>
                                    </div>
                                @endif
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
            var dangerModal = new bootstrap.Modal(document.getElementById('modal-danger'), {})
            dangerModal.toggle()
        </script>
    @endif
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
                                <form action="{{ route('panel.settings.currency.destroy', $currency->id) }}"
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
@endsection
