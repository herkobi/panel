@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Yönetici İzinleri',
                ])
                @include('admin.roles.permissions.partials.page-buttons', [
                    'first_button' => 'Yönetici İzinleri',
                    'first_link' => 'panel.permissions.admin',
                    'second_button' => 'Yeni İzin Ekle',
                    'second_link' => 'panel.permission.create',
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
                        <div class="card-header">
                            <h1 class="card-title">Yönetici İzinleri</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-35">İzin Adı</th>
                                        <th class="w-35">İzin</th>
                                        <th class="w-15"></th>
                                        <th class="w-15"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->desc }}</td>
                                            <td>{{ $permission->name }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-ghost-secondary btn-sm"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{ $permission->id }}" aria-expanded="false"
                                                    aria-controls="collapse{{ $permission->id }}">
                                                    İzinler
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('panel.permission.edit', $permission->id) }}"
                                                    class="btn btn-ghost-primary btn-sm" title="Düzenle">Düzenle</a>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="collapse{{ $permission->id }}">
                                            <td colspan="4">
                                                <div class="table-responsive nested-table">
                                                    <table class="table card-table table-vcenter text-nowrap datatable">
                                                        <thead>
                                                            <tr>
                                                                <th class="w-50">Alt İzin Adı</th>
                                                                <th class="w-35">Alt İzin</th>
                                                                <th class="w-15"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($permission->children as $child)
                                                                <tr>
                                                                    <td>{{ $child->desc }}</td>
                                                                    <td>{{ $child->name }}</td>
                                                                    <td class="text-center">
                                                                        <a href="{{ route('panel.permission.edit', $child->id) }}"
                                                                            class="btn btn-ghost-primary btn-sm"
                                                                            title="Düzenle">Düzenle</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
