@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => __('usertag.page.title')])
    <div class="page-content position-relative activity-page mb-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-3">
                        <h4 class="card-title mb-0">{{ __('usertag.update.form.title') }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.user.tag.update', $usertag->id) }}" method="post">
                            @csrf
                            <div class="mb-3 border-bottom pb-3">
                                <div class="row">
                                    <label for="ser-tag-status"
                                        class="col-md-3 fw-bold align-self-center">{{ __('usertag.update.form.status.label') }}</label>
                                    <div class="col-md-9">
                                        @foreach (Status::cases() as $type)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input rounded-0 shadow-none" type="radio"
                                                    id="permission-group-type-user" name="status"
                                                    value="{{ $type->value }}"
                                                    {{ $usertag->status->value == $type->value ? 'checked' : '' }}>
                                                <label class="form-check-label rounded-0 shadow-none"
                                                    for="permission-group-type-user">{{ Status::getTitle($type->value) }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 border-bottom pb-3">
                                <div class="row">
                                    <label class="form-label col-md-3 fw-semibold mb-0 align-self-center"
                                        for="tag">{{ __('usertag.update.form.tag.label') }}</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-text rounded-0 shadow-none bg-white">
                                                <i class="ri-text"></i>
                                            </span>
                                            <input type="text" id="tag"
                                                placeholder="{{ __('usertag.update.form.tag.placeholder') }}"
                                                class="form-control border-start-0  rounded-0 shadow-none ps-0 @error('name') is-invalid @enderror"
                                                name="name" value="{{ $usertag->name ? $usertag->name : old('name') }}"
                                                required>
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
                                        for="color">{{ __('usertag.update.form.color.label') }}</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-text rounded-0 shadow-none bg-white py-0">
                                                <i class="ri-palette-line"></i>
                                            </span>
                                            <input type="color" id="color"
                                                class="form-control border-start-0 rounded-0 shadow-none" name="color"
                                                value="{{ $usertag->color ? $usertag->color : old('color') }}">
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
                                        for="user-tag-desc">{{ __('usertag.update.form.desc.label') }}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control rounded-0 shadow-none form-control-sm"
                                            id="user-tag-desc" name="desc"
                                            value="{{ $usertag->desc ? $usertag->desc : old('desc') }}"
                                            placeholder="{{ __('usertag.update.form.desc.placeholder') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="offset-md-3 col-md-9">
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <button type="submit"
                                                class="btn add-btn btn-primary btn-sm rounded-0 shadow-none"><i
                                                    class="ri-add-line"></i>
                                                {{ __('usertag.update.form.submit.button.text') }}</button>
                                            @hasrole('Super Admin')
                                                <button type="button" id="user-tag-destroy-button"
                                                    class="btn btn-danger btn-sm rounded-0 shadow-none text-white"><i
                                                        class="ri-delete-bin-3-line"></i>
                                                    {{ __('usertag.update.form.delete.button.text') }}</button>
                                            @endhasrole
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="module">
        const btn = document.querySelector("#user-tag-destroy-button");
        btn.addEventListener('click', (e) => {
            Swal.fire({
                title: "{{ __('usertag.delete.confirm.title') }}",
                text: "{{ __('usertag.delete.confirm.text') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('usertag.delete.confirm.delete.button.text') }}",
                cancelButtonText: "{{ __('usertag.delete.confirm.cancel.button.text') }}",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('panel.user.tag.destroy', $usertag->id) }}",
                        data: {
                            tag: {{ $usertag->id }}
                        },
                        beforeSend: function() {
                            $("#spinner-div").show();
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: "{{ __('usertag.delete.success.title.text') }}",
                                    text: "{{ __('usertag.delete.success.message.text') }}",
                                }).then(function() {
                                    window.location = "{{ route('panel.user.tags') }}";
                                });
                            };
                            if (data.status == 'error') {
                                Swal.fire({
                                    icon: 'warning',
                                    title: "{{ __('usertag.delete.error.title.text') }}",
                                    text: data.message,
                                });
                            };
                        },
                        error: function(data) {
                            console.log(data.message)
                        },
                        complete: function(data) {
                            $("#spinner-div").hide(); //Request is complete so hide spinner
                        }
                    });
                }
            });
        });
    </script>
@endsection
