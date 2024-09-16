@extends('layouts.panel')
@section('content')
    @include('admin.include.header', [
        'title' => 'Araçlar',
    ])
    <div class="page-content flex-grow-1 d-flex flex-column shadow-sm">
        <div class="row flex-grow-1">
            <div class="col-20 col-lg-3 col-md-3">
                <div class="page-menu rounded-2 mb-3">
                    @include('admin.tools.include.navigation')
                </div>
                <div class="list-group rounded-none div-scroll mb-4">
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                <path d="M7 11l5 5l5 -5" />
                                <path d="M12 4l0 12" />
                            </svg>
                            Dosyayı İndir
                        </a>
                        @if (Auth::user()->type == UserType::SUPER)
                            <a id="clean-log" class="list-group-item px-2 py-1"
                                href="?clean={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ $current_folder ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 3l18 18" />
                                    <path d="M7 3h7l5 5v7m0 4a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-14" />
                                </svg> Dosyayı Boşalt
                            </a>
                            <a id="delete-log" class="list-group-item px-2 py-1"
                                href="?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ $current_folder ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 7l16 0" />
                                    <path d="M10 11l0 6" />
                                    <path d="M14 11l0 6" />
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                </svg> Dosyayı Sil
                            </a>
                            @if (count($files) > 1)
                                <a id="delete-all-log" class="list-group-item px-2 py-1"
                                    href="?delall=true{{ $current_folder ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon">
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
                    @endif
                </div>
            </div>
            <div class="col-80 col-lg-9 col-md-9">
                <div class="card h-100 border-0 mb-5">
                    <div class="card-header border-0 bg-white p-0 mb-3">
                        <div class="d-flex align-items-center justify-content-between w-100 border-bottom pb-2">
                            <h1 class="card-title">İşlem Kayıtları</h1>
                        </div>
                    </div>
                    <div class="table-responsive">
                        @if ($logs === null)
                            <div>
                                Log file >50M, please download it.
                            </div>
                        @else
                            <table id="table-log" class="table table-striped">
                                <thead>
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
