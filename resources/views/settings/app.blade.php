@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => 'Genel Ayarlar'])
    <div class="page-content position-relative mb-4">
        <div class="page-content position-relative mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card rounded-0 shadow-sm border-0 mb-3">
                        <div class="card-header border-0 bg-white pt-3 pb-3">
                            <h4 class="card-title mb-0">Genel Ayarlar</h4>
                            <small>Kullanıcı bazlı genel ayarlar. Her kullanıcı kendine özgü ayarlarla sistemi
                                kullanabilir.</small>
                        </div>
                        <div class="card-body">
                            <form id="app-settings-form" action="" method="post">
                                @csrf
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="app-language-settings" class="col-md-4 fw-bold align-self-center">Sistem
                                            Dili</label>
                                        <div id="app-language-settings" class="col-md-8">
                                            <select class="form-select form-select-sm rounded-0 shadow-none" name="language"
                                                id="app-language">
                                                <option selected>Seçiniz</option>
                                                @foreach (config('app.available_locales') as $key => $locale)
                                                    <option value="{{ $locale }}"
                                                        {{ $locale == $user_settings['language'] ? 'selected' : '' }}>
                                                        {{ $key }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="app-timezone-settings" class="col-md-4 fw-bold align-self-start">Zaman
                                            Dilimi</label>
                                        <div id="app-timezone-settings" class="col-md-8">
                                            <select class="form-select form-select-sm rounded-0 shadow-none" name="timezone"
                                                id="app-timezone">
                                                <option selected>Seçiniz</option>
                                                @foreach (Helper::getTimeZoneList() as $timezone => $timezone_gmt_diff)
                                                    <option value="{{ $timezone }}"
                                                        {{ $timezone === old('timezone', $user_settings['timezone']) ? 'selected' : '' }}>
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
                                        <label for="user-date-settings" class="col-md-4 fw-bold align-self-start">Tarih
                                            Formatı</label>
                                        <div id="user-date-settings" class="col-md-8">
                                            <div class="list-group list-group-flush">
                                                @foreach (Helper::dateformats() as $format)
                                                    <label class="list-group-item bg-white rounded-0 w-75">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div>
                                                                <input id="user-date-{{ $format }}" name="date"
                                                                    class="form-check-input me-1 rounded-0 shadow-none"
                                                                    type="radio" value="{{ $format }}"
                                                                    {{ $format == $user_settings['date'] ? 'checked' : '' }}>
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
                                        <label for="user-time-settings" class="col-md-4 fw-bold align-self-start">Saat
                                            Formatı</label>
                                        <div id="user-time-settings" class="col-md-8">
                                            <div class="list-group list-group-flush">
                                                @foreach (Helper::timeformats() as $format)
                                                    <label for="user-time-{{ $format }}"
                                                        class="list-group-item bg-white rounded-0 w-75">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div>
                                                                <input id="user-time-{{ $format }}" name="time"
                                                                    class="form-check-input me-1 rounded-0 shadow-none"
                                                                    type="radio" value="{{ $format }}"
                                                                    {{ $format == $user_settings['time'] ? 'checked' : '' }}>
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
                                            <button id="save-app-settings-form" type="button"
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

        function sendAjaxRequest(urlToSend, datas) {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: urlToSend,
                data: {
                    data: datas
                },
                success: function(result) {
                    window.location.reload();
                },
                error: function(result) {
                    alert('error');
                }
            });
        }

        const btn = document.querySelector("#save-app-settings-form");
        btn.addEventListener('click', (e) => {

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

            const settings = {
                language: document.getElementsByName("language")[0].value,
                timezone: document.getElementsByName("timezone")[0].value,
                date: date,
                time: time
            }
            sendAjaxRequest('{{ route('panel.system.update.user.settings') }}', settings);
        });
    </script>
@endsection
