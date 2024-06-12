@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Araçlar',
                    'title' => 'Sistem Kayıtları',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.tools.partials.navigation')
                    <div class="dropdown-menu panel-dropdown shadow-none mb-3">
                        <span class="dropdown-header">Log Dosyaları</span>
                        @foreach ($folders as $folder)
                            <div class="dropdown-item">
                                <?php
                                \Rap2hpoutre\LaravelLogViewer\LaravelLogViewer::DirectoryTreeStructure($storage_path, $structure);
                                ?>
                            </div>
                        @endforeach
                        @foreach ($files as $file)
                            <a class="dropdown-item" href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}"
                                @if ($current_file == $file) llv-active @endif">
                                {{ $file }}
                            </a>
                        @endforeach
                    </div>
                    <div class="dropdown-menu panel-dropdown shadow-none mb-3">
                        <span class="dropdown-header">İşlemler</span>
                        @if ($current_file)
                            <a class="dropdown-item"
                                href="?dl={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ $current_folder ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon dropdown-item-icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                    <path d="M7 11l5 5l5 -5" />
                                    <path d="M12 4l0 12" />
                                </svg>
                                Dosyayı İndir
                            </a>
                            <a id="clean-log" class="dropdown-item"
                                href="?clean={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ $current_folder ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon dropdown-item-icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 3l18 18" />
                                    <path d="M7 3h7l5 5v7m0 4a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-14" />
                                </svg> Dosyayı Boşalt
                            </a>
                            <a id="delete-log" class="dropdown-item"
                                href="?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ $current_folder ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon dropdown-item-icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 7l16 0" />
                                    <path d="M10 11l0 6" />
                                    <path d="M14 11l0 6" />
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                </svg> Dosyayı Sil
                            </a>
                            @if (count($files) > 1)
                                <a id="delete-all-log" class="dropdown-item"
                                    href="?delall=true{{ $current_folder ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon dropdown-item-icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 3l18 18" />
                                        <path d="M4 7h3m4 0h9" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 14l0 3" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l.077 -.923" />
                                        <path d="M18.384 14.373l.616 -7.373" />
                                        <path d="M9 5v-1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg> Tüm Dosyaları Sil
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <h1 class="card-title lh-1">Sistem Kayıtları</h1>
                            </div>
                        </div>
                        @if ($logs === null)
                            <div class="card-body p-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-100" preserveAspectRatio="none"
                                    width="400" height="200" viewBox="0 0 400 200" fill="transparent"
                                    stroke="var(--tblr-border-color, #b8cef1)">
                                    <line x1="0" y1="0" x2="400" y2="200"></line>
                                    <line x1="0" y1="200" x2="400" y2="0"></line>
                                </svg>
                                <div>
                                    Dosya boyutu 50 megabyte'tan büyük. Lütfen dosyayı indirin.
                                </div>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table card-table table-start">
                                    <thead>
                                        <tr>
                                            <th class="w-25">Level</th>
                                            <th class="w-20">Context</th>
                                            <th class="w-15">Content</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logs as $key => $log)
                                            <tr>
                                                <td class="nowrap text-{{ $log['level_class'] }}">
                                                    <span class="fa fa-{{ $log['level_img'] }}"
                                                        aria-hidden="true"></span>&nbsp;&nbsp;{{ $log['level'] }}
                                                </td>
                                                <td>{{ $log['context'] }}<br>{{ $log['date'] }}</td>
                                                <td class="text">
                                                    @if ($log['stack'])
                                                        <button type="button"
                                                            class="float-right expand btn btn-outline-dark btn-sm mb-2 ml-2"
                                                            data-display="stack{{ $key }}">
                                                            <span class="fa fa-search"></span>
                                                        </button>
                                                    @endif
                                                    {{ $log['text'] }}
                                                    @if (isset($log['in_file']))
                                                        <br />{{ $log['in_file'] }}
                                                    @endif
                                                    @if ($log['stack'])
                                                        <div class="stack" id="stack{{ $key }}"
                                                            style="display: none; white-space: pre-wrap;">
                                                            {{ trim($log['stack']) }}
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
