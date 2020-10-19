@extends('layouts.dashboard.app')

@section('title', __('Publicaciones - Galería - Nueva Imagen'))

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
    <button type="submit" class="btn btn-sm pd-x-15 btn-success btn-uppercase mg-l-5" id="galleries-create-form-submit-button"
    data-content-before-submit='<i data-feather="save" class="wd-10 mg-r-5"></i> {{ __('Guardar') }}'
    data-content-after-submit='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __('Cargando...') }}'>
    <i data-feather="save" class="wd-10 mg-r-5"></i> {{ __('Guardar') }}
</div>
@endsection

@section('content')
<form id="galleries-create-form" action="{{ route('dashboard.galleries.store') }}" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="row row-xs">
        <div class="col-sm-12 col-lg-12">
            <div class="card card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label for="title">{{ __('Título') }}</label>
                            <input id="title" name="title" type="text" class="form-control {{ $errors->first('title', 'is-invalid') }}" placeholder="{{ __('Titulo de la imagen') }}" value="{{ old('title') }}" required>
                            {!! $errors->first('title', '<label id="title-error" for="title" class="text-danger">:message</label>') !!}
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('Descripción Breve') }}</label>
                            <textarea id="description" name="description" type="text" class="form-control {{ $errors->first('description', 'is-invalid') }}" placeholder="{{ __('Titulo de la imagen') }}" rows="8">{{ old('description') }}</textarea>
                            {!! $errors->first('title', '<label id="title-error" for="title" class="text-danger">:message</label>') !!}
                        </div>
                        <div class="form-group">
                            <label for="tags">{{ __('Tags') }}</label>
                            <select class="form-control" id="tags" name="tags[]" data-role="tagsinput" multiple data-tags='@json($availabletags)'></select>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="form-group">
                            <label for="image">{{ __('Portada') }}</label>
                            <input type="file" id="image" name="image_file" class="dropify" data-height="340" data-allowed-file-extensions="jpeg jpg png" data-max-file-size="5M" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
