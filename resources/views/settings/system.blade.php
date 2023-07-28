@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => 'Sistem Ayarları'])
    <div class="page-content position-relative mb-4">
        <div class="page-content position-relative mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card rounded-0 shadow-sm border-0 mb-3">
                        <div class="card-header border-0 bg-white pt-3 pb-3">
                            <h4 class="card-title mb-0">Sistem Ayarları</h4>
                            <small>Sisteme özgü ayarlardır. Eğer kullanıcı kendi ayarlarında bir değişiklik yapmazsa bu
                                ayarlar geçerli olur.</small>
                        </div>
                        <div class="card-body">
                            <form id="system-settings-form" action="" method="post">
                                @csrf
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="system-user-role-settings"
                                            class="col-md-4 fw-bold align-self-center">Genel
                                            Kullanıcı Yetkisi</label>
                                        <div id="system-user-role-settings" class="col-md-8">
                                            <select class="form-select form-select-sm rounded-0 shadow-none" name="userrole"
                                                id="system-user-role">
                                                <option>Seçiniz</option>
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
                                            class="col-md-4 fw-bold align-self-center">Genel Yönetici Yetkisi</label>
                                        <div id="system-admin-role-settings" class="col-md-8">
                                            <select class="form-select form-select-sm rounded-0 shadow-none"
                                                name="adminrole" id="system-admin-role">
                                                <option>Seçiniz</option>
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
                                            class="col-md-4 fw-bold align-self-center">Sistem
                                            Dili</label>
                                        <div id="system-language-settings" class="col-md-8">
                                            <select class="form-select form-select-sm rounded-0 shadow-none" name="language"
                                                id="system-language">
                                                <option>Seçiniz</option>
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
                                            class="col-md-4 fw-bold align-self-start">Zaman
                                            Dilimi</label>
                                        <div id="system-timezone-settings" class="col-md-8">
                                            <select id="system-timezone" name="timezone"
                                                class="form-select form-select-sm rounded-0 shadow-none"
                                                data-control="select2" data-placeholder="Seçiniz..">
                                                <option></option>
                                                @foreach (Helper::getTimeZoneList() as $timezone => $timezone_gmt_diff)
                                                    <option value="{{ $timezone }}"
                                                        {{ $timezone === old('timezone', $default_settings['timezone']) ? 'selected' : '' }}>
                                                        {{ $timezone_gmt_diff }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small>Kendi zaman diliminizde yer alan bir şehir ya da bir UTC zaman dilimi
                                                seçin.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="system-date-settings" class="col-md-4 fw-bold align-self-start">Tarih
                                            Formatı</label>
                                        <div id="system-date-settings" class="col-md-8">
                                            <div class="list-group list-group-flush">
                                                @foreach (Helper::dateformats() as $format)
                                                    <label class="list-group-item bg-white rounded-0 w-75">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div>
                                                                <input name="date"
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
                                        <label for="system-time-settings" class="col-md-4 fw-bold align-self-start">Saat
                                            Formatı</label>
                                        <div id="system-time-settings" class="col-md-8">
                                            <div class="list-group list-group-flush">
                                                @foreach (Helper::timeformats() as $format)
                                                    <label class="list-group-item bg-white rounded-0 w-75">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div>
                                                                <input name="time"
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
                                                    class="ri-add-line"></i> Kaydet</button>
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
    <script>
        var date, time;

        function sendAjaxRequest(urlToSend, userrole, adminrole, language, timezone, date, time) {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: urlToSend,
                data: {
                    userrole: userrole,
                    adminrole: adminrole,
                    language: language,
                    timezone: timezone,
                    date: date,
                    time: time
                },
                success: function(data) {
                    if (data.status == 'success') {
                        console.log('Eferim');
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }

        const btn = document.querySelector("#save-system-settings-form");
        btn.addEventListener('click', (e) => {

            const userrole = document.getElementsByName("userrole")[0].value;
            const adminrole = document.getElementsByName("adminrole")[0].value;
            const language = document.getElementsByName("language")[0].value;
            const timezone = document.getElementsByName("timezone")[0].value;
            const dateRadio = document.getElementsByName('date');
            const timeRadio = document.getElementsByName('time');

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

            sendAjaxRequest('{{ route('panel.system.update.settings') }}', userrole, adminrole, language, timezone,
                date, time);
        });
    </script>
@endsection
