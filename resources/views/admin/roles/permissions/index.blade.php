@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'İzinler',
                ])
                @include('admin.roles.permissions.partials.page-buttons', [
                    'first_button' => 'İzinler',
                    'first_link' => 'panel.permissions',
                    'second_button' => 'Yeni İzin Ekle',
                    'second_link' => 'panel.permissions',
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
                            <h1 class="card-title">Kullanıcı İzinleri</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-5">Durum</th>
                                        <th class="w-60">İzin Adı</th>
                                        <th class="w-20">İzin Grubu</th>
                                        <th class="w-15"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>
                                                @if ($permission->status->value == 1)
                                                    <span
                                                        class="badge bg-green text-green-fg">{{ Status::title($permission->status) }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-red text-red-fg">{{ Status::title($permission->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="fw-bold">{{ $permission->title }}</td>
                                            <td>{{ $permission->group->name }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('panel.permission.edit', $permission->id) }}"
                                                    class="btn btn-ghost-primary btn-sm" title="Düzenle">
                                                    Düzenle
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center pb-1 text-end w-100">
                            {{ $permissions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
