@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => 'Profil Bilgileri'])
    <div class="page-content position-relative mb-4">
        <div class="row">
            <div class="col-md-8">
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updateProfileInformation()))
                    <div class="card rounded-0 shadow-sm border-0 mb-3">
                        <div class="card-header border-0 bg-white pt-3 pb-3">
                            <h4 class="card-title mb-0">Kişisel Bilgiler</h4>
                        </div>
                        <div class="card-body">
                            @if (session('status') == 'profile-information-updated')
                                <div class="alert alert-success alert-dismissible fade show rounded-0 shadow-none"
                                    role="alert">
                                    <strong>Başarılı</strong> Bilgileriniz güncellendi
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ route('user-profile-information.update') }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="user-name" class="col-md-4 fw-semibold align-self-center">Ad
                                            Soyad</label>
                                        <div class="col-md-8">
                                            <input id="user-name" type="text"
                                                class="form-control form-control-sm rounded-0 shadow-none" name="name"
                                                value="{{ old('name', $user->name) }}" placeholder="Ad Soyad" required
                                                autofocus>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="user-email" class="col-md-4 fw-semibold align-self-center">E-posta
                                            Adresi</label>
                                        <div class="col-md-8">
                                            <input id="user-email" type="email"
                                                class="form-control form-control-sm rounded-0 shadow-none" name="email"
                                                value="{{ old('email', $user->email) }}" placeholder="E-posta Adresi"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="offset-md-4 col-md-5">
                                            <button type="submit"
                                                class="btn add-btn btn-primary btn-sm rounded-0 shadow-none"><i
                                                    class="ri-pencil-line"></i> Güncelle</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div class="card rounded-0 shadow-sm border-0 mb-3">
                        <div class="card-header border-0 bg-white pt-3 pb-3">
                            <h4 class="card-title mb-0">Şifrenizi Değiştiriniz</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user-password.update') }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="current-password"
                                            class="col-md-4 fw-semibold align-self-center">Kullandığınız Şifreniz</label>
                                        <div class="col-md-8">
                                            <input id="current-password" type="text"
                                                class="form-control form-control-sm rounded-0 shadow-none"
                                                name="current_password" placeholder="Kullandığınız Şifreniz" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="password" class="col-md-4 fw-semibold align-self-center">Yeni
                                            Şifreniz</label>
                                        <div class="col-md-8">
                                            <input id="password" type="text"
                                                class="form-control form-control-sm rounded-0 shadow-none" name="password"
                                                placeholder="Şifreniz" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="password_confirm" class="col-md-4 fw-semibold align-self-center">Yeni
                                            Şifreniz Tekrar</label>
                                        <div class="col-md-8">
                                            <input id="password_confirm" type="text"
                                                class="form-control form-control-sm rounded-0 shadow-none"
                                                name="password_confirmation" placeholder="Şifreniz Tekrar" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="offset-md-4 col-md-5">
                                            <button type="submit"
                                                class="btn add-btn btn-primary btn-sm rounded-0 shadow-none"><i
                                                    class="ri-pencil-line"></i> Güncelle</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
