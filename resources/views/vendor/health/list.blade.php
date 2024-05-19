@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Araçlar',
                    'title' => 'Sistem Bilgisi',
                ])
                @include('admin.tools.partials.page-buttons', [
                    'second_button' => 'Yenile',
                    'second_link' => 'panel.tools.fresh',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.tools.partials.navigation')
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <h1 class="card-title lh-1">Sistem Durumu</h1>
                                @if ($lastRanAt)
                                    <div
                                        class="{{ $lastRanAt->diffInMinutes() > 5 ? 'text-red' : 'text-cyan' }} text-sm text-center fw-medium">
                                        {{ __('health::notifications.check_results_from') }}
                                        {{ $lastRanAt->diffForHumans() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if (count($checkResults?->storedCheckResults ?? []))
                                <div class="row g-3">
                                    @foreach ($checkResults->storedCheckResults as $result)
                                        <div class="col-6">
                                            <div class="row g-3 align-items-start">
                                                <div class="col-auto">
                                                    <span class="avatar">
                                                        @if ('failed' == $result->status)
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-copy-x text-red">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path stroke="none" d="M0 0h24v24H0z" />
                                                                <path
                                                                    d="M7 9.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                                <path
                                                                    d="M4.012 16.737a2 2 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                                                <path d="M11.5 11.5l4.9 5" />
                                                                <path d="M16.5 11.5l-5.1 5" />
                                                            </svg>
                                                            <span class="badge bg-red"></span>
                                                        @else
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-box text-green">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                                                                <path d="M12 12l8 -4.5" />
                                                                <path d="M12 12l0 9" />
                                                                <path d="M12 12l-8 -4.5" />
                                                            </svg>
                                                            <span class="badge bg-green"></span>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="col text-truncate">
                                                    <div class="text-reset d-block text-truncate">{{ $result->label }}</div>
                                                    <div class="text-secondary text-truncate mt-n1 white-space-normal">
                                                        @if (!empty($result->notificationMessage))
                                                            {{ $result->notificationMessage }}
                                                        @else
                                                            {{ $result->shortSummary }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
