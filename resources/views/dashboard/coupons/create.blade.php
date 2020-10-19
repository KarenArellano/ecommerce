@extends('layouts.dashboard.app')

@section('title', __('Nuevo cupón'))

@section('breadcrumb')
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.coupons.index') }}" title="{{ __('Productos') }}">{{ __('Cupones') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('Nuevo cupón') }}
            </li>
        </ol>
    </nav>
    <h4 class="mg-b-0 tx-spacing--1">
        {{ __('Nuevo cupón') }}
    </h4>
</div>
<div>
    <a href="{{ route('dashboard.coupons.index') }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
        <i data-feather="x" class="wd-10 mg-r-5"></i> {{ __('Cancelar') }}
    </a>
    <button id="cupons-create-form-submit-button" type="button" class="btn btn-sm pd-x-15 btn-success btn-uppercase mg-l-5" name="submit">
        <i data-feather="save" class="wd-10 mg-r-5"></i> {{ __('Guardar') }}
    </button>
</div>
@endsection

@section('content')
<form id="cupons-create-form-submit-button" action="{{ route('dashboard.coupons.store') }}" method="POST" role="form" autocomplete="off" id="create-discount">
    @csrf

    <div class="row row-xs">
        <div class="col-sm-12 col-lg-12">
            <div class="card card-body">
                <div class="row">
                    <div class="col-md-12">
                        <fieldset class="form-fieldset">
                            <!-- <legend>Información General</legend> -->
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label class="d-block" for="name">{{ __('Nombre') }}</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('cupon promo') }}" value="{{ old('name') }}" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="d-block" for="percent">{{ __('Porcentaje de descuento') }}</label>
                                    <div class="input-group">

                                        <input type="number" name="percent" class="form-control @error('percent') is-invalid @enderror" placeholder="50" value="{{ old('percent') }}" required>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('%') }}</span>
                                        </div>
                                        @error('percent')
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