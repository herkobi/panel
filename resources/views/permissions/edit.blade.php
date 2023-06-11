@extends('layouts.app')
@section('content')
@include('layouts.partials.page-title', ['title' => 'Kullanıcı İzinleri'])
<div class="page-content position-relative mb-4">
    <div class="row">
        <div class="col-md-5">
            <div class="card rounded-0 shadow-sm border-0 mb-3">
                <div class="card-header border-0 bg-white pt-3 pb-0">
                    <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                        <h4 class="card-title mb-0">Yeni İzin Ekle</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('panel.permission.update', $permission->id) }}" method="post" autocomplete="off">
                        @csrf
                        <div id="repeater" class="mb-3 border-bottom pb-3">
                            <div class="row gx-1">
                                <label class="form-label col-md-2 fw-semibold align-self-center mb-0" for="permission-meta">Grubu</label>
                                <div class="col-md-10">
                                    <select class="form-select form-select-sm rounded-0 shadow-none" name="group_id" id="permission-group" required>
                                        <option>Grup Seçiniz</option>
                                        @foreach ($groups as $group)
                                        <option value="{{$group->id}}" {{ $permission->group->id == $group->id ? 'selected': '' }}>{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="offset-md-2 col-md-10">
                                    <div class="row gx-1 mb-2">
                                        <div class="col-md-6"><input type="text" name="text" id="permission-text" value="{{ $permission->text }}" class="form-control form-control-sm rounded-0 shadow-none" placeholder="İzin Açıklaması"></div>
                                        <div class="col-md-6"><input type="text" name="name" id="permission-name" value="{{ $permission->name }}" class="form-control form-control-sm rounded-0 shadow-none" placeholder="İzin Adı"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 border-top pt-3">
                            <div class="row">
                                <div class="offset-md-2 col-md-10">
                                    <div class="d-flex align-items-center justify-content-between w-100">
                                        <button type="submit" class="btn add-btn btn-primary btn-sm rounded-0 shadow-none"><i class="ri-add-line"></i> Güncelle</button>
                                        @hasrole('Super Admin')
                                        <button type="button" class="btn add-btn btn-danger btn-sm rounded-0 shadow-none" onclick="event.preventDefault(); document.getElementById('destroy-form').submit();"><i class="ri-delete-bin-2-line"></i> {{ __('İzini Sil') }}</button>
                                        @endhasrole
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('panel.permission.destroy', $permission->id) }}" method="POST" id="destroy-form">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
