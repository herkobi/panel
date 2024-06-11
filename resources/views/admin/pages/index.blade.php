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
                    'second_button' => __('admin/pages/pages.create.button'),
                    'second_link' => 'panel.page.create',
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
                            <h1 class="card-title">Sayfalar</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-5">Durum</th>
                                        <th class="w-80">Sayfa Adı</th>
                                        <th class="w-15"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pages as $page)
                                        <tr>
                                            <td>
                                                @if ($page->status->value == 1)
                                                    <span
                                                        class="badge bg-green text-green-fg">{{ Status::title($page->status) }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-red text-red-fg">{{ Status::title($page->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="fw-bold">{{ $page->title }}</td>
                                            <td class="text-center">
                                                @if (auth()->user()->can('page.update'))
                                                    <a href="{{ route('panel.page.edit', $page->id) }}"
                                                        class="btn btn-ghost-primary btn-sm">
                                                        Düzenle
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center pb-1 text-end w-100">
                            {{ $pages->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
