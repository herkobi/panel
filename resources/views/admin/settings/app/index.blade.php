@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Uygulama Ayarları',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.settings.partials.navigation')
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Uygulama Ayarları</h3>
                        </div>
                        <form method="POST" action="{{ route('panel.settings.update.app') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row mb-3">
                                    <label class="col-3 col-form-label required">Uygulama Adı</label>
                                    <div class="col">
                                        <input type="text" name="title" class="form-control" aria-describedby="appName"
                                            placeholder="Uygulama Adını Giriniz"
                                            value="{{ config('panel.title') ? config('panel.title') : old('title') }}">
                                        <small class="form-hint">Sayfa başlığında ve diğer alanlarda görülecek adı
                                            giriniz.</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-3 col-form-label required">Slogan</label>
                                    <div class="col">
                                        <input type="text" name="slogan" class="form-control" placeholder="Slogan"
                                            value="{{ config('panel.slogan') ? config('panel.slogan') : old('slogan') }}">
                                        <small class="form-hint">Varsa uygulama sloganınızı giriniz.</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-3 col-form-label required">E-posta Adresi</label>
                                    <div class="col">
                                        <input type="text" name="email" class="form-control"
                                            aria-describedby="appEmail" placeholder="E-posta Adresi"
                                            value="{{ config('panel.email') ? config('panel.email') : old('email') }}">
                                        <small class="form-hint">Sistem üzerinden gönderilecek bildirimlerin gideceği
                                            e-posta adresi.</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-3 col-form-label">Logo</label>
                                    <div class="col">
                                        <input type="file" name="logo" class="form-control mb-2">
                                        <div class="d-block">
                                            <img id='preview_logo' class="img-fluid w-50" src="{{ $logo }}"
                                                alt="Herkobi Logo" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-3 col-form-label">Favicon</label>
                                    <div class="col">
                                        <input type="file" name="favicon" class="form-control mb-2">
                                        <div class="d-block">
                                            <img id='preview_favicon' class="img-fluid" src="{{ $favicon }}"
                                                alt="Herkobi Favicon" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" id="updateButton" class="btn btn-primary">Güncelle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
