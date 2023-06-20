@extends('layouts.app')
@section('content')
@include('layouts.partials.page-title', ['title' => 'Kullanıcı Yetkileri'])
<div class="page-content position-relative mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card rounded-0 shadow-sm border-0 mb-3">
                <div class="card-header border-0 bg-white pt-3 pb-0">
                    <div class="d-flex align-items-center justify-content-between w-100 mb-5">
                        <h4 class="card-title mb-0">Kayıtlı Yetkiler</h4>
                        @can('role-create')
                        <a href={{ route('panel.role.create') }} class="btn btn-primary rounded-0 shadow-none">Yeni Yetki Ekle</a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-responsive-lg">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" class="w-20">Yetki Adı</th>
                                    <th scope="col" class="w-20">Kullanıcı Türü</th>
                                    <th scope="col" class="w-50">İzinler</th>
                                    <th scope="col" class="w-10 text-center">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($baseRoutes as $key => $roles)
                                <tr>
                                    <td class="fw-semibold">{{ $key }}</td>
                                    <td>{{ \App\Enums\UserType::title($roles["roleType"]) }}</td>
                                    <td>
                                        @if(isset($roles["permissions"]))
                                            @foreach($roles["permissions"] as $roleName => $permissions)
                                                <div class="row">
                                                    <div class="col-md-12 fw-semibold">{{ $roleName }}</div>
                                                        @foreach($permissions as $permission)
                                                        <div class="col-md-4">{{ $permission }}</div>
                                                        @endforeach
                                                    <div class="col-md-12 my-2"><div class="border-bottom"></div></div>
                                                </div>
                                            @endforeach
                                        @else
                                            Atanmış yetki yok.
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @can('role-edit')
                                        <a href="{{ route('panel.role.edit', $roles["roleId"]) }}" title="Kategori Düzenle" class="text-decoration-none"><i class="ri-menu-3-fill"></i></a>
                                        @endcan
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
