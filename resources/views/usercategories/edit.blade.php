@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => 'Kullanıcı Kategorileri'])
    <div class="page-content position-relative activity-page mb-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card rounded-0 shadow-sm border-0 mb-3">
                    <div class="card-header border-0 bg-white pt-3 pb-3">
                        <h4 class="card-title mb-0">Etiket Ekle</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.user.tag.update', $usertag->id) }}" method="post">
                            @csrf
                            <div class="mb-3 border-bottom pb-3">
                                <div class="row">
                                    <label class="form-label col-md-3 fw-semibold mb-0 align-self-center"
                                        for="tag">Etiket</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-text rounded-0 shadow-none bg-white">
                                                <i class="ri-text"></i>
                                            </span>
                                            <input type="text" id="tag" placeholder="Etiket"
                                                class="form-control border-start-0  rounded-0 shadow-none ps-0 @error('name') is-invalid @enderror"
                                                name="name" value="{{ $usertag->name ? $usertag->name : old('name') }}"
                                                required>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 border-bottom pb-3">
                                <div class="row">
                                    <label class="form-label col-md-3 fw-semibold mb-0 align-self-center"
                                        for="color">Renk</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-text rounded-0 shadow-none bg-white py-0">
                                                <i class="ri-palette-line"></i>
                                            </span>
                                            <input type="color" id="color"
                                                class="form-control border-start-0 rounded-0 shadow-none" name="color"
                                                value="{{ $usertag->color ? $usertag->color : old('color') }}">
                                            @error('color')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 border-bottom pb-3">
                                <div class="row">
                                    <label class="form-label col-md-3 fw-semibold mb-0 align-self-start"
                                        for="user-tag-desc">Açıklama</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control rounded-0 shadow-none form-control-sm"
                                            id="user-tag-desc" name="desc"
                                            value="{{ $usertag->desc ? $usertag->desc : old('desc') }}"
                                            placeholder="Etiketle İlgili Kısa Açıklama">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="offset-md-3 col-md-9">
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <button type="submit"
                                                class="btn add-btn btn-primary btn-sm rounded-0 shadow-none"><i
                                                    class="ri-add-line"></i> Güncelle</button>
                                            @hasrole('Super Admin')
                                                <button type="button" id="user-tag-destroy-button"
                                                    class="btn btn-danger btn-sm rounded-0 shadow-none text-white" onclick="event.preventDefault(); document.getElementById('user-tag-destroy').submit()"><i
                                                        class="ri-delete-bin-3-line"></i> Etiketi Sil</button>
                                            @endhasrole
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('panel.user.tag.destroy', $usertag->id) }}" method="POST" id="user-tag-destroy">
        @csrf
    </form>
@endsection
