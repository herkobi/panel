@extends('layouts.app')
@section('content')
@include('layouts.partials.page-title', ['title' => 'Kullanıcı Yetkileri'])
<div class="page-content position-relative mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card rounded-0 shadow-sm border-0 mb-3">
                <div class="card-header border-0 bg-white pt-3 pb-3">
                    <h4 class="card-title mb-0">Yetki Ekle</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('panel.role.update', $role->id) }}" method="post">
                        @csrf
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-2 fw-semibold" for="role-name">Yetki Adı</label>
                                <div class="col-md-10">
                                    <input class="form-control rounded-0 shadow-none form-control-sm" id="role-name" type="text" name="name" value="{{ $role->name ? $role->name : old('name') }}" placeholder="Yetki Adı" required autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-2 fw-semibold mb-0" for="permission-group-type">Kullanıcı Türü</label>
                                <div class="col-md-10">
                                    <div class="row">

                                        {{ dd($role->type) }}
                                        @foreach (\App\Enums\UserType::cases() as $type)
                                        <div class="col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input rounded-0 shadow-none" type="radio" id="permission-group-type-user" {{ $role->type == $type->value ? 'checked' : 0 }} disabled>
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
                                <label class="form-label col-md-2 fw-semibold mb-0" for="role-name">Yetki Açıklaması</label>
                                <div class="col-md-10">
                                    <textarea class="form-control rounded-0 shadow-none" name="desc" id="role-desc" rows="2">{{ $role->desc }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-2 fw-semibold">İzinler</label>
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
                            <div class="row">
                                <div class="offset-md-2 col-md-10">
                                    <button type="submit" class="btn add-btn btn-primary btn-sm rounded-0 shadow-none"><i class="ri-add-line"></i> Kaydet</button>
                                </div>
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
