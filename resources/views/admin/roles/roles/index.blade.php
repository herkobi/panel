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
                        <div class="card-header">
                            <h1 class="card-title">Kullanıcı Yetkileri</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-5">Durum</th>
                                        <th class="w-20">Yetki Adı</th>
                                        <th class="w-40">Yetki Türü</th>
                                        <th class="w-20">İzinler</th>
                                        <th class="w-15"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>
                                                @if ($role->status->value == 1)
                                                    <span
                                                        class="badge bg-green text-green-fg">{{ Status::title($role->status) }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-red text-red-fg">{{ Status::title($role->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="fw-bold">{{ $role->name }}</td>
                                            <td>{{ UserType::title($role->type) }}</td>
                                            <td>
                                                <a href="{{ route('panel.role.detail', $role->id) }}"
                                                    class="btn btn-ghost-secondary btn-sm" title="İzinler">İzinler</a>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('panel.role.edit', $role->id) }}"
                                                    class="btn btn-ghost-primary btn-sm" title="Düzenle">
                                                    Düzenle
                                                </a>
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
