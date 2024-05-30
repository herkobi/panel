@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'İzinler',
                ])
                @include('admin.roles.roles.partials.page-buttons', [
                    'first_button' => 'İzinler',
                    'first_link' => 'panel.permissions',
                    'second_button' => 'Yeni İzin Ekle',
                    'second_link' => 'panel.permission.create',
                ])
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.roles.partials.navigation')
                    @include('admin.settings.partials.navigation')
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">İzni Düzenle</h1>
                        </div>
                        <form action="{{ route('panel.permission.update', $permission->id) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">İzin Türü</label>
                                    <div class="col">
                                        <div>
                                            <select name="parent_id" class="form-select">
                                                <option value="0" {{ $permission->parent_id == 0 ? 'selected' : '' }}>
                                                    Ana İzin
                                                </option>
                                                @foreach ($mainPermissions as $key => $prm)
                                                    <option value="{{ $prm->id }}"
                                                        {{ $permission->parent_id == $prm->id ? 'selected' : '' }}>
                                                        {{ $prm->desc }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('type')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">İzin Açıklaması</label>
                                    <div class="col">
                                        <input type="text" name="desc"
                                            class="form-control @error('desc') is-invalid @enderror"
                                            value="{{ $permission->desc ? $permission->desc : old('desc') }}"
                                            placeholder="İzin Açıklaması">
                                        @error('desc')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">İzinin görünecek adı</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">İzin</label>
                                    <div class="col">
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ $permission->name ? $permission->name : old('name') }}"
                                            placeholder="İzin">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">İzni giriniz. Örnek: pages create</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="btn-list">
                                    @hasrole('Super Admin')
                                        <a href="#" class="btn btn-outline-danger me-auto" data-bs-toggle="modal"
                                            data-bs-target="#modal-danger">Sil</a>
                                    @endhasrole
                                    <button type="submit" class="btn btn-success">Güncelle</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (Session::has('error') || $errors->any())
        <div class="modal modal-blur fade" id="modal-danger" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-body text-center py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 9v4" />
                            <path
                                d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" />
                            <path d="M12 16h.01" />
                        </svg>
                        <h3>Hata</h3>
                        @if ($errors->any())
                            <div class="text-secondary">
                                <ul class="list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="text-secondary">{{ Session::get('error') }}</div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <div class="w-100 text-center">
                            <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                Kapat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="module">
            var errorModal = new bootstrap.Modal(document.getElementById('modal-danger'), {})
            errorModal.toggle()
        </script>
    @endif
    <div class="modal modal-blur fade" id="modal-danger" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 9v4" />
                        <path
                            d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" />
                        <path d="M12 16h.01" />
                    </svg>
                    <h3>Emin misiniz?</h3>
                    <div class="text-secondary">Bu işlem geri alınamaz. Devam etmek istiyor musunuz?
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn w-100" data-bs-dismiss="modal">
                                    İptal Et
                                </a>
                            </div>
                            <div class="col">
                                <form action="{{ route('panel.permission.destroy', $permission->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                        Evet, Devam Et
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection