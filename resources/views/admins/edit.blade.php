@extends('layouts.app')
@section('content')
@include('layouts.partials.page-title', ['title' => 'Kullanıcı Bilgilerini Düzenle'])
<div class="page-content position-relative mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card rounded-0 shadow-sm border-0 mb-3">
                <div class="card-header border-0 bg-white pt-3 pb-0">
                    <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                        <h4 class="card-title mb-0">Kullanıcı Bilgileri</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('panel.user.edit', $user->id)}}" autocomplete="off">
                        @csrf
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-2 fw-semibold mb-0" for="user-name">Ad Soyad</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <span class="input-group-text rounded-0 shadow-none bg-white">
                                            <i class="ri-user-line"></i>
                                        </span>
                                        <input type="text" id="user-name" placeholder="Ad Soyad" class="form-control border-start-0 rounded-0 shadow-none @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="off" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-2 fw-semibold mb-0" for="user-email">E-posta Adresi</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <span class="input-group-text rounded-0 shadow-none bg-white">
                                            <i class="ri-mail-check-line"></i>
                                        </span>
                                        <input type="email" id="user-email" placeholder="E-posta Adresi" class="form-control border-start-0 rounded-0 shadow-none @error('email') is-invalid @enderror" name="email" value="{{ $user->email ? old('email') : $user->email }}" required autocomplete="off">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="offset-md-2 col-md-4">
                                <button type="submit" class="btn btn-primary w-100 rounded-0 shadow-none text-white">
                                    <i class="ri-check-double-line"></i>
                                    <span>Üyeyi Kaydet</span>
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
