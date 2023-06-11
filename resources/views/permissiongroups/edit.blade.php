@extends('layouts.app')
@section('content')
@include('layouts.partials.page-title', ['title' => 'İzin Grupları'])
<div class="page-content position-relative mb-4">
    <div class="row">
        <div class="col-md-5">
            <div class="card rounded-0 shadow-sm border-0 mb-3">
                <div class="card-header border-0 bg-white pt-3 pb-3">
                    <h4 class="card-title mb-0">Grup Ekle</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('panel.permission.group.update', $permissiongroup->id) }}" method="post">
                        @csrf
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-4 fw-semibold" for="permission-group-name">Grup Adı</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control rounded-0 shadow-none form-control-sm" id="permission-group-name" name="name" value="{{ $permissiongroup->name ? $permissiongroup->name : old('name') }}" placeholder="Grup Adı Örnek Rol Yönetimi, Kullanıcı Yönetimi" required autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-4 fw-semibold mb-0" for="permission-group-type">Kullanıcı Türü</label>
                                <div class="col-md-8">
                                    <div class="row">
                                        @foreach (\App\Enums\UserType::cases() as $type)
                                        <div class="col-md-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input rounded-0 shadow-none" type="radio" id="permission-group-type-user" {{ $permissiongroup->type->value == $type->value ? 'checked' : 0 }} disabled>
                                                <label class="form-check-label rounded-0 shadow-none" for="permission-group-type-user">{{ \App\Enums\UserType::getTitle($type->value) }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-4 fw-semibold" for="permission-group-name">Grup Açıklaması</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control rounded-0 shadow-none form-control-sm" id="permission-group-name" name="desc" value="{{ $permissiongroup->desc ? $permissiongroup->desc : old('desc') }}" placeholder="Grup İle İlgili Kısa Açıklama" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="offset-md-4 col-md-8">
                                    <div class="d-flex align-items-center justify-content-between w-100">
                                        <button type="submit" class="btn add-btn btn-primary btn-sm rounded-0 shadow-none"><i class="ri-add-line"></i> Güncelle</button>
                                        @hasrole('Super Admin')
                                        <button type="button" class="btn add-btn btn-danger btn-sm rounded-0 shadow-none" onclick="event.preventDefault(); document.getElementById('destroy-form').submit();"><i class="ri-delete-bin-2-line"></i> {{ __('Grubu Sil') }}</button>
                                        @endhasrole
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('panel.permission.group.destroy', $permissiongroup->id) }}" method="POST" id="destroy-form">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
