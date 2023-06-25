@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => 'İzin Grupları'])
    <div class="page-content position-relative mb-4">
        <div class="row">
            <div class="col-md-5">
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-3">
                        <h4 class="card-title mb-0">Grup Ekle</h4>
                    </div>
                    <div class="card-body">
                        <form id="permission-group-form" action="" method="post">
                            @csrf
                            <div class="mb-3 border-bottom pb-3">
                                <div class="row">
                                    <label class="form-label col-md-4 fw-semibold mb-0" for="permission-group-name">Grup
                                        Adı</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control rounded-0 shadow-none form-control-sm"
                                            id="permission-group-name" name="name" value="{{ old('name') }}"
                                            placeholder="Grup Adı Örnek Rol Yönetimi, Kullanıcı Yönetimi" required
                                            autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 border-bottom pb-3">
                                <div class="row">
                                    <label class="form-label col-md-4 fw-semibold mb-0"
                                        for="permission-group-type">Kullanıcı Türü</label>
                                    <div class="col-md-8">
                                        <div class="row">
                                            @foreach (UserType::cases() as $type)
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input rounded-0 shadow-none" type="radio"
                                                            name="type" id="permission-group-user-type"
                                                            value="{{ $type->value }}">
                                                        <label class="form-check-label rounded-0 shadow-none"
                                                            for="permission-group-user-type">{{ UserType::getTitle($type->value) }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <span class="small text-danger d-block">İzin grubunun hangi kullanıcı türü için
                                            kullanılacağını belirtmek için seçim yapınız</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 border-bottom pb-3">
                                <div class="row">
                                    <label class="form-label col-md-4 fw-semibold mb-0" for="permission-group-desc">Grup
                                        Açıklaması</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control rounded-0 shadow-none form-control-sm"
                                            id="permission-group-desc" name="desc" value="{{ old('desc') }}"
                                            placeholder="Grup İle İlgili Kısa Açıklama" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="offset-md-4 col-md-5">
                                        <button type="button" id="save-btn"
                                            class="btn add-btn btn-primary btn-sm rounded-0 shadow-none"><i
                                                class="ri-add-line"></i> Kaydet</button>
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
                            <h4 class="card-title mb-0">Kayıtlı İzin Grupları</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-responsive-lg">
                            <table id="permission-group-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" class="w-30">Grup Adı</th>
                                        <th scope="col" class="w-30">Kullanıcı Türü</th>
                                        <th scope="col" class="w-30">Açıklama</th>
                                        <th scope="col" class="w-10 text-center">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groups as $group)
                                        <tr>
                                            <td>{{ $group->name }}</td>
                                            <td>{{ UserType::title($group->type) }}</td>
                                            <td>{{ $group->desc }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('panel.permission.group.edit', $group->id) }}"
                                                    title="Grubu Düzenle" class="text-decoration-none"><i
                                                        class="ri-menu-3-fill"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    {{ $groups->links() }}
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="module">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#save-btn').click(function(e) {
                e.preventDefault();
                let name = $("#permission-group-name").val();
                let typeInput = document.getElementById('permission-group-user-type');
                let usertype = typeInput.value;
                let desc = $("#permission-group-desc").val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('panel.permission.group.store') }}",
                    dataType: 'json',
                    data: {
                        name: name,
                        type: usertype,
                        desc: desc
                    },
                    success: function(data) {
                        if(data.status == 'success')
                        {
                            $('#permission-group-form').trigger("reset");
                            $("#permission-group-table").load(window.location + " #permission-group-table");
                        }
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });
        });
    </script>
@endsection
