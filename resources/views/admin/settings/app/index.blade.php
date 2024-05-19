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
                            <div class="text-secondary">İşleminizi gerçekleştirirken bir sorun oluştu, lütfen tekrar
                                deneyiniz.
                            </div>
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
            var successModal = new bootstrap.Modal(document.getElementById('modal-danger'), {})
            successModal.toggle()
        </script>
    @endif
    @if (Session::has('success'))
        <div class="modal modal-blur fade" id="modal-success" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close rounded-0 shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    <div class="modal-status bg-success"></div>
                    <div class="modal-body text-center py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-green icon-lg" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M9 12l2 2l4 -4" />
                        </svg>
                        <h3>Başarılı</h3>
                        <div class="text-secondary">{{ Session::get('success') }}</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100 text-center">
                            <button type="button" class="btn btn-success mx-auto" data-bs-dismiss="modal">
                                Kapat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="module">
            var successModal = new bootstrap.Modal(document.getElementById('modal-success'), {})
            successModal.toggle()
        </script>
    @endif
@endsection
