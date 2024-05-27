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
                        <form action="" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row row-cards">
                                    @foreach ($permissions as $permission)
                                        <div class="col-lg-4">
                                            <div class="card selectPermissions">
                                                <div class="card-header p-3">
                                                    <div class="d-flex align-items-center justify-content-between w-100">
                                                        <div class="card-title">
                                                            {{ $permission->desc }}
                                                        </div>
                                                        <div class="permission-all">
                                                            <label class="form-check form-switch m-0">
                                                                <input type="checkbox"
                                                                    class="form-check-input position-static all-permissions ms-0"
                                                                    name="permission" value="{{ $permission->id }}">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-3">
                                                    <label class="form-label">İşlem Bazlı İzinler</label>
                                                    <div class="divide-y">
                                                        @foreach ($permission->children as $child)
                                                            <div>
                                                                <label class="row">
                                                                    <span class="col">
                                                                        {{ $child->desc }}
                                                                        <small>{{ $child->name }}</small>
                                                                    </span>
                                                                    <span class="col-auto">
                                                                        <label
                                                                            class="form-check form-check-single form-switch">
                                                                            <input type="checkbox" class="form-check-input permission"
                                                                                name="permission"
                                                                                value="{{ $child->id }}">
                                                                        </label>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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
            const cards = document.querySelectorAll('.selectPermissions');

            cards.forEach(function(card) {
                const allPermissionsCheckbox = card.querySelector('.all-permissions');
                const individualPermissionsCheckboxes = card.querySelectorAll('.permission');

                if (allPermissionsCheckbox) {
                    allPermissionsCheckbox.addEventListener('change', function() {
                        const isChecked = allPermissionsCheckbox.checked;

                        individualPermissionsCheckboxes.forEach(function(checkbox) {
                            checkbox.checked = isChecked;
                            checkbox.disabled = isChecked;
                        });
                    });
                }
            });
        });
    </script>
@endsection
