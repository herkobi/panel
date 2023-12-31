@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => 'Kullanıcı İzinleri'])
    <div class="page-content position-relative mb-4">
        <div class="row">
            <div class="col-md-5">
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-0">
                        <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                            <h4 class="card-title mb-0">Yeni İzin Ekle</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="permission-form" action="{{ route('panel.permission.store') }}" method="post"
                            autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <div class="row">
                                    <label class="form-label col-md-2 fw-semibold align-self-start mb-0"
                                        for="permission-meta">Grubu</label>
                                    <div class="col-md-10">
                                        <select
                                            class="form-select form-select-sm rounded-0 shadow-none permission_group_list mb-3"
                                            name="group_id" id="permission-group" required>
                                            <option value="0" selected>Grup Seçiniz</option>
                                            @foreach ($groups as $group)
                                                <option class="option" value="{{ $group->id }}">
                                                    {{ $group->name . ' - ' . UserType::title($group->type) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label col-md-12 fw-semibold" for="permission-text">İzin
                                                    Açıklaması</label>
                                                <input type="text" name="text" id="permission-text"
                                                    class="form-control form-control-sm rounded-0 shadow-none"
                                                    placeholder="İzin Açıklaması">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label col-md-12 fw-semibold" for="permission-text">İzin
                                                    Adı</label>
                                                <input type="text" name="name" id="permission-name"
                                                    class="form-control form-control-sm rounded-0 shadow-none"
                                                    placeholder="İzin Adı">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="row">
                                    <div class="offset-md-2 col-md-10">
                                        <div id="containerElement"></div>
                                        <div class="mt-2">
                                            <button id="save-permission-form" type="submit"
                                                class="btn add-btn btn-primary btn-sm rounded-0 shadow-none"><i
                                                    class="ri-add-line"></i> Kaydet</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-0">
                        <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                            <h4 class="card-title mb-0">Kayıtlı İzinler</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-responsive-lg">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" class="w-25">İzin Grubu</th>
                                        <th scope="col" class="w-20">Türü</th>
                                        <th scope="col" class="w-20">İzin Adı</th>
                                        <th scope="col" class="w-10 text-center">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->group->name }}</td>
                                            <td>{{ UserType::title($permission->group->type) }}</td>
                                            <td>{{ $permission->name }}</td>
                                            <td class="text-center">
                                                @can('role-edit')
                                                    <a href="{{ route('panel.permission.edit', $permission->id) }}"
                                                        title="İzin Düzenle" class="text-decoration-none"><i
                                                            class="ri-menu-3-fill"></i></a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    {{ $permissions->links() }}
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
