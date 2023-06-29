@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => 'Kullanıcı Kategorileri'])
    <div class="page-content position-relative activity-page mb-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-3">
                        <h4 class="card-title mb-0">Etiket Ekle</h4>
                    </div>
                    <div class="card-body">
                        <form id="user-tag-form" action="" method="post">
                            @csrf
                            <div class="mb-3 border-bottom pb-3">
                                <div class="row">
                                    <label for="user-tag-status" class="col-md-3 fw-bold align-self-center">Durum</label>
                                    <div id="user-tag-status" class="col-md-9">
                                        @foreach (Status::cases() as $status)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input shadow-none" type="radio" name="status"
                                                    id="user-tag-status-title-{{ $status->value }}"
                                                    value="{{ $status->value }}">
                                                <label class="form-check-label"
                                                    for="user-tag-status-title-{{ $status->value }}">{{ $status->title() }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 border-bottom pb-3">
                                <div class="row">
                                    <label class="form-label col-md-3 fw-semibold mb-0 align-self-center"
                                        for="user-tag-name">Etiket</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-text rounded-0 shadow-none bg-white">
                                                <i class="ri-text"></i>
                                            </span>
                                            <input type="text" id="user-tag-name" placeholder="Etiket"
                                                class="form-control border-start-0  rounded-0 shadow-none ps-0 @error('name') is-invalid @enderror"
                                                name="name" value="{{ old('name') }}" required autocomplete="off">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 border-bottom pb-3">
                                <div class="row">
                                    <label class="form-label col-md-3 fw-semibold mb-0 align-self-center"
                                        for="color">Renk</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-text rounded-0 shadow-none bg-white py-0">
                                                <i class="ri-palette-line"></i>
                                            </span>
                                            <input type="color" id="user-tag-color"
                                                class="form-control border-start-0 rounded-0 shadow-none" name="color">
                                            @error('color')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 border-bottom pb-3">
                                <div class="row">
                                    <label class="form-label col-md-3 fw-semibold mb-0 align-self-start"
                                        for="user-tag-desc">Açıklama</label>
                                    <div class="col-md-9">
                                        <input type="text" id="user-tag-desc"
                                            class="form-control rounded-0 shadow-none form-control-sm" name="desc"
                                            value="{{ old('desc') }}" placeholder="Etiketle İlgili Kısa Açıklama">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="offset-md-3 col-md-5">
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
            <div class="col-md-8">
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-0">
                        <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                            <h4 class="card-title mb-0">Kayıtlı Etiketler</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="user-tag-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" class="w-30">Etiket Adı</th>
                                        <th scope="col" class="w-20">Renk</th>
                                        <th scope="col" class="w-40">Açıklama</th>
                                        <th scope="col" class="w-10 text-center">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usertags as $tag)
                                        <tr>
                                            <td scope="row">{{ $tag->name }}</td>
                                            <td>
                                                <div class="badge w-100 text-start"
                                                    style="background-color: {{ $tag->color }};font-weight: normal;color: {{ Helper::isDark($tag->color) ? '#fff' : '#000' }}">
                                                    renk</div>
                                            </td>
                                            <td>{{ $tag->desc }}</td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <a class="btn btn-text dropdown-toggle p-0" href="#"
                                                        role="button" data-bs-toggle="dropdown" data-boundary="window"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <i class="ri-menu-3-fill"></i>
                                                    </a>
                                                    <ul class="dropdown-menu rounded-0 shadow-none bg-white">
                                                        <li><a class="dropdown-item small"
                                                                href="{{ route('panel.user.tag.edit', $tag->id) }}">Düzenle</a>
                                                        </li>
                                                        <li><a class="dropdown-item small" href="">Kullanıcılar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    {{ $usertags->links() }}
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
                let status = $("[name='status']:checked").val();
                let name = $("#user-tag-name").val();
                let colorInput = document.getElementById('user-tag-color');
                let colorValue = colorInput.value;
                let desc = $("#user-tag-desc").val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('panel.user.tag.store') }}",
                    dataType: 'json',
                    data: {
                        status: status,
                        name: name,
                        color: colorValue,
                        desc: desc
                    },
                    success: function(data) {
                        if(data.status == 'success')
                        {
                            $('#user-tag-form').trigger("reset");
                            $("#user-tag-table").load(window.location + " #user-tag-table");
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