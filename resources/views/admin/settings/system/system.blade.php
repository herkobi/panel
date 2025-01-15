@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Ayarlar',
    ])
    @include('admin.settings.include.navigation')
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.settings.system.include.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="page-form">
                        <h3 class="form-title border-bottom mb-3 pb-3">Sistem Ayarları</h3>
                        <form action="{{ route('panel.settings.system.update') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-form-label col-lg-2 col-md-3 fw-medium">Tanımlamalar</label>
                                <div class="col-lg-10 col-md-9">
                                    <div class="row mb-3">
                                        <div class="col-lg-6 mb-1">
                                            <label for="language" class="col-form-label">Arayüz Dili</label>
                                            <select class="form-select" name="language">
                                                <option>Lütfen Seçiniz</option>
                                                @foreach ($languages as $language)
                                                    <option value="{{ $language->code }}"
                                                        {{ $language->code == Setting::get('language') ? 'selected' : '' }}>
                                                        {{ $language->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="form-hint small">Sistem genel arayüz dilini seçiniz</span>
                                            @error('language')
                                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 mb-1">
                                            <label for="location" class="col-form-label">Konum</label>
                                            <select id="location" class="form-select" name="location">
                                                <option>Lütfen Seçiniz</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->code }}"
                                                        {{ $country->code == Setting::get('location') ? 'selected' : '' }}>
                                                        {{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="form-hint small">Sistem içerisinde kullanılacak genel
                                                konumu belirtiniz</span>
                                            @error('location')
                                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-form-label col-lg-2 col-md-3 fw-medium">Tarih/Saat
                                    Ayarları</label>
                                <div class="col-lg-10 col-md-9">
                                    <div class="row mb-3">
                                        <div class="col-lg-12 mb-1">
                                            <label for="timezone" class="col-form-label">Zaman Dilimi</label>
                                            <select id="timezone" class="form-select" name="timezone">
                                                <option>Lütfen Seçiniz</option>
                                                @foreach (Helper::getTimeZoneList() as $timezone => $timezone_gmt_diff)
                                                    <option value="{{ $timezone }}"
                                                        {{ $timezone === old('timezone', Setting::get('timezone')) ? 'selected' : '' }}>
                                                        {{ $timezone_gmt_diff }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="form-hint small">Sistem genelinde kullanılacak zaman
                                                dilimini seçiniz</span>
                                            @error('timezone')
                                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="col-form-label border-bottom mb-1 d-block">Tarih
                                                Formatı</label>
                                            <span class="form-hint small d-block mb-3">Sistem genelinde kullanılacak
                                                tarih formatını seçiniz</span>
                                            <div class="col">
                                                @foreach (Helper::dateformats() as $format)
                                                    <label class="form-check">
                                                        <input type="radio" name="dateformat" class="form-check-input"
                                                            {{ $format == Setting::get('dateformat') ? 'checked' : '' }}
                                                            value="{{ $format }}">
                                                        <span
                                                            class="form-check-label">{{ Carbon::now()->format($format) }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-form-label border-bottom mb-1 d-block">Saat
                                                Formatı</label>
                                            <span class="form-hint small d-block mb-3">Sistem genelinde kullanılacak
                                                saat formatını seçiniz</span>
                                            <div class="col">
                                                @foreach (Helper::timeformats() as $format)
                                                    <label class="form-check">
                                                        <input type="radio" name="timeformat" class="form-check-input"
                                                            {{ $format == Setting::get('timeformat') ? 'checked' : '' }}
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
                            <div class="row mb-5">
                                <div class="col-lg-10 col-mg-9 offset-lg-2 offset-md-3">
                                    <button type="submit" class="btn rounded-1 px-5">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-floppy" viewBox="0 0 20 20">
                                            <path d="M11 2H9v3h2z"></path>
                                            <path
                                                d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z">
                                            </path>
                                        </svg>
                                        KAYDET
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
