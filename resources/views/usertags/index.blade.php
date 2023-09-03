@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => __('usertag.page.title')])
    <div class="page-content position-relative mb-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-3">
                        <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                            <h4 class="card-title mb-0">{{ __('usertag.create.form.title') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="user-tag-form" action="" method="post">
                            @csrf
                            <div class="mb-3 border-bottom pb-3">
                                <div class="row">
                                    <label for="user-tag-status"
                                        class="col-md-3 fw-bold align-self-center">{{ __('usertag.create.form.status.label') }}</label>
                                    <div id="user-tag-status" class="col-md-9">
                                        @foreach (Status::cases() as $status)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input rounded-0 shadow-none" type="radio"
                                                    name="status" id="user-tag-status-title-{{ $status->value }}"
                                                    value="{{ $status->value }}" {{ $status->value == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="user-tag-status-title-{{ $status->value }}">{{ Status::getTitle($status->value) }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 border-bottom pb-3">
                                <div class="row">
                                    <label class="form-label col-md-3 fw-semibold mb-0 align-self-center"
                                        for="user-tag-name">{{ __('usertag.create.form.tag.label') }}</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-text rounded-0 shadow-none bg-white">
                                                <i class="ri-text"></i>
                                            </span>
                                            <input type="text" id="user-tag-name"
                                                placeholder="{{ __('usertag.create.form.tag.placeholder') }}"
                                                class="form-control border-start-0  rounded-0 shadow-none ps-0 @error('name') is-invalid @enderror"
                                                name="name" value="{{ old('name') }}" autocomplete="off">
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
                                        for="color">{{ __('usertag.create.form.color.label') }}</label>
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
                                        for="user-tag-desc">{{ __('usertag.create.form.desc.label') }}</label>
                                    <div class="col-md-9">
                                        <input type="text" id="user-tag-desc"
                                            class="form-control rounded-0 shadow-none form-control-sm" name="desc"
                                            value="{{ old('desc') }}"
                                            placeholder="{{ __('usertag.create.form.desc.placeholder') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="offset-md-3 col-md-5">
                                        <button id="save-user-tag-form" type="button"
                                            class="btn add-btn btn-primary btn-sm rounded-0 shadow-none"><i
                                                class="ri-add-line"></i>
                                            {{ __('usertag.create.form.submit.text') }}</button>
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
                            <h4 class="card-title mb-0">{{ __('usertag.tags.title') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="user-tag-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" class="w-10">{{ __('usertag.table.status') }}</th>
                                        <th scope="col" class="w-20">{{ __('usertag.table.tag') }}</th>
                                        <th scope="col" class="w-20">{{ __('usertag.table.color') }}</th>
                                        <th scope="col" class="w-40">{{ __('usertag.table.desc') }}</th>
                                        <th scope="col" class="w-10 text-center">{{ __('usertag.table.process') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usertags as $tag)
                                        <tr>
                                            <td scope="row"><span
                                                    class="badge fw-normal {{ Status::color($tag->status) }}">{{ Status::title($tag->status) }}</span>
                                            </td>
                                            <td>{{ $tag->name }}</td>
                                            <td>
                                                <div class="badge w-100 text-start"
                                                    style="background-color: {{ $tag->color }};font-weight: normal;color: {{ Helper::isDark($tag->color) ? '#fff' : '#000' }}">
                                                    {{ __('usertag.table.color.text') }}</div>
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
                                                                href="{{ route('panel.user.tag.edit', $tag->id) }}">{{ __('usertag.table.edit.text') }}</a>
                                                        </li>
                                                        <li><a class="dropdown-item small"
                                                                href="{{ route('panel.user.tag.list', $tag->id) }}">{{ __('usertag.table.users.text') }}</a>
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
    <script>
        function sendAjaxRequest(urlToSend, status, name, color, desc) {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: urlToSend,
                data: {
                    status: status,
                    name: name,
                    color: color,
                    desc: desc
                },
                beforeSend: function() {
                    $("#spinner-div").show();
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('#user-tag-form').trigger("reset");
                        $("#user-tag-table").load(window.location + " #user-tag-table");
                        Swal.fire({
                            icon: 'success',
                            title: "{{ __('usertag.create.success.title') }}",
                            text: "{{ __('usertag.create.success.message') }}",
                            confirmButtonText: "{{ __('usertag.create.success.button.text') }}"
                        })
                    }
                },
                error: function(data) {
                    const validationErrors = data.responseJSON.errors;
                    if (validationErrors) {
                        var messageText = Object.values(validationErrors).map((item) => {
                            return item[0];
                        }).join('<br>');
                    }
                    Swal.fire({
                        icon: 'error',
                        title: "{{ __('usertag.create.error.title') }}",
                        text: messageText,
                        confirmButtonText: "{{ __('usertag.create.error.button.text') }}"
                    })
                },
                complete: function(data) {
                    $("#spinner-div").hide(); //Request is complete so hide spinner
                }
            });
        }

        const btn = document.querySelector("#save-user-tag-form");
        btn.addEventListener('click', (e) => {

            const name = document.getElementsByName('name')[0].value;
            const desc = document.getElementsByName('desc')[0].value;
            const statusRadio = document.getElementsByName('status');
            const colorInput = document.getElementById('user-tag-color');
            const color = colorInput.value;

            for (i = 0; i < statusRadio.length; i++) {
                if (statusRadio[i].checked) {
                    status = statusRadio[i].value;
                }
            }

            sendAjaxRequest('{{ route('panel.user.tag.store') }}', status, name, color, desc);
        });
    </script>
@endsection
