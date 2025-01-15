@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Araçlar',
    ])
    @include('admin.tools.include.navigation')
    <div class="page-content">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-3">
                    @include('admin.tools.include.sidebar')
                    <div class="list-group rounded-none div-scroll mb-3">
                        <h4 class="border-bottom mb-2 pb-2">Dosyalar</h4>
                        @foreach ($folders as $folder)
                            <div class="list-group-item px-2 py-1">
                                <?php
                                \Rap2hpoutre\LaravelLogViewer\LaravelLogViewer::DirectoryTreeStructure($storage_path, $structure);
                                ?>
                            </div>
                        @endforeach
                        @foreach ($files as $file)
                            <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}"
                                class="list-group-item px-2 py-1 @if ($current_file == $file) llv-active @endif">
                                {{ $file }}
                            </a>
                        @endforeach
                    </div>
                    <div class="list-group rounded-none div-scroll mb-4">
                        <h4 class="border-bottom mb-2 pb-2">İşlemler</h4>
                        @if ($current_file)
                            <a class="list-group-item px-2 py-1"
                                href="?dl={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ $current_folder ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-download me-2" viewBox="0 0 16 16">
                                    <path
                                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                    <path
                                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                                </svg>
                                Dosyayı İndir
                            </a>
                            @if (Auth::user()->type == UserType::SUPER)
                                <a id="clean-log" class="list-group-item px-2 py-1"
                                    href="?clean={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ $current_folder ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-file-earmark me-2" viewBox="0 0 16 16">
                                        <path
                                            d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z" />
                                    </svg>
                                    Dosyayı Boşalt
                                </a>
                                <a id="delete-log" class="list-group-item px-2 py-1"
                                    href="?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ $current_folder ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-file-earmark-x me-2" viewBox="0 0 16 16">
                                        <path
                                            d="M6.854 7.146a.5.5 0 1 0-.708.708L7.293 9l-1.147 1.146a.5.5 0 0 0 .708.708L8 9.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 9l1.147-1.146a.5.5 0 0 0-.708-.708L8 8.293z" />
                                        <path
                                            d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                                    </svg>
                                    Dosyayı Sil
                                </a>
                                @if (count($files) > 1)
                                    <a id="delete-all-log" class="list-group-item px-2 py-1"
                                        href="?delall=true{{ $current_folder ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash me-2" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                            <path
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                        </svg>
                                        Tüm Dosyaları Sil
                                    </a>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row align-items-center mb-2">
                        <div class="col-lg-6">
                            <h2>Sistem Kayıtları</h2>
                        </div>
                    </div>
                    <div class="table-responsive">
                        @if ($logs === null)
                            <div>
                                Log file >50M, please download it.
                            </div>
                        @else
                            <table id="table-log" class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        @if ($standardFormat)
                                            <th>Level</th>
                                            <th>Context</th>
                                            <th>Date</th>
                                        @else
                                            <th>Line number</th>
                                        @endif
                                        <th>Content</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $key => $log)
                                        <tr data-display="stack{{ $key }}">
                                            @if ($standardFormat)
                                                <td class="nowrap text-{{ $log['level_class'] }}">
                                                    <span class="fa fa-{{ $log['level_img'] }}"
                                                        aria-hidden="true"></span>&nbsp;&nbsp;{{ $log['level'] }}
                                                </td>
                                                <td class="text">{{ $log['context'] }}</td>
                                            @endif
                                            <td class="date">{{ $log['date'] }}</td>
                                            <td class="text">
                                                {{ $log['text'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
