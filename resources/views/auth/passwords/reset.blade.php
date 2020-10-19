@extends('layouts.landing.app')

@section('title', __('Reset Password'))

@section('breadcrumb')
<section class="breadcrumb-area bg-img bg-overlay" style="background-image: url({{ asset('images/index-banner.png') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h2 class="page-title">{{ __('Reset Password') }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">
                                    <i class="icon_house_alt"></i> {{ __('Inicio') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('Reset Password') }}
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
                <form action="{{ route('password.update') }}" method="POST" autocomplete="off">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" placeholder="{{ __('E-Mail Address') }}" required autofocus>
                            @error('email')
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
                    <div class="form-row">
                        <div class="form-group col-12 text-right">
                            <button type="submit" class="btn btn-dark btn-sm">
                                {{ __('Reset Password') }}
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
