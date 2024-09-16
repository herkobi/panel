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
                    <div class="card-body">
                        <div class="row">
                            <form method="POST" action="{{ route('panel.settings.general.update') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-lg-9 col-md-8">
                                    <div class="row mb-3">
                                        <label class="col-lg-2 col-md-3 col-form-label required">Uygulama Adı</label>
                                        <div class="col-lg-10 col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0 pe-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-h-1">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M19 18v-8l-2 2" />
                                                        <path d="M4 6v12" />
                                                        <path d="M12 6v12" />
                                                        <path d="M11 18h2" />
                                                        <path d="M3 18h2" />
                                                        <path d="M4 12h8" />
                                                        <path d="M3 6h2" />
                                                        <path d="M11 6h2" />
                                                    </svg>
                                                </span>
                                                <input type="text" name="title"
                                                    class="form-control border-start-0 @error('title') is-invalid @enderror"
                                                    aria-describedby="appName" placeholder="Uygulama Adını Giriniz"
                                                    value="{{ old('title', Setting::get('title')) }}" required>
                                            </div>
                                            <small class="form-hint">Sayfa başlığında ve diğer alanlarda görülecek adı
                                                giriniz.</small>
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-2 col-md-3 col-form-label required">Slogan</label>
                                        <div class="col-lg-10 col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0 pe-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-quote">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M10 11h-4a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1h3a1 1 0 0 1 1 1v6c0 2.667 -1.333 4.333 -4 5" />
                                                        <path
                                                            d="M19 11h-4a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1h3a1 1 0 0 1 1 1v6c0 2.667 -1.333 4.333 -4 5" />
                                                    </svg>
                                                </span>
                                                <input type="text" name="slogan"
                                                    class="form-control border-start-0 @error('slogan') is-invalid @enderror"
                                                    placeholder="Slogan"
                                                    value="{{ old('slogan', Setting::get('slogan')) }}">
                                            </div>
                                            <small class="form-hint">Varsa uygulama sloganınızı giriniz.</small>
                                            @error('slogan')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-2 col-md-3 col-form-label required">E-posta Adresi</label>
                                        <div class="col-lg-10 col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0 pe-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-mail-forward">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M12 18h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5" />
                                                        <path d="M3 6l9 6l9 -6" />
                                                        <path d="M15 18h6" />
                                                        <path d="M18 15l3 3l-3 3" />
                                                    </svg>
                                                </span>
                                                <input type="text" name="email"
                                                    class="form-control border-start-0 @error('email') is-invalid @enderror"
                                                    aria-describedby="appEmail" placeholder="E-posta Adresi"
                                                    value="{{ old('email', Setting::get('email')) }}" required>
                                            </div>
                                            <small class="form-hint">Sistem üzerindeki bildirimlerin
                                                gönderileceği e-posta adresi.</small>
                                            @error('slogan')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
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
                            </form>
                            <div class="col-lg-3 col-md-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
