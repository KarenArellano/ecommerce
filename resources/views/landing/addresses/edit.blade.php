@extends('layouts.landing.app')

@section('title', __('Mi cuenta - :user', ['user' => $user->first_name]))

@section('breadcrumb')
<section class="breadcrumb-area bg-img bg-overlay" style="background-image: url({{ asset('images/secciones-banners.jpg') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h2 class="page-title">{{ __('Mi Cuenta') }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">
                                    <i class="icon_house_alt"></i> {{ __('Inicio') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $user->first_name }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="card mt-5 col-8 offset-2">
    <div class="card-body">
        <div class="text-uppercase">
            <h5>{{ __('informacion de contacto y envío') }}</h5>
        </div>
        <hr style="margin-top: 5px;">
        <div class="row">
            <div class="col-12">

                @if(session()->has('statusSuccess'))
                <div class="alert alert-block alert-success">
                    {{ session()->get('statusSuccess') }}
                </div>
                @else
                <div class="alert alert-block alert-info">
                    {{ __('Esta modificación no se realiza a las direccón de entrega de pedido previamente realizados, si desea cambiar la dirección de entrega contacta un administrador!') }}
                </div>
                @endif
            </div>

            <form action="{{ route('landing.account.addresses.update', $address->id) }}" method="POST" role="form" autocomplete="off">
                @csrf @method('PUT')
                <div class="col-md-12">
                    <div class="row">
                        <div class="form-group col-md-6 col-lg-6 col-6 @error('phone') has-error @enderror">
                            <label for="phone">
                                {{ __('Télefono') }}<sup class="text-danger">*</sup>
                            </label>

                            <input type="text" class="form-control input-lg" id="phone" name="phone" maxlength="14" placeholder="{{ __('Télefono') }}" value="{{ $address->phone ?? '' }}" required> 

                            @error('phone')
                            <span class="help-block">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
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

                            <input type="text" class="form-control input-lg" id="zipcode" name="zipcode" placeholder="{{ __('Código Postal (zip code)') }}" value="{{ $address->zipcode ?? '' }}" required>

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
 
                            <input type="text" class="form-control input-lg" id="city" name="city" placeholder="{{ __('Ciudad') }}" value="{{ $address->city ?? '' }}" required>

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

                                <option value="{{ $key }}" {{ $address->state == $key ? 'selected' : '' }}>{{ $state }}</option>
                                @endforeach
                            </select>

                            @error('state')
                            <span class="help-block">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-2 offset-10">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection