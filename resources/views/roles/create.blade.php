@extends('layouts.app')
@section('content')
@include('layouts.partials.page-title', ['title' => 'Yetki Tanımla'])
<div class="page-content position-relative mb-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card rounded-0 shadow-sm border-0 mb-3">
                <div class="card-header border-0 bg-white pt-3 pb-3">
                    <h4 class="card-title mb-0">Yetki Ekle</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('panel.role.permissions') }}" method="post">
                        @csrf
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-2 fw-semibold mb-0" for="role-name">Yetki Adı</label>
                                <div class="col-md-10">
                                    <input class="form-control rounded-0 shadow-none form-control-sm" id="role-name" type="text" name="name" value="{{ old('name') }}" placeholder="Yetki Adı" required autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-2 fw-semibold mb-0" for="permission-group-type">Kullanıcı Türü</label>
                                <div class="col-md-10">
                                    <div class="row">
                                        @foreach (\App\Enums\UserType::cases() as $type)
                                        <div class="col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input rounded-0 shadow-none" type="radio" name="type" id="permission-group-type-user" value="{{ $type->value }}">
                                                <label class="form-check-label rounded-0 shadow-none" for="permission-group-type-user">{{ \App\Enums\UserType::getTitle($type->value) }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <span class="small text-danger d-block">Yetkinin hangi kullanıcı türü için kullanılacağını belirtmek için seçim yapınız</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-3">
                            <div class="row">
                                <label class="form-label col-md-2 fw-semibold mb-0" for="role-name">Yetki Açıklaması</label>
                                <div class="col-md-10">
                                    <textarea class="form-control rounded-0 shadow-none" name="desc" id="role-desc" rows="2">{{ old('desc' )}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="offset-md-2 col-md-10">
                                    <button type="submit" class="btn add-btn btn-primary btn-sm rounded-0 shadow-none"><i class="ri-add-line"></i> İzinleri Tanımla</button>
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
