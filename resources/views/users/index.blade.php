@extends('layouts.app')
@section('content')
@include('layouts.partials.page-title', ['title' => 'Kullanıcılar'])
<div class="page-content position-relative mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card rounded-0 shadow-sm border-0 mb-3">
                <div class="card-header border-0 bg-white pt-3 pb-0">
                    <div class="d-flex align-items-center justify-content-between w-100 mb-5">
                        <h4 class="card-title mb-0">Kayıtlı Kullanıcılar</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-responsive-lg">
                        <table class="table table-striped bg-white">
                            <thead>
                                <tr>
                                    <th scope="col" class="w-25">Ad Soyad</th>
                                    <th scope="col" class="w-25">E-posta Adresi</th>
                                    <th scope="col" class="w-20">Yetkiler</th>
                                    <th scope="col" class="w-20">Özel İzinler</th>
                                    <th scope="col" class="w-10 text-center">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->name }}</th>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <ul class="list-unstyled list-inline">
                                        @foreach ($user->getRoleNames() as $role)
                                        <li>{{$role}}</li>
                                        @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <ul class="list-unstyled list-inline">
                                            @foreach ($user->permissions as $permission)
                                            <li>
                                                <span class="d-block fw-semibold">{{$permission->group->name}}</span>
                                                {{$permission->text}}
                                            </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a class="btn btn-text dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false">
                                                <i class="ri-menu-3-fill"></i>
                                            </a>
                                            <ul class="dropdown-menu rounded-0 shadow-none bg-white">
                                                <li><a class="dropdown-item" href="{{ route('panel.user.detail', $user->id) }}">Bilgiler</a></li>
                                                <li><a class="dropdown-item" href="#">Düzenle</a></li>
                                                <li><a class="dropdown-item" href="{{ route('panel.admin.permissions', $user->id) }}">Özel Yetkiler</a></li>
                                            </ul>
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
