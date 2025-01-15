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
                        <h3 class="form-title border-bottom mb-3 pb-3">Genel Ayarlar</h3>
                        <form action="{{ route('panel.settings.general.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="title" class="col-form-label col-lg-2 col-md-3 fw-medium">Uygulama
                                    Adı</label>
                                <div class="col-lg-10 col-md-9">
                                    <div class="input-group">
                                        <div class="input-group-text border-end-0 rounded-0 bg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-fonts" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.258 3h-8.51l-.083 2.46h.479c.26-1.544.758-1.783 2.693-1.845l.424-.013v7.827c0 .663-.144.82-1.3.923v.52h4.082v-.52c-1.162-.103-1.306-.26-1.306-.923V3.602l.431.013c1.934.062 2.434.301 2.693 1.846h.479z">
                                                </path>
                                            </svg>
                                        </div>
                                        <input id="title" type="text" name="title"
                                            class="form-control rounded-0 border-start-0"
                                            placeholder="Uygulama Adını Giriniz"
                                            value="{{ old('title', Setting::get('title')) }}" required>
                                    </div>
                                    <span class="form-hint small">Sayfa başlığında ve diğer alanlarda görülecek adı
                                        giriniz.</span>
                                    @error('title')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label id="slogan" class="col-form-label col-lg-2 col-md-3 fw-medium">Slogan</label>
                                <div class="col-lg-10 col-md-9">
                                    <div class="input-group">
                                        <div class="input-group-text border-end-0 rounded-0 bg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-hash" viewBox="0 0 16 16">
                                                <path
                                                    d="M8.39 12.648a1 1 0 0 0-.015.18c0 .305.21.508.5.508.266 0 .492-.172.555-.477l.554-2.703h1.204c.421 0 .617-.234.617-.547 0-.312-.188-.53-.617-.53h-.985l.516-2.524h1.265c.43 0 .618-.227.618-.547 0-.313-.188-.524-.618-.524h-1.046l.476-2.304a1 1 0 0 0 .016-.164.51.51 0 0 0-.516-.516.54.54 0 0 0-.539.43l-.523 2.554H7.617l.477-2.304c.008-.04.015-.118.015-.164a.51.51 0 0 0-.523-.516.54.54 0 0 0-.531.43L6.53 5.484H5.414c-.43 0-.617.22-.617.532s.187.539.617.539h.906l-.515 2.523H4.609c-.421 0-.609.219-.609.531s.188.547.61.547h.976l-.516 2.492c-.008.04-.015.125-.015.18 0 .305.21.508.5.508.265 0 .492-.172.554-.477l.555-2.703h2.242zm-1-6.109h2.266l-.515 2.563H6.859l.532-2.563z">
                                                </path>
                                            </svg>
                                        </div>
                                        <input id="slogan" type="text" name="slogan"
                                            class="form-control rounded-0 border-start-0" placeholder="Slogan"
                                            value="{{ old('slogan', Setting::get('slogan')) }}" required>
                                    </div>
                                    <span class="form-hint small">Varsa uygulama sloganınızı giriniz.</span>
                                    @error('slogan')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-form-label col-lg-2 col-md-3 fw-medium">E-posta Adresi</label>
                                <div class="col-lg-10 col-md-9">
                                    <div class="input-group">
                                        <div class="input-group-text border-end-0 rounded-0 bg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                                <path
                                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z">
                                                </path>
                                            </svg>
                                        </div>
                                        <input id="email" type="text" name="email"
                                            class="form-control rounded-0 border-start-0" placeholder="E-posta Adresi"
                                            value="{{ old('email', Setting::get('email')) }}" required>
                                    </div>
                                    <span class="form-hint small">Sistem üzerinden gönderilecek bildirimlerin
                                        gideceği e-posta adresini giriniz</span>
                                    @error('email')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-form-label col-lg-2 col-md-3 fw-medium">Logo</label>
                                <div class="col-lg-10 col-md-9">
                                    <input type="file" name="logo" class="form-control mb-2"
                                        value="{{ old('logo', Setting::get('logo')) }}">
                                    <span class="form-hint small">Sistem genelinde kullanılacak logoyu yükleyiniz</span>
                                    <div class="d-block">
                                        <img id="preview_logo" class="img-fluid w-50"
                                            src="{{ Setting::getFullPath('logo') }}" alt="{{ Setting::get('title') }}">
                                    </div>
                                    @error('logo')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-5">
                                <label class="col-form-label col-lg-2 col-md-3 fw-medium">Favicon</label>
                                <div class="col-lg-10 col-md-9">
                                    <input type="file" name="favicon" class="form-control mb-2"
                                        value="{{ old('favicon', Setting::get('favicon')) }}">
                                    <span class="form-hint small">Sistem genelinde kullanılacak faviconu yükleyiniz</span>
                                    <div class="d-block">
                                        <img id="preview_favicon" class="img-fluid"
                                            src="{{ Setting::getFullPath('favicon') }}" alt="{{ Setting::get('title') }}">
                                    </div>
                                    @error('favicon')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
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
