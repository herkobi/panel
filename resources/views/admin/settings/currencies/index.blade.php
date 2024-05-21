@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Para Birimleri',
                ])
                @include('admin.settings.currencies.partials.page-buttons', [
                    'first_button' => 'Para Birimleri',
                    'first_link' => 'panel.settings.currencies',
                    'second_button' => 'Yeni Para Birimi Ekle',
                    'second_link' => 'panel.settings.currency.create',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.settings.partials.definitions')
                    @include('admin.settings.partials.navigation')
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">Para Birimleri</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-5">Durum</th>
                                        <th class="w-40">Para Birimi</th>
                                        <th class="w-20">Sembol</th>
                                        <th class="w-20">Kod</th>
                                        <th class="w-15"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($currencies as $currency)
                                        <tr>
                                            <td>
                                                @if ($currency->status->value == 1)
                                                    <span
                                                        class="badge bg-green text-green-fg">{{ Status::title($currency->status) }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-red text-red-fg">{{ Status::title($currency->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="fw-bold">{{ $currency->title }}</td>
                                            <td>{{ $currency->symbol }}</td>
                                            <td>{{ $currency->code }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('panel.settings.currency.edit', $currency->id) }}"
                                                    class="btn btn-ghost-primary btn-sm" title="Düzenle">
                                                    Düzenle
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center pb-1 text-end w-100">
                            {{ $currencies->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (Session::has('success'))
        <div class="modal modal-blur fade" id="modal-success" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close rounded-0 shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    <div class="modal-status bg-success"></div>
                    <div class="modal-body text-center py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-green icon-lg" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M9 12l2 2l4 -4" />
                        </svg>
                        <h3>Başarılı</h3>
                        <div class="text-secondary">{{ Session::get('success') }}</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100 text-center">
                            <button type="button" class="btn btn-success mx-auto" data-bs-dismiss="modal">
                                Kapat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="module">
            var successModal = new bootstrap.Modal(document.getElementById('modal-success'), {})
            successModal.toggle()
        </script>
    @endif
@endsection