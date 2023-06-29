@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => 'Genel Ayarlar'])
    <div class="page-content position-relative mb-4">
        <div class="page-content position-relative mb-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="card rounded-0 shadow-sm border-0 mb-3">
                        <div class="card-header border-0 bg-white pt-3 pb-3">
                            <h4 class="card-title mb-0">Genel Ayarlar</h4>
                        </div>
                        <div class="card-body">
                            <form id="user-settings-form" method="post">
                                @csrf
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="user-language-settings"
                                            class="col-md-3 fw-bold align-self-center">Sistem Dili</label>
                                        <div id="user-language-settings" class="col-md-9">
                                            <select class="form-select form-select-sm rounded-0 shadow-none" name="language"
                                                id="user-language">
                                                <option selected>Seçiniz</option>
                                                @foreach (config('app.available_locales') as $key => $locale)
                                                    <option value="{{ $locale }}">{{ $key }}</option>
                                                @endforeach
                                            </select>
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
