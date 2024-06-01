@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Yetkiler',
                ])
                @include('admin.roles.roles.partials.page-buttons', [
                    'first_button' => 'Yetkiler',
                    'first_link' => 'panel.roles',
                    'second_button' => 'Yeni Yetki Ekle',
                    'second_link' => 'panel.role.create',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.roles.partials.navigation')
                    @include('admin.settings.partials.navigation')
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header d-flex align-items-start justify-content-between">
                            <div class="d-block">
                                <h1 class="card-title">{{ $role->name }} Yetkisine Ait İzinler</h1>
                                <div>
                                    @if ($role->status->value == 1)
                                        <span class="badge bg-green text-green-fg">{{ Status::title($role->status) }}</span>
                                    @else
                                        <span class="badge bg-red text-red-fg">{{ Status::title($role->status) }}</span>
                                    @endif
                                </div>
                            </div>
                            <span class="badge bg-primary text-green-fg">Kullanıcı Türü:
                                {{ UserType::title($role->type) }}</span>
                        </div>
                        <form action="{{ route('panel.role.sync.permissions', $role->id) }}" method="post">
                            @csrf
                            <div class="accordion" id="permissionsAccordion">
                                @foreach ($permissions as $permission)
                                    <div class="accordion-item rounded-0 border-0 border-bottom">
                                        <h2 class="accordion-header" id="heading{{ $permission->id }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $permission->id }}" aria-expanded="true"
                                                aria-controls="collapse{{ $permission->id }}">
                                                <div class="d-flex justify-content-between w-100">
                                                    <span>{{ $permission->desc }}</span>
                                                    <label class="form-check form-switch m-0">
                                                        <input type="checkbox" class="form-check-input all-permissions"
                                                            name="permission[]" value="{{ $permission->id }}"
                                                            @if (in_array($permission->id, $rolePermissions)) checked @endif>
                                                    </label>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $permission->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $permission->id }}"
                                            data-bs-parent="#permissionsAccordion">
                                            <div class="accordion-body p-0 bg-gray-500">
                                                <div class="table-responsive">
                                                    @if (count($permission->children) > 0)
                                                        <table class="table sub-permissions">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" class="w-90">Alt İzin Açıklaması
                                                                    </th>
                                                                    <th scope="col" class="w-10">İşlemler</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($permission->children as $child)
                                                                    <tr>
                                                                        <td>
                                                                            <div>{{ $child->desc }}</div>
                                                                            <small>{{ $child->name }}</small>
                                                                        </td>
                                                                        <td>
                                                                            <label class="form-check form-switch m-0">
                                                                                <input type="checkbox"
                                                                                    class="form-check-input permission"
                                                                                    name="permission[]"
                                                                                    value="{{ $child->id }}"
                                                                                    @if (in_array($child->id, $rolePermissions)) checked @endif>
                                                                            </label>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <div>Alt izin bulunmamaktadır.</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">İzinleri Tanımla</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const mainPermissions = document.querySelectorAll('.all-permissions');

            mainPermissions.forEach(function(mainCheckbox) {
                const mainPermissionRow = mainCheckbox.closest('.accordion-item');
                const mainPermissionId = mainPermissionRow.querySelector('.accordion-header button')
                    .getAttribute('data-bs-target').replace('#collapse', '');
                const childPermissionRows = mainPermissionRow.querySelectorAll('.permission');

                mainCheckbox.addEventListener('change', function() {
                    const isChecked = mainCheckbox.checked;

                    childPermissionRows.forEach(function(childCheckbox) {
                        childCheckbox.checked = isChecked;
                        childCheckbox.readOnly = isChecked;
                    });
                });

                childPermissionRows.forEach(function(childCheckbox) {
                    childCheckbox.addEventListener('change', function() {
                        if (!childCheckbox.checked) {
                            mainCheckbox.checked = false;
                            mainCheckbox.readOnly = false;
                        } else {
                            const allChecked = Array.from(childPermissionRows).every(
                                function(childCheckbox) {
                                    return childCheckbox.checked;
                                });

                            mainCheckbox.checked = allChecked;
                            mainCheckbox.readOnly = allChecked;
                        }
                    });
                });
            });
        });
    </script>
@endsection
