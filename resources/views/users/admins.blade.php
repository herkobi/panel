@extends('layouts.app')
@section('content')
@include('layouts.partials.page-title', ['title' => 'Yöneticiler'])
<div class="page-content position-relative mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card rounded-0 shadow-sm border-0 mb-3">
                <div class="card-header border-0 bg-white pt-3 pb-0">
                    <div class="d-flex align-items-center justify-content-between w-100 mb-5">
                        <h4 class="card-title mb-0">Kayıtlı Yöneticiler</h4>
                    </div>
                </div>
                <div class="card-body bg-white">
                    <div class="table-responsive table-responsive-lg">
                        <table class="table table-striped bg-white">
                            <thead>
                                <tr>
                                    <th scope="col" class="w-30">Ad Soyad</th>
                                    <th scope="col" class="w-30">E-posta Adresi</th>
                                    <th scope="col" class="w-20">Yetkiler</th>
                                    <th scope="col" class="w-20 text-center">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <ul class="list-unstyled list-inline">
                                        @foreach ($user->getRoleNames() as $role)
                                        <li>{{$role}}</li>
                                        @endforeach
                                        </ul>
                                    </td>
                                    <td></td>
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
