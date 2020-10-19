@extends('layouts.dashboard.app')

@section('title', __('Reimprimir etiqueta'))

@section('breadcrumb')
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item">
                <a href="javascript:;">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('Ordenes') }}
            </li>
        </ol>
    </nav>
    <h4 class="mg-b-0 tx-spacing--1">
        {{ __('Reimprimir etiqueta') }}
    </h4>
</div>
@endsection
@section('content')
<form action="{{ route('dashboard.address.store') }}" method="POST" role="form" autocomplete="off">
    @csrf

    @if($errors->any())
    <div class="alert alert-block alert-danger">
        {{$errors->first()}}
    </div>
    @endif

    <input type="hidden" value="{{ $orderId }}" name="orderId">
    <div class="row container_address">
        <div class="form-group col-md-8 @error('line') has-error @enderror">
            <label for="line">
                {{ __('Dirección') }}<sup class="text-danger">*</sup>
            </label>
            <input type="text" class="form-control input-lg" id="line" name="line" placeholder="{{ __('Calle(s), número, colonia, avenida, bulevar, etc.') }}" value="{{ $address->line ?? '' }}" required>

            @error('line')
            <span class="help-block">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <div class="custom-control custom-checkbox pd-l-15">
                <input type="checkbox" class="custom-control-input check_same_address" id="is_same" name="is_same" value="false" checked>
                <label class="custom-control-label" for="is_same">
                    {{ __('Misma dirección de envío') }}
                    <i class="wd-15" data-feather="help-circle" data-toggle="tooltip" data-placement="top" title="{{ __('Esto omitirá los datos en el formulario y usará la dirección dada por el usuario!') }}"></i>
                </label>
            </div>
        </div>
        <div class="form-group col-md-4 @error('secondary_line') has-error @enderror">
            <label for="secondary-line" style="visibility: hidden;">{{ __('Dirección complementaria') }}</label>

            <input type="text" class="form-control input-lg" id="secondary-line" name="secondary_line" placeholder="{{ __('Apartamento, edificio, oficina, etc.') }}" value="{{ $address->secondary_line ?? '' }}">

            @error('secondary_line')
            <span class="help-block">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group col-md-4 @error('zipcode') has-error @enderror">
            <label for="zipcode">
                {{ __('Código Postal (zip code)') }}<sup class="text-danger">*</sup>
            </label>

            <input type="text" class="form-control input-lg" id="zipcode" name="zipcode" placeholder="{{ __('Código Postal (zip code)') }}" value="{{ $address->zipcode }}" required>

            <!-- Gets the name country hidden -->
            <input type="hidden" value="United States" name="country">

            @error('zipcode')
            <span class="help-block">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group col-md-4 @error('city') has-error @enderror">
            <label for="city">
                {{ __('Ciudad') }}<sup class="text-danger">*</sup>
            </label>

            <input type="text" class="form-control input-lg" id="city" name="city" placeholder="{{ __('Ciudad') }}" value="{{ $address->city }}" required>

            @error('city')
            <span class="help-block">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group col-md-4 @error('state') has-error @enderror">
            <label for="state">
                {{ __('Estado') }}<sup class="text-danger">*</sup>
            </label>
            <select name="state" id="state" class="form-control input-lg" required>
                <option value="" disabled selected>{{ __('Seleccionar estado...') }}</option>
                @foreach (config('shipping.states') as $key => $state)

                <option value="{{ $key }}" {{ $address->state == $key ? 'selected' : '' }}>
                    {{ $state }}
                </option>

                @endforeach
            </select>

            @error('state')
            <span class="help-block">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-sm pd-x-15 btn-success btn-uppercase mg-l-5">
        {{ __('Cambiar') }}
    </button>
</form>
@endsection