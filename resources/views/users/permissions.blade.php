@extends('layouts.app')
@section('content')
@include('layouts.partials.page-title', ['title' => 'Yeni Kullanıcı Oluştur'])
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
                    <form method="POST" action="{{route('panel.store.user.permissions', $user->id)}}" autocomplete="off">
                        @csrf
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-2 fw-semibold mb-0" for="user-name">Ad Soyad</label>
                                <div class="col-md-10">{{$user->name}}</div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-2 fw-semibold mb-0" for="user-name">E-posta Adresi</label>
                                <div class="col-md-10">{{$user->email}}</div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-2 fw-semibold mb-0" for="user-roles">Tanımlı Yetkiler</label>
                                <div id="user-roles" class="col-md-10">
                                    <ul class="list-unstyled list-inline">
                                    @foreach ($user->getRoleNames() as $role)
                                        <li>{{ $role }}</li>
                                    @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="role-permissions" class="form-label fw-semibold">Özel İzinler</label>
                                    <span class="d-block small text-danger">Özel izin tanımlarken tanımlı yetkiler dışında kalan izinlerden seçiniz</span>
                                </div>
                                <div id="role-permissions" class="col-md-10">
                                    @foreach ($basePermissions as $key => $permissions)
                                    <div class="row mb-5">
                                        <div class="col-md-12 mb-2">
                                            <div class="d-flex align-items-center justify-content-between border-bottom">
                                                <h4>{{ $key }}</h4>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input shadow-none" type="checkbox" role="switch" id="select-all-{{ Str::slug('-', $key) }}"  onClick="setAllCheckboxes('{{'group-'. Str::slug('-', $key) }}', '{{'group-'. Str::slug('-', $key) .'-permissions'}}', this);">
                                                    <label class="form-check-label" for="select-all-{{ Str::slug('-', $key) }}">Tümünü Seç</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="{{'group-'. Str::slug('-', $key) }}" class="row">
                                            @foreach ($permissions as $permissionId => $permission)
                                            <div class="col-md-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input rounded-0 shadow-none group-{{ Str::slug('-', $key) }}-permissions" type="checkbox" id="role-permission-{{ $permissionId }}" name="permission[]" value="{{ $permissionId }}" {{ in_array($permissionId, $rolePermissions) ? "checked" : ""}}>
                                                    <label class="form-check-label" for="role-permission-{{ $permissionId }}">{{ $permission }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
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

@section('js')
<script>
function setAllCheckboxes(divId, divClass, sourceCheckbox) {
    divElement = document.getElementById(divId);
    inputElements = divElement.getElementsByClassName(divClass);
    for (i = 0; i < inputElements.length; i++) {
        if (inputElements[i].type != 'checkbox')
            continue;
        inputElements[i].checked = sourceCheckbox.checked;
    }
}
</script>
@endsection
