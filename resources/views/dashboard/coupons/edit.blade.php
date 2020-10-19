@extends('layouts.dashboard.app')

@section('title', __('Editar cupón'))

@section('breadcrumb')
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item">
                <a href="javascript:;">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.coupons.index') }}" title="{{ __('Categorias') }}">{{ __('Coupones') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ $coupon->name }}
            </li>
        </ol>
    </nav>
    <h4 class="mg-b-0 tx-spacing--1">
        {{ __('Editar coupon') }}
    </h4>
</div>
<div>
    <a href="{{ route('dashboard.coupons.index') }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
        <i data-feather="x" class="wd-10 mg-r-5"></i> {{ __('Cancelar') }}
    </a>
    <button id="cupons-create-form-submit-button" type="submit" class="btn btn-sm pd-x-15 btn-info btn-uppercase mg-l-5" data-content-before-submit='<i data-feather="refresh-cw" class="wd-10 mg-r-5"></i> {{ __('Guardar Cambios') }}' data-content-after-submit='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __('Cargando...') }}'>
        <i data-feather="refresh-cw" class="wd-10 mg-r-5"></i> {{ __('Guardar Cambios') }}
    </button>
</div>
@endsection

@section('content')
<form id="cupons-create-form-submit-button" action="{{ route('dashboard.coupons.update', compact('coupon')) }}" method="POST" role="form" autocomplete="off" enctype='multipart/form-data'>
    @csrf @method('PUT')
    <div class="row row-xs">
        <div class="col-sm-12 col-lg-12">
            <div class="card card-body">
                <div class="row">
                    <div class="col-12">
                        @if ( is_array( session('status.error') ) )
                        <div class="alert alert-danger" role="alert">
                            @foreach(session('status.error') as $index => $error)
                            {{ $error }}
                            <br>
                            @endforeach
                        </div>
                        @endif

                        @if( ! is_array( session('status.error') ) && session('status.error') )
                        <div class="alert alert-danger" role="alert">
                            {{ session('status.error') }}
                        </div>
                        @endif

                        <fieldset class="form-fieldset">
                            <legend>Información General</legend>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="d-block" for="name">{{ __('Nombre') }}</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('cupon promo') }}" value="{{ old('name', $coupon->name) }}" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox pd-l-15">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="{{ $coupon->is_active }}" {{ $coupon->is_active ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Es activo</label>
                                    </div>
                                </div>
                                <div class="form-group col-4 offset-1">
                                    <label class="d-block" for="cover-image">{{ __('Portada') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('cover_image') is-invalid @enderror" id="cover-image" name="cover_image" accept="image/*">
                                        <label class="custom-file-label" for="cover-image">{{ __('Seleccionar imagen') }}</label>
                                        <small id="passwordHelpBlock" class="form-text text-muted">
                                            {{ __('El peso de la imagen, debe de ser inferior a: 5 MB') }}
                                        </small>
                                        @error('cover_image')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label class="d-block" for="percent">{{ __('Porcentaje de descuento') }}</label>
                                    <div class="input-group">

                                        <input type="number" name="percent" class="form-control @error('percent') is-invalid @enderror" placeholder="50" value="{{ old('percent', $coupon->percent) }}" required>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('%') }}</span>
                                        </div>
                                        @error('percent')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 col-xs-6 col-lg-3 col-md-3">
                                    <label class="d-block" for="start_date">{{ __('Fecha de inicio') }}</label>
                                    <div class="input-group">
                                        <input type="date" id="start_date" name="start_date" value="{{ $coupon->start_date ? $coupon->start_date->format('Y-m-d') : '' }}" min="{{ now()->format('Y-m-d') }}" class="form-control">
                                        @error('start_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 col-xs-6 col-lg-3 col-md-3">
                                    <label class="d-block" for="end_date">{{ __('Fecha de vencimiento') }}</label>
                                    <div class="input-group">
                                        <input type="date" id="end_date" name="end_date" value="{{ $coupon->end_date ? $coupon->end_date->format('Y-m-d') : '' }}" min="{{ now()->format('Y-m-d') }}" class="form-control">
                                        @error('end_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
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