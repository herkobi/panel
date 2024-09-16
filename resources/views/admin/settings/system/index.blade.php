@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Ayarlar',
    ])
    <div class="page-content flex-grow-1 d-flex flex-column shadow-sm">
        <div class="row flex-grow-1">
            <div class="col-20 col-lg-3 col-md-3">
                <div class="page-menu rounded-2">
                    @include('admin.settings.include.navigation')
                </div>
            </div>
            <div class="col-80 col-lg-9 col-md-9">
                <div class="card h-100 border-0 mb-5">
                    <div class="card-header border-0 bg-white p-0 mb-3">
                        <div class="d-flex align-items-center justify-content-between w-100 border-bottom pb-2">
                            <h1 class="card-title">Genel Ayarlar</h1>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('panel.settings.general.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-9 col-md-8">
                                    <div class="row mb-3">
                                        <label class="col-lg-2 col-md-3 col-form-label required">Uygulama Adı</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="title"
                                                class="form-control @error('title') is-invalid @enderror"
                                                aria-describedby="appName" placeholder="Uygulama Adını Giriniz"
                                                value="{{ old('title', Setting::get('title')) }}">
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                            <small class="form-hint">Sayfa başlığında ve diğer alanlarda görülecek adı
                                                giriniz.</small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-2 col-md-3 col-form-label required">Slogan</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="slogan"
                                                class="form-control @error('slogan') is-invalid @enderror"
                                                placeholder="Slogan" value="{{ old('slogan', Setting::get('slogan')) }}">
                                            @error('slogan')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                            <small class="form-hint">Varsa uygulama sloganınızı giriniz.</small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-2 col-md-3 col-form-label required">E-posta Adresi</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                aria-describedby="appEmail" placeholder="E-posta Adresi"
                                                value="{{ old('email', Setting::get('email')) }}">
                                            @error('slogan')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                            <small class="form-hint">Sistem üzerinden gönderilecek bildirimlerin
                                                gideceği
                                                e-posta adresi.</small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-2 col-md-3 col-form-label">Logo</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="file" name="logo"
                                                class="form-control mb-2 @error('logo') is-invalid @enderror">
                                            @error('logo')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                            <div class="d-block">
                                                <img id='preview_logo'
                                                    src="{{ !empty(Setting::get('logo')) ? Setting::getFullPath('logo') : asset('herkobi-favicon.png') }}"
                                                    alt="Herkobi Logo" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <label class="col-lg-2 col-md-3 col-form-label">Favicon</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="file" name="favicon"
                                                class="form-control mb-2 @error('favicon') is-invalid @enderror">
                                            @error('favicon')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                            <div class="d-block">
                                                <img id='preview_favicon'
                                                    src="{{ !empty(Setting::get('favicon')) ? Setting::getFullPath('favicon') : asset('herkobi-favicon.png') }}"
                                                    alt="Herkobi Favicon" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-10 offset-lg-2 col-md-9 offset-md-3">
                                            <button type="submit" id="updateButton"
                                                class="btn btn-primary">Güncelle</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
