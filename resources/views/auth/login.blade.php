@extends('layouts.landing.app')

@section('title', __('Iniciar sesión'))

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
                                    <i class="icon_house_alt"></i> {{ __('Tienda') }}
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
                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password" class="col-form-label text-md-right d-flex justify-content-between">
                                {{ __('Password') }}
                                <label class="form-check-label">
                                    <a class="text-right" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                </label>
                            </label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-md-6 text-right">
                            <button type="submit" class="btn btn-dark btn-sm">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="text-center">
                    {{ __('¿No tienes una cuenta?') }}
                    <a href="{{ route('register') }}" title="{{ __('Regístrate') }}">{{ __('Regístrate') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
