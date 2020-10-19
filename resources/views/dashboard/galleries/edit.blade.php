@extends('layouts.dashboard.app')

@section('title', __('Publicaciones - Galería - :title', ['title' => $gallery->title]))

@section('breadcrumb')
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                {{ __('Blog') }}
            </li>
            <li class="breadcrumb-item">
                {{ __('Publicaciones') }}
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.galleries.index') }}" title="{{ __('Galería') }}">{{ __('Galería') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('Nueva Imagen') }}
            </li>
        </ol>
    </nav>
    <h4 class="mg-b-0 tx-spacing--1">
        {{ __('Nueva Imagen') }}
    </h4>
</div>
<div>
    <a href="{{ route('dashboard.galleries.index') }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
        <i data-feather="x" class="wd-10 mg-r-5"></i> {{ __('Cancelar') }}
    </a>
    <button type="submit" class="btn btn-sm pd-x-15 btn-info btn-uppercase mg-l-5" id="galleries-update-form-submit-button"
    data-content-before-submit='<i data-feather="save" class="wd-10 mg-r-5"></i> {{ __('Guardar Cambios') }}'
    data-content-after-submit='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __('Cargando...') }}'>
    <i data-feather="save" class="wd-10 mg-r-5"></i> {{ __('Guardar Cambios') }}
</div>
@endsection

@section('content')
<form id="galleries-update-form" action="{{ route('dashboard.galleries.update', compact('gallery')) }}" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="row row-xs">
        <div class="col-sm-12 col-lg-12">
            <div class="card card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label for="title">{{ __('Título') }}</label>
                            <input id="title" name="title" type="text" class="form-control {{ $errors->first('title', 'is-invalid') }}" placeholder="{{ __('Titulo De La Publicación') }}" value="{{ old('title', $gallery->title) }}" required>
                            {!! $errors->first('title', '<label id="title-error" for="title" class="text-danger">:message</label>') !!}
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('Descripción Breve') }}</label>
                            <textarea id="description" name="description" type="text" class="form-control {{ $errors->first('description', 'is-invalid') }}" placeholder="{{ __('Titulo De La Publicación') }}" rows="8">{{ old('description', $gallery->description) }}</textarea>
                            {!! $errors->first('title', '<label id="title-error" for="title" class="text-danger">:message</label>') !!}
                        </div>
                        <div class="form-group">
                            <label for="tags">{{ __('Tags') }}</label>
                            <select class="form-control" id="tags" name="tags[]" data-role="tagsinput" multiple data-tags='@json($availabletags)'>
                                @isset ($gallery->tags)
                                @foreach ($gallery->tags as $tag) <option value="{{ $tag }}">{{ $tag }}</option> @endforeach
                                @endisset
                            </select>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="form-group">
                            <label for="cover">{{ __('Portada') }}</label>
                            <input type="file" id="cover" name="cover_file" class="dropify" data-height="255" data-allowed-file-extensions="jpeg jpg png" data-max-file-size="5M" data-default-file={{ $gallery->image->public_url }}>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
