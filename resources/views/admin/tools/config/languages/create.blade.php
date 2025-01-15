@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Araçlar',
    ])
    @include('admin.tools.include.navigation')
    <div class="page-content">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-3">
                    @include('admin.tools.config.include.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="page-form">
                        <h3 class="form-title border-bottom mb-3 pb-3">Yeni Dil</h3>
                        <form action="{{ route('panel.tools.config.language.store') }}" method="POST">
                            @csrf
                            <div class="row align-items-center mb-3">
                                <label class="col-lg-2 col-md-3 col-form-label">Durum</label>
                                <div class="col-lg-10 col-md-9">
                                    <div>
                                        @foreach (Status::cases() as $type)
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status"
                                                    value="{{ $type->value }}" {{ 1 == $type->value ? 'checked' : '' }}>
                                                <span class="form-check-label">{{ Status::getTitle($type->value) }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('status')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="name" class="col-form-label col-lg-2 col-md-3">Dil Adı</label>
                                <div class="col-lg-10 col-md-9">
                                    <div class="input-group">
                                        <div class="input-group-text rounded-0 border-end-0 bg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-flag" viewBox="0 0 16 16">
                                                <path
                                                    d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21 21 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21 21 0 0 0 14 7.655V1.222z">
                                                </path>
                                            </svg>
                                        </div>
                                        <input id="name" type="text" name="name"
                                            class="form-control rounded-0 border-start-0" placeholder="Dil Adını Giriniz"
                                            value="{{ old('name') }}" required>
                                    </div>
                                    <span class="form-hint small">Dil adını giriniz</span>
                                    @error('name')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-5">
                                <label class="col-form-label col-lg-2 col-md-3">Bilgiler</label>
                                <div class="col-lg-10 col-md-9">
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-1">
                                            <label class="col-form-label">Kısa Kod</label>
                                            <input type="text" name="code" class="form-control" placeholder="Kısa Kod"
                                                value="{{ old('code') }}" required>
                                            <span class="form-hint small">Dile ait kısa kodu giriniz</span>
                                            @error('code')
                                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-1">
                                            <label class="col-form-label">Bölgesel Kod</label>
                                            <input type="text" name="regional_code" class="form-control"
                                                placeholder="Bölgesel Kod" value="{{ old('regional_code') }}" required>
                                            <span class="form-hint small">Dile ait bölgesel kodu giriniz. Örnek
                                                en_US Amerikan İngilizcesi, en_GB İngiliz İngilizcesini belirtmek
                                                için kullanılır</span>
                                            @error('regional_code')
                                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-1">
                                            <label class="col-form-label">Karakter Seti</label>
                                            <input type="text" name="charset" class="form-control"
                                                placeholder="Karakter Seti" value="{{ old('charset') }}" required>
                                            <span class="form-hint small">Dile ait karakter setini giriniz. Örneğin
                                                Türkçe için utf-8</span>
                                            @error('charset')
                                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-1">
                                            <label class="col-form-label border-bottom mb-1 d-block">Yazı
                                                Yönü</label>
                                            <span class="form-hint small d-block mb-3">Yazı yönünü belirtiniz</span>
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
                                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
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
