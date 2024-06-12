@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => config('panel.title'),
                    'title' => __('admin/pages/pages.main.title'),
                ])
                @include('admin.pages.partials.page-buttons', [
                    'first_button' => __('admin/pages/pages.main.button'),
                    'first_link' => 'panel.pages',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.pages.partials.navigation')
                    @include('admin.settings.partials.navigation')
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">{{ __('admin/pages/create.page.title') }}</h1>
                        </div>
                        <form action="{{ route('panel.page.create.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label
                                        class="col-3 col-form-label required">{{ __('admin/pages/create.form.status.label') }}</label>
                                    <div class="col">
                                        <div>
                                            @foreach (Status::cases() as $type)
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status"
                                                        value="{{ $type->value }}"
                                                        {{ 1 == $type->value ? 'checked' : '' }}>
                                                    <span
                                                        class="form-check-label">{{ Status::getTitle($type->value) }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label
                                        class="col-3 col-form-label required">{{ __('admin/pages/create.form.title.label') }}</label>
                                    <div class="col">
                                        <input type="text" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}"
                                            placeholder="{{ __('admin/pages/create.form.title.placeholder') }}">
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">{{ __('admin/pages/create.form.title.helper') }}</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label
                                        class="col-3 col-form-label required">{{ __('admin/pages/create.form.text.label') }}</label>
                                    <div class="col">
                                        <textarea id="editor" name="text" class="form-control @error('text') is-invalid @enderror" rows="10"
                                            placeholder="{{ __('admin/pages/create.form.text.placeholder') }}">{{ old('text') }}</textarea>
                                        @error('text')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">{{ __('admin/pages/create.form.text.helper') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit"
                                    class="btn btn-primary">{{ __('admin/pages/create.form.submit.button') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
