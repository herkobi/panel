@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Ödeme Yöntemleri',
                ])
                @include('admin.settings.payments.partials.page-buttons', [
                    'first_button' => 'Ödeme Yöntemleri',
                    'first_link' => 'panel.settings.payments',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.settings.payments.partials.payments')
                    @include('admin.settings.partials.navigation')
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">Ödeme Yöntemleri</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-40">Ödeme Yöntemi</th>
                                        <th class="w-40">Açıklama</th>
                                        <th class="w-20">Bilgiler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td class="fw-bold">{{ $payment->title }}</td>
                                            <td>{{ $payment->desc }}</td>
                                            <td>
                                                @if (auth()->user()->can('gateway.update'))
                                                    <a href="{{ route('panel.gateways.' . $payment->code) }}"
                                                        class="btn btn-ghost-primary btn-sm" title="Bilgiler">
                                                        Bilgiler
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center pb-1 text-end w-100">
                            {{ $payments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
