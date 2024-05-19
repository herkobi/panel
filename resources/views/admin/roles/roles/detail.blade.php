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
