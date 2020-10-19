@extends('layouts.dashboard.app')

@section('title', __('Nueva Categoria'))

@section('breadcrumb')
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.categories.index') }}" title="{{ __('Categorias') }}">{{ __('Categorias') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('Nueva Categoria') }}
            </li>
        </ol>
    </nav>
    <h4 class="mg-b-0 tx-spacing--1">
        {{ __('Nueva Categoria') }}
    </h4>
</div>
<div>
    <a href="{{ route('dashboard.categories.index') }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
        <i data-feather="x" class="wd-10 mg-r-5"></i> {{ __('Cancelar') }}
    </a>
    <button type="submit" class="btn btn-sm pd-x-15 btn-success btn-uppercase mg-l-5" id="categories-create-form-submit-button"
    data-content-before-submit='<i data-feather="save" class="wd-10 mg-r-5"></i> {{ __('Guardar') }}'
    data-content-after-submit='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __('Cargando...') }}'>
    <i data-feather="save" class="wd-10 mg-r-5"></i> {{ __('Guardar') }}
</button>
</div>
@endsection

@section('content')
<form id="categories-create-form" action="{{ route('dashboard.categories.store') }}" method="POST" role="form" autocomplete="off">
    @csrf
    <div class="row row-xs">
        <div class="col-sm-12 col-lg-12">
            <div class="card card-body">
                <div class="row">
                    <div class="col-md-12">
                        <fieldset class="form-fieldset">
                            <legend>Información General</legend>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="d-block" for="name">{{ __('Nombre de la categoria') }}</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Nombre comercial de la categoria') }}" value="{{ old('name') }}" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
