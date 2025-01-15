@extends('layouts.auth')
@section('content')
    <div class="auth-form">
        <div class="card shadow-sm">
            <div class="card-body p-3">
                <div class="mb-4">
                    <img src="{{ Setting::getFullPath('logo') }}" alt="{{ Setting::get('title') }}" class="img-fluid">
                </div>
                <h2 class="form-title position-relative pb-3">İki Faktörlü Doğrulama</h2>
                <p class="text-muted mb-3">Lütfen 2 faktörlü doğrulama kodunu ya da gizli anahtarlarınızdan birini
                    giriniz.</p>
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible mb-3" role="alert">
                        <div class="d-flex">
                            <div class="me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                    <path
                                        d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                </svg>
                            </div>
                            <div>
                                {{ session('status') }}
                            </div>
                        </div>
                        <a class="btn-close pointer" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif
                <form action="/two-factor-challenge" method="POST" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-code-square" viewBox="0 0 16 16">
                                    <path
                                        d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                    <path
                                        d="M6.854 4.646a.5.5 0 0 1 0 .708L4.207 8l2.647 2.646a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708 0m2.292 0a.5.5 0 0 0 0 .708L11.793 8l-2.647 2.646a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708 0" />
                                </svg>
                            </span>
                            <input type="text" name="code" class="form-control" placeholder="Doğrulama Kodu"
                                autocomplete="off">
                        </div>
                        <span class="form-hint">Lütfen güvenlik kodunu giriniz</span>
                        @error('code')
                            <div class="invalid-feedback" role="alert">{{ $code }}</div>
                        @enderror
                    </div>
                    <div class="hr-text">YA DA</div>
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-braces-asterisk" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1.114 8.063V7.9c1.005-.102 1.497-.615 1.497-1.6V4.503c0-1.094.39-1.538 1.354-1.538h.273V2h-.376C2.25 2 1.49 2.759 1.49 4.352v1.524c0 1.094-.376 1.456-1.49 1.456v1.299c1.114 0 1.49.362 1.49 1.456v1.524c0 1.593.759 2.352 2.372 2.352h.376v-.964h-.273c-.964 0-1.354-.444-1.354-1.538V9.663c0-.984-.492-1.497-1.497-1.6M14.886 7.9v.164c-1.005.103-1.497.616-1.497 1.6v1.798c0 1.094-.39 1.538-1.354 1.538h-.273v.964h.376c1.613 0 2.372-.759 2.372-2.352v-1.524c0-1.094.376-1.456 1.49-1.456v-1.3c-1.114 0-1.49-.362-1.49-1.456V4.352C14.51 2.759 13.75 2 12.138 2h-.376v.964h.273c.964 0 1.354.444 1.354 1.538V6.3c0 .984.492 1.497 1.497 1.6M7.5 11.5V9.207l-1.621 1.621-.707-.707L6.792 8.5H4.5v-1h2.293L5.172 5.879l.707-.707L7.5 6.792V4.5h1v2.293l1.621-1.621.707.707L9.208 7.5H11.5v1H9.207l1.621 1.621-.707.707L8.5 9.208V11.5z" />
                                </svg>
                            </span>
                            <input type="text" name="recovery_code" class="form-control" placeholder="Gizli Anahtar"
                                autocomplete="off">
                        </div>
                        <span class="form-hint">Eğer güvenlik anahtarınıza erişemiyorsanız Kurtarma Kodlarından birini
                            girerekte oturum açabilirsiniz.</span>
                        @error('recovery_code')
                            <div class="invalid-feedback" role="alert">{{ $recovery_code }}</div>
                        @enderror
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-check2-square" viewBox="0 0 16 16">
                                <path
                                    d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z" />
                                <path
                                    d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0" />
                            </svg>
                            İşlemi Onayla
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
