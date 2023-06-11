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
                    <form action="{{ route('panel.role.store', $role->id) }}" method="post">
                        @csrf
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-2 fw-semibold" for="role-name">Yetki Adı</label>
                                <div class="col-md-10">
                                    <input class="form-control rounded-0 shadow-none form-control-sm" id="role-name" type="text" value="{{ $role->name }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-2 fw-semibold mb-0" for="permission-group-type">Kullanıcı Türü</label>
                                <div class="col-md-10">
                                    <div class="row">
                                        @foreach (\App\Enums\UserType::cases() as $type)
                                        <div class="col-md-2 mb-2">
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
                                <label for="role-permissions" class="form-label col-md-2 fw-semibold mb-0">İzinler</label>
                                <div id="role-permissions" class="col-md-10">
                                    @foreach ($groups as $group)
                                    <div class="row mb-5">
                                        <div class="col-md-12 mb-2">
                                            <div class="d-flex align-items-center justify-content-between border-bottom">
                                                <h4>{{ $group->name}}</h4>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input shadow-none" type="checkbox" role="switch" id="select-all-{{$group->id}}"  onClick="setAllCheckboxes('{{'group-'.$group->id}}', '{{'group-'.$group->id.'-permissions'}}', this);">
                                                    <label class="form-check-label" for="select-all-{{$group->id}}">Tümünü Seç</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="{{'group-'.$group->id}}" class="row">
                                            @foreach ($group->permission as $permission)
                                            <div class="col-md-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input rounded-0 shadow-none group-{{ $group->id }}-permissions" type="checkbox" id="role-permission-{{$permission->id}}" name="permission[]" value="{{$permission->id}}">
                                                    <label class="form-check-label" for="role-permission-{{$permission->id}}">{{ $permission->text }}</label>
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
                                <div class="offset-md-2 col-md-5">
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
