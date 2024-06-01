@extends('layouts.panel')
@section('content')
    <div class="page-header d-print-none text-white">
        <div class="container">
            <div class="row g-2 align-items-center">
                @include('admin.layout.page-header', [
                    'subtitle' => 'Herkobi',
                    'title' => 'Yetkiler',
                ])
                @include('admin.roles.roles.partials.page-buttons', [
                    'first_button' => 'Yetkiler',
                    'first_link' => 'panel.roles',
                    'second_button' => 'Yeni Yetki Ekle',
                    'second_link' => 'panel.role.create',
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
                            <h1 class="card-title">Yetki Bilgilerini Düzenle</h1>
                        </div>
                        <form action="{{ route('panel.role.update', $role->id) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Durum</label>
                                    <div class="col">
                                        <div>
                                            @foreach (Status::cases() as $type)
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status"
                                                        value="{{ $type->value }}"
                                                        {{ $role->status->value == $type->value ? 'checked' : '' }}>
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
                                    <label class="col-3 col-form-label required">Yetki Türü</label>
                                    <div class="col">
                                        <div>
                                            @foreach (UserType::cases() as $type)
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="type"
                                                        value="{{ $type->value }}"
                                                        {{ $role->type->value == $type->value ? 'checked' : '' }}>
                                                    <span
                                                        class="form-check-label">{{ UserType::getTitle($type->value) }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                        @error('type')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Yetki Adı</label>
                                    <div class="col">
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ $role->name ? $role->name : old('name') }}" placeholder="Yetki Adı">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">Yetki adını giriniz. Örnek: Admin</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">Açıklama</label>
                                    <div class="col">
                                        <input type="text" name="desc"
                                            class="form-control @error('desc') is-invalid @enderror"
                                            value="{{ $role->desc ? $role->desc : old('desc') }}" placeholder="Açıklama">
                                        @error('desc')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <small class="form-hint">Yetki ile ilgili kısa açıklama</small>
                                    </div>
                                </div>
                            </div>
                            @if (config('panel.userrole') != $role->id && config('panel.adminrole') != $role->id)
                                <div class="card-footer">
                                    <div class="btn-list">
                                        @hasrole('Super Admin')
                                            <a href="#" class="btn btn-outline-danger me-auto" data-bs-toggle="modal"
                                                data-bs-target="#modal-danger">Sil</a>
                                        @endhasrole
                                        <button type="submit" class="btn btn-success">Güncelle</button>
                                    </div>
                                </div>
                            @else
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-success">Güncelle</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                <form action="{{ route('panel.role.destroy', $role->id) }}" method="POST">
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
