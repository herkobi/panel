@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Hesap Bilgileri',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-md-3 border-end">
                        <div class="card-body">
                            <h4 class="subheader">Profil Bilgileri</h4>
                            <div class="list-group list-group-transparent">
                                @include('admin.profile.partials.navigation')
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body px-5">
                            <h2 class="profile-section-title border-bottom fw-normal pb-3 mb-5">Hesap Bilgileri</h2>
                            <form action="" method="post" class="form">
                                @csrf
                                <div class="row mb-3">
                                    <label class="col-3 col-form-label">Tanımlamalar</label>
                                    <div class="col">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="col-3 col-form-label required">Arayüz Dili</label>
                                                <div class="col">
                                                    <select class="form-select" name="language">
                                                        <option>Lütfen Seçiniz</option>
                                                        @foreach ($languages as $language)
                                                            <option value="{{ $language->code }}"
                                                                {{ $language->code == config('panel.language') ? 'selected' : '' }}>
                                                                {{ $language->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <small class="form-hint">Sistem genel arayüz dilini seçiniz</small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label required">Konum</label>
                                                <div class="col">
                                                    <select class="form-select" name="location">
                                                        <option>Lütfen Seçiniz</option>
                                                        @foreach ($locations as $location)
                                                            <option value="{{ $location->code }}"
                                                                {{ $location->code == config('panel.location') ? 'selected' : '' }}>
                                                                {{ $location->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <small class="form-hint">Sistem içerisinde kullanılacak genel konumu
                                                    belirtiniz</small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="col-3 col-form-label required">Para Birimi</label>
                                                <div class="col">
                                                    <select class="form-select" name="currency">
                                                        <option>Lütfen Seçiniz</option>
                                                        @foreach ($currencies as $currency)
                                                            <option value="{{ $currency->code }}"
                                                                {{ $currency->code == config('panel.currency') ? 'selected' : '' }}>
                                                                {{ $currency->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <small class="form-hint">Sistem genelinde kullanılacak para birimini
                                                    seçiniz</small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label required">Vergi Oranı</label>
                                                <div class="col">
                                                    <select class="form-select" name="tax">
                                                        <option>Lütfen Seçiniz</option>
                                                        @foreach ($taxes as $tax)
                                                            <option value="{{ $tax->code }}"
                                                                {{ $tax->code == config('panel.tax') ? 'selected' : '' }}>
                                                                {{ $tax->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <small class="form-hint">Sistem genelinde kullanılacak vergi bilgisini
                                                    seçiniz</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">Tarih/Saat Ayarları</label>
                                    <div class="col">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label class="col-form-label required">Zaman Dilimi</label>
                                                <div class="col">
                                                    <select class="form-select" name="timezone">
                                                        <option>Lütfen Seçiniz</option>
                                                        @foreach (Helper::getTimeZoneList() as $timezone => $timezone_gmt_diff)
                                                            <option value="{{ $timezone }}"
                                                                {{ $timezone === old('timezone', config('panel.timezone')) ? 'selected' : '' }}>
                                                                {{ $timezone_gmt_diff }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <small class="form-hint">Sistem genelinde kullanılacak zaman dilimini
                                                    seçiniz</small>
                                            </div>
                                        </div>
                                        <div class="row g-4 mb-3">
                                            <div class="col-md-6">
                                                <label class="col-form-label border-bottom mb-2 required">Tarih
                                                    Formatı</label>
                                                <small class="form-hint mb-2">Sistem genelinde kullanılacak tarih formatını
                                                    seçiniz</small>
                                                <div class="col">
                                                    @foreach (Helper::dateformats() as $format)
                                                        <label class="form-check">
                                                            <input type="radio" name="dateformat" class="form-check-input"
                                                                {{ $format == config('panel.dateformat') ? 'checked' : '' }}
                                                                value="{{ $format }}">
                                                            <span
                                                                class="form-check-label">{{ Carbon::now()->format($format) }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label border-bottom mb-2 required">Saat
                                                    Formatı</label>
                                                <small class="form-hint mb-2">Sistem genelinde kullanılacak saat formatını
                                                    seçiniz</small>
                                                <div class="col">
                                                    @foreach (Helper::timeformats() as $format)
                                                        <label class="form-check">
                                                            <input type="radio" name="timeformat" class="form-check-input"
                                                                {{ $format == config('panel.timeformat') ? 'checked' : '' }}
                                                                value="{{ $format }}">
                                                            <span
                                                                class="form-check-label">{{ Carbon::now()->format($format) }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
