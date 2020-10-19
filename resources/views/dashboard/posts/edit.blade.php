@extends('layouts.dashboard.app')

@section('title', __('Publicaciones - :title', ['title' => $post->title]))

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
                <a href="{{ route('dashboard.posts.index') }}" title="{{ __('Publicaciones') }}">{{ __('Publicaciones') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('Nueva Publicación') }}
            </li>
        </ol>
    </nav>
    <h4 class="mg-b-0 tx-spacing--1">
        {{ __('Nueva Publicación') }}
    </h4>
</div>
<div>
    <a href="{{ route('dashboard.posts.index') }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
        <i data-feather="x" class="wd-10 mg-r-5"></i> {{ __('Cancelar') }}
    </a>
    <button type="submit" class="btn btn-sm pd-x-15 btn-info btn-uppercase mg-l-5" id="posts-update-form-submit-button"
    data-content-before-submit='<i data-feather="save" class="wd-10 mg-r-5"></i> {{ __('Guardar Cambios') }}'
    data-content-after-submit='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __('Cargando...') }}'>
    <i data-feather="save" class="wd-10 mg-r-5"></i> {{ __('Guardar Cambios') }}
</div>
@endsection

@section('content')
<form id="posts-update-form" action="{{ route('dashboard.posts.update', compact('post')) }}" method="POST" role="form" autocomplete="off" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="row row-xs">
        <div class="col-sm-12 col-lg-12">
            <div class="card card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label for="title">{{ __('Título') }}</label>
                            <input id="title" name="title" type="text" class="form-control {{ $errors->first('title', 'is-invalid') }}" placeholder="{{ __('Titulo De La Publicación') }}" value="{{ old('title', $post->title) }}" required>
                            {!! $errors->first('title', '<label id="title-error" for="title" class="text-danger">:message</label>') !!}
                        </div>
                        <div class="form-group">
                            <label for="excerpt">{{ __('Descripción Breve') }}</label>
                            <textarea id="excerpt" name="excerpt" type="text" class="form-control {{ $errors->first('excerpt', 'is-invalid') }}" placeholder="{{ __('Titulo De La Publicación') }}" rows="8" required>{{ old('excerpt', $post->excerpt) }}</textarea>
                            {!! $errors->first('title', '<label id="title-error" for="title" class="text-danger">:message</label>') !!}
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="form-group">
                            <label for="cover">{{ __('Portada') }}</label>
                            <input type="file" id="cover" name="cover_file" class="dropify" data-height="255" data-allowed-file-extensions="jpeg jpg png" data-max-file-size="5M" data-default-file={{ $post->cover_url }}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="hidden" id="content" name="content">
                            <label for="title">{{ __('Contenido') }}</label>
                            <input type="hidden" id="post-content" name="post-content" value='{{ $post->content }}'>
                            <div id="content-editor" class="bg-white text-dark rounded"></div>
                            <div id="content-editor-error-label" class="mt-1"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="is-published">{{ __('Visibilidad') }}</label>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" value="{{ true }}" id="is-published" name="is_published" {{ $post->is_published ? '' : 'checked' }}>
                                <label class="custom-control-label" for="is-published">
                                    {{ __('Guardar Como Borrador') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="tags">{{ __('Tags') }}</label>
                            <select class="form-control" id="tags" name="tags[]" data-role="tagsinput" multiple data-tags='@json($availabletags)'>
                                @foreach ($post->tags as $tag) <option value="{{ $tag }}">{{ $tag }}</option> @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
