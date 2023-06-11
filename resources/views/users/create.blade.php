@extends('layouts.app')
@section('content')
@include('layouts.partials.page-title', ['title' => 'Yeni Kullanıcı Oluştur'])
<div class="page-content position-relative mb-4">
    <div class="row">
        <div class="col-md-6">
            <div class="card rounded-0 shadow-sm border-0 mb-3">
                <div class="card-header border-0 bg-white pt-3 pb-0">
                    <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                        <h4 class="card-title mb-0">Kullanıcı Bilgileri</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('panel.store.admin')}}" autocomplete="off">
                        @csrf
                        <div class="mb-2">
                            <div class="input-group">
                                <span class="input-group-text rounded-0 shadow-none bg-white">
                                    <i class="ri-user-line"></i>
                                </span>
                                <input type="text" id="name" placeholder="Ad Soyad" class="form-control border-start-0 rounded-0 shadow-none @error('name') is-invalid @enderror" name="name" required autocomplete="off" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-2">
                            <div class="input-group">
                                <span class="input-group-text rounded-0 shadow-none bg-white">
                                    <i class="ri-mail-check-line"></i>
                                </span>
                                <input type="email" id="emailaddress" placeholder="E-posta Adresiniz" class="form-control border-start-0 rounded-0 shadow-none @error('email') is-invalid @enderror" name="email" required autocomplete="off">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-2">
                            <button type="submit" class="btn btn-lg btn-primary w-100 rounded-0 shadow-none text-white">
                                <i class="ri-check-double-line"></i>
                                <span>Üyeyi Kaydet</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
