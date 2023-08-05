@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => __('systemsettings.page.title')])
    <div class="page-content position-relative mb-4">
        <div class="page-content position-relative mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card rounded-0 shadow-sm border-0 mb-3">
                        <div class="card-header border-0 bg-white pt-3 pb-3">
                            <h4 class="card-title mb-0">{{ __('systemsettings.card.title') }}</h4>
                            <small>{{ __('systemsettings.card.desc') }}</small>
                        </div>
                        <div class="card-body">
                            <form id="system-settings-form" action="" method="post">
                                @csrf
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="system-user-role-settings"
                                            class="col-md-4 fw-bold align-self-start">{{ __('systemsettings.usersettings.activate.label') }}</label>
                                        <div id="system-user-role-settings" class="col-md-8">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" name="usersettings" role="switch"
                                                    class="form-check-input shadow-none" id="userSettings"
                                                    value="{{ $default_settings['usersettings'] }}"
                                                    {{ $default_settings['usersettings'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label d-none"
                                                    for="userSettings">{{ __('systemsettings.usersettings.activate.active') }}</label>
                                            </div>
                                            <small>{{ __('systemsettings.usersettings.activate.desc') }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="system-user-role-settings"
                                            class="col-md-4 fw-bold align-self-center">{{ __('systemsettings.default.user.role.label') }}</label>
                                        <div id="system-user-role-settings" class="col-md-8">
                                            <select class="form-select form-select-sm rounded-0 shadow-none" name="userrole"
                                                id="defaultUserRole">
                                                <option>{{ __('systemsettings.default.user.role.selectbox.placeholder') }}
                                                </option>
                                                @foreach ($user_roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ $role->id == $default_settings['userrole'] ? 'selected' : '' }}>
                                                        {{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="system-admin-role-settings"
                                            class="col-md-4 fw-bold align-self-center">{{ __('systemsettings.default.admin.role.label') }}</label>
                                        <div id="system-admin-role-settings" class="col-md-8">
                                            <select class="form-select form-select-sm rounded-0 shadow-none"
                                                name="adminrole" id="defaultAdminRole">
                                                <option>{{ __('systemsettings.default.admin.role.selectbox.placeholder') }}
                                                </option>
                                                @foreach ($admin_roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ $role->id == $default_settings['adminrole'] ? 'selected' : '' }}>
                                                        {{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="system-language-settings"
                                            class="col-md-4 fw-bold align-self-center">{{ __('systemsettings.default.language.label') }}</label>
                                        <div id="system-language-settings" class="col-md-8">
                                            <select class="form-select form-select-sm rounded-0 shadow-none" name="language"
                                                id="defaultLanguage">
                                                <option>{{ __('systemsettings.default.language.selectbox.placeholder') }}
                                                </option>
                                                @foreach (config('app.available_locales') as $key => $locale)
                                                    <option value="{{ $locale }}"
                                                        {{ $locale == $default_settings['language'] ? 'selected' : '' }}>
                                                        {{ $key }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="system-timezone-settings"
                                            class="col-md-4 fw-bold align-self-start">{{ __('systemsettings.default.timezone.label') }}</label>
                                        <div id="system-timezone-settings" class="col-md-8">
                                            <select id="defaultTimezone" name="timezone"
                                                class="form-select form-select-sm rounded-0 shadow-none"
                                                data-control="select2"
                                                data-placeholder="{{ __('systemsettings.default.timezone.selectbox.placeholder') }}">
                                                <option>{{ __('systemsettings.default.timezone.selectbox.placeholderc') }}
                                                </option>
                                                @foreach (Helper::getTimeZoneList() as $timezone => $timezone_gmt_diff)
                                                    <option value="{{ $timezone }}"
                                                        {{ $timezone === old('timezone', $default_settings['timezone']) ? 'selected' : '' }}>
                                                        {{ $timezone_gmt_diff }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small>{{ __('systemsettings.default.timezone.desc') }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="system-date-settings"
                                            class="col-md-4 fw-bold align-self-start">{{ __('systemsettings.date.format.label') }}</label>
                                        <div id="system-date-settings" class="col-md-8">
                                            <div class="list-group list-group-flush">
                                                @foreach (Helper::dateformats() as $format)
                                                    <label class="list-group-item bg-white rounded-0 w-75">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div>
                                                                <input name="date" id="defaultDateFormat"
                                                                    class="form-check-input me-1 rounded-0 shadow-none"
                                                                    type="radio" value="{{ $format }}"
                                                                    {{ $format == $default_settings['date'] ? 'checked' : '' }}>
                                                                {{ Carbon::now()->format($format) }}
                                                            </div>
                                                            <code>{{ $format }}</code>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="system-time-settings"
                                            class="col-md-4 fw-bold align-self-start">{{ __('systemsettings.time.format.label') }}</label>
                                        <div id="system-time-settings" class="col-md-8">
                                            <div class="list-group list-group-flush">
                                                @foreach (Helper::timeformats() as $format)
                                                    <label class="list-group-item bg-white rounded-0 w-75">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div>
                                                                <input name="time" id="defaultTimeFormat"
                                                                    class="form-check-input me-1 rounded-0 shadow-none"
                                                                    type="radio" value="{{ $format }}"
                                                                    {{ $format == $default_settings['time'] ? 'checked' : '' }}>
                                                                {{ Carbon::now()->format($format) }}
                                                            </div>
                                                            <code>{{ $format }}</code>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="offset-md-4 col-md-5">
                                            <button id="save-system-settings-form" type="button"
                                                class="btn add-btn btn-primary btn-sm rounded-0 shadow-none"><i
                                                    class="ri-add-line"></i>
                                                {{ __('systemsettings.submit.button.text') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
            $("#userSettings").change(function() {
                if ($(this).is(":checked")) {
                    $(".form-check-label").removeClass('d-none');
                    $(".form-check-label").addClass('d-block');
                } else {
                    $(".form-check-label").removeClass('d-block');
                    $(".form-check-label").addClass('d-none');
                }
            });
        });
    </script>
    <script>
        var date, time;

        function sendAjaxRequest(urlToSend, usersettings, userrole, adminrole, language, timezone, date, time) {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: urlToSend,
                data: {
                    usersettings: usersettings,
                    userrole: userrole,
                    adminrole: adminrole,
                    language: language,
                    timezone: timezone,
                    date: date,
                    time: time
                },
                beforeSend: function() {
                    $("#spinner-div").show();
                },
                success: function(data) {
                    if (data.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: "{{ __('systemsettings.update.success.title') }}!",
                            text: "{{ __('systemsettings.update.success.message') }}",
                        }).then(function() {
                            window.location = "{{ route('panel.system.settings') }}";
                        });
                    }
                    if (data.status == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: "{{ __('systemsettings.update.error.title') }}",
                            text: data.message,
                            confirmButtonText: "{{ __('systemsettings.update.error.button.text') }}"
                        })
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                    Swal.fire({
                        icon: 'error',
                        title: "{{ __('systemsettings.update.error.title') }}",
                        text: data.message,
                        confirmButtonText: "{{ __('systemsettings.update.error.button.text') }}"
                    })
                },
                complete: function(data) {
                    $("#spinner-div").hide(); //Request is complete so hide spinner
                }
            });
        }

        const btn = document.querySelector("#save-system-settings-form");
        btn.addEventListener('click', (e) => {

            const userrole = document.getElementById("defaultUserRole").value;
            const adminrole = document.getElementById("defaultAdminRole").value;
            const language = document.getElementById("defaultLanguage").value;
            const timezone = document.getElementById("defaultTimezone").value;
            const dateRadio = document.getElementsByName('date');
            const timeRadio = document.getElementsByName('time');

            var usersettings;
            if ($('#userSettings').is(':checked')) {
                usersettings = '1'
            } else {
                usersettings = '0'
            }

            for (i = 0; i < dateRadio.length; i++) {
                if (dateRadio[i].checked) {
                    date = dateRadio[i].value;
                }
            }

            for (i = 0; i < timeRadio.length; i++) {
                if (timeRadio[i].checked) {
                    time = timeRadio[i].value;
                }
            }

            sendAjaxRequest('{{ route('panel.update.system.settings') }}', usersettings, userrole, adminrole,
                language, timezone, date, time);
        });
    </script>
@endsection
