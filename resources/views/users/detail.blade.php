@extends('layouts.app')
@section('content')
@include('layouts.partials.page-title', ['title' => 'Kullanıcı Bilgileri'])
<div class="page-content position-relative mb-4">
    <div class="row">
        <div class="col-md-8">
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
                            <label class="form-label col-md-5 fw-semibold mb-0" for="user-name">Ad Soyad</label>
                            <div class="col-md-7">{{$user->name}}</div>
                        </div>
                    </div>
                    <div class="mb-3 border-bottom pb-3">
                        <div class="row">
                            <label class="form-label col-md-5 fw-semibold mb-0" for="user-name">E-posta Adresi</label>
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
                            <label class="form-label col-md-5 fw-semibold mb-0" for="user-membership">Son Oturum Tarihi</label>
                            <div class="col-md-7">{{$user->last_login_at}}</div>
                        </div>
                    </div>
                    <div class="mb-3 border-bottom pb-3">
                        <div class="row">
                            <label class="form-label col-md-5 fw-semibold mb-0" for="user-membership">Son Oturum IP</label>
                            <div class="col-md-7">{{$user->last_login_ip}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">

        </div>
    </div>
</div>
@endsection
