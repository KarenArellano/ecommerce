@extends('layouts.landing.app')

@section('title', __('Iniciar Sesión'))

@section('breadcrumb')
<section class="breadcrumb-area bg-img bg-overlay"  style="background-image: url({{ asset('images/secciones-banners.jpg') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h2 class="page-title">{{ __('Bienvenido') }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">
                                    <i class="icon_house_alt"></i> {{ __('Inicio') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('Iniciar Sesión') }}
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
<div class="container pt-5">
    <div class="card">
        <div class="card-body">
            <div class="offset-md-2 col-md-8">
                <form method="POST" action="{{ route('register') }}" autocomplete="off">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="first-name" class="col-form-label text-md-right">{{ __('Nombre') }}</label>
                            <input id="first-name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" placeholder="{{ __('Nombre(s)') }}" required>
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last-name" class="col-form-label text-md-right">{{ __('Apellido') }}</label>
                            <input id="last-name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" placeholder="{{ __('Apellido(s)') }}" required>
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" required autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone" class="col-form-label text-md-right">{{ __('Teléfono') }}</label>
                           
                            <input type="text" class="form-control input-lg" id="phone" name="phone" maxlength="14" placeholder="{{ __('Télefono') }}" value="{{ old('phone') }}" required>

                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" required>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password-confirm" class="col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <div class="form-check">
                                <input class="form-check-input @error('accepts_terms') is-invalid @enderror" type="checkbox" name="accepts_terms" id="accepts-terms" value="{{ true }}" {{ old('accepts_terms') ? 'checked' : '' }}>

                                <label class="form-check-label" for="accepts-terms">
                                    {!! __('Acepto las <a href=":url" target="_blank"><u>politicas y términos de servicio</u></a>', ['url' => url('/terminos')]) !!}
                                </label>

                                @error('accepts_terms')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-6 text-right">
                            <button type="submit" class="btn btn-dark btn-sm">
                                {{ __('Crear Cuenta') }}
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="text-center">
                    {{ __('¿Ya tienes una cuenta?') }}
                    <a href="{{ route('login') }}" title="{{ __('Inicia Sesión') }}">{{ __('Inicia Sesión') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
