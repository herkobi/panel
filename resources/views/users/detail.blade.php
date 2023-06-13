@extends('layouts.app')
@section('content')
@include('layouts.partials.page-title', ['title' => 'Kullanıcı Bilgileri'])
<div class="page-content position-relative mb-4">
    <div class="row">
        <div class="col-md-8">
            <ul class="nav nav-underline">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Kullanıcı İşlemleri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Yetkiler ve İzinler</a>
                </li>
            </ul>
        </div>
        <div class="col-md-4">
            <div class="card rounded-0 shadow-sm border-0 mb-3">
                <div class="card-header border-0 bg-white pt-3 pb-0">
                    <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                        <h4 class="card-title mb-0">Genel Bilgiler</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3 border-bottom pb-3">
                        <div class="row">
                            <label class="form-label col-md-5 fw-semibold mb-0" for="user-status">Durum</label>
                            <div class="col-md-7">{{$user->status->title()}}</div>
                        </div>
                    </div>
                    <div class="mb-3 border-bottom pb-3">
                        <div class="row">
                            <label class="form-label col-md-5 fw-semibold mb-0" for="user-name">Ad Soyad</label>
                            <div class="col-md-7">{{$user->name}}</div>
                        </div>
                    </div>
                    <div class="mb-3 border-bottom pb-3">
                        <div class="row">
                            <label class="form-label col-md-5 fw-semibold mb-0" for="user-email">E-posta Adresi</label>
                            <div class="col-md-7">{{$user->email}}</div>
                        </div>
                    </div>
                    <div class="mb-3 border-bottom pb-3">
                        <div class="row">
                            <label class="form-label col-md-5 fw-semibold mb-0" for="user-roles">Tanımlı Yetkiler</label>
                            <div id="user-roles" class="col-md-7">
                                <ul class="list-unstyled list-inline mb-0">
                                @foreach ($user->roles as $role)
                                    <li>{{ $role->name }}</li>
                                @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 border-bottom pb-3">
                        <div class="row">
                            <label class="form-label col-md-5 fw-semibold mb-0" for="user-permissions">Özel İzinler</label>
                            <div id="user-permissions" class="col-md-7">
                                <ul class="list-unstyled list-inline mb-0">
                                @foreach ($user->permissions as $permission)
                                    <li>
                                        <span class="d-block fw-semibold">{{$permission->group->name}}</span>
                                        {{$permission->text}}
                                    </li>
                                @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 border-bottom pb-3">
                        <div class="row">
                            <label class="form-label col-md-5 fw-semibold mb-0" for="user-membership">Üyelik Tarihi</label>
                            <div class="col-md-7">{{$user->created_at}}</div>
                        </div>
                    </div>
                    <div class="mb-3 border-bottom pb-3">
                        <div class="row">
                            <label class="form-label col-md-5 fw-semibold mb-0" for="user-lastloginat">Son Oturum Tarihi</label>
                            <div class="col-md-7">{{$user->last_login_at}}</div>
                        </div>
                    </div>
                    <div class="mb-3 border-bottom pb-3">
                        <div class="row">
                            <label class="form-label col-md-5 fw-semibold mb-0" for="user-lastloginip">Son Oturum IP</label>
                            <div class="col-md-7">{{$user->last_login_ip}}</div>
                        </div>
                    </div>
                    <div class="mb-3 border-bottom pb-3">
                        <div class="row">
                            <label class="form-label col-md-5 fw-semibold mb-0" for="user-createdbyname">Kayıt Eden</label>
                            <div class="col-md-7">{{$user->created_by_name}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card rounded-0 shadow-sm border-0 mb-3">
                <div class="card-header border-0 bg-white pt-3 pb-0">
                    <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                        <h4 class="card-title mb-0">Kullanıcı İşlemleri</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3 border-bottom pb-3">
                        <div class="row">
                            <label class="form-label col-md-5 fw-semibold mb-0" for="user-status">Durum</label>
                            <div class="col-md-7">Şifre Yenileme Linki Gönder</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
