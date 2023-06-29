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
                        <form action="" method="post" autocomplete="off">
                            @csrf
                            <div id="repeater" class="mb-3 border-bottom pb-3">
                                <div class="row gx-1">
                                    <label class="form-label col-md-2 fw-semibold align-self-center mb-0"
                                        for="permission-meta">Grubu</label>
                                    <div class="col-md-7">
                                        <select
                                            class="form-select form-select-sm rounded-0 shadow-none permission_group_list"
                                            name="group_id" id="permission-group" required>
                                            <option selected>Grup Seçiniz</option>
                                            @foreach ($groups as $group)
                                                <option class="option" value="{{ $group->id }}">
                                                    {{ $group->name . ' - ' . \App\Enums\UserType::title($group->type) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" id="createElement"
                                            class="btn btn-secondary btn-sm rounded-0 shadow-none align-self-buttom w-100"
                                            title="Satır Ekle"><i class="ri-add-line"></i> İzin Ekle</button>
                                    </div>
                                    <span class="offset-md-2 col-md-10 small text-danger">İzin ekle butonuna basarak gruba
                                        ait izinleri tanımlayınız</span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="row">
                                    <div class="offset-md-2 col-md-10">
                                        <div id="containerElement"></div>
                                        <div class="mt-2">
                                            <button type="button" onclick="addPermission()"
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
                                        <th scope="col" class="w-25">Açıklama</th>
                                        <th scope="col" class="w-20">İzin Adı</th>
                                        <th scope="col" class="w-10 text-center">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->group->name }}</td>
                                            <td>{{ \App\Enums\UserType::title($permission->group->type) }}</td>
                                            <td>{{ $permission->text }}</td>
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
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="structure" style="display: none">
        <div class="row gx-1 mb-2">
            <div class="col-md-5"><input type="text" name="text[]" id="permission-text"
                    class="form-control form-control-sm rounded-0 shadow-none" placeholder="İzin Açıklaması"></div>
            <div class="col-md-5"><input type="text" name="name[]" id="permission-name"
                    class="form-control form-control-sm rounded-0 shadow-none" placeholder="İzin Adı"></div>
            <div class="col-md-2"><button type="button"
                    class="btn btn-danger btn-sm border-0 rounded-0 shadow-none align-self-buttom w-100 removeElement"
                    title="Kaldır"><i class="ri-delete-bin-line"></i></button></div>
        </div>
    </div>
@endsection

@section('js')
    <script type="module">
    $(document).ready(function () {
        $('#repeater').repeater();
    });
    </script>
    <script>
        var groupId, arrayText, arrayName;

        function sendAjaxRequest(urlToSend, group_id, text, name) {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: urlToSend,
                data: {
                    group_id: group_id,
                    text: text,
                    name: name
                },
                success: function(result) {
                    window.location.reload();
                },
                error: function(result) {
                    alert('error');
                }
            });
        }

        function addPermission() {
            sendAjaxRequest('{{ route('panel.permission.store') }}', groupName, userType, groupDesc);
        }

        // TODO: İzin eklemeleri ajaxa taşınacak. repeater https://github.com/DubFriend/jquery.repeater bununla değiştirilebilir.
        // TODO: data içine girilen değerler dışardan tek bir değişkenle atılabilir mi? data = name + text + desc gibi..
    </script>
@endsection
