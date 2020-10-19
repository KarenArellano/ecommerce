@extends('layouts.landing.app')

@section('title', __('Contacto'))

@section('breadcrumb')
<section class="breadcrumb-area bg-img bg-overlay" style="background-image: url({{ asset('images/secciones-banners.jpg') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h2 class="page-title">{{ __('Contacto') }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">
                                    <i class="icon_house_alt"></i> {{ __('Tienda') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('Contacto') }}
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

<!-- Coupon Modal Start -->
@include('layouts.landing.partials.coupon-modal', compact('first_coupon')) 
<!-- Coupon Modal End -->

<section class="contact-section padding_top mb-5">
    <div class="container">
        <!-- <div class="d-none d-sm-block mb-5 pb-4">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3600.008039316612!2d-103.44925628454675!3d25.538109124050912!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x868fdbdef30502b9%3A0x861fb352fdacf4c3!2sASTA%20Software!5e0!3m2!1ses-419!2smx!4v1576790673527!5m2!1ses-419!2smx" width="100%" height="480" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
        </div> -->
        <div class="row">
            <div class="col-12">
                <h2 class="contact-title">{{ __('Contáctame') }}</h2>
            </div>
            <div class="col-lg-8">
                @if (session('status.email.sent'))
                <div class="alert alert-success" role="alert">
                    <a href="{{ url()->current() }}" type="button" class="close">&times;</a>
                    <strong>{{ session('status.email.sent') }}</strong>
                </div>
                @else
                <form class="form-contact contact_form" action="{{ route('landing.contact.send.notification') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input class="form-control @error('name') border border-danger @enderror" name="name" id="name" type="text" placeholder='{{ __('¿Como te llamas?') }}' value="{{ old('name') }}" maxlength="255" required>
                                @error('name')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input class="form-control @error('email') border border-danger @enderror" name="email" id="email" type="email" placeholder='{{ __('¿Cual es tu correo electrónico?') }}' value="{{ old('email') }}" maxlength="255" required>
                                @error('email')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <textarea class="form-control w-100 @error('message') border border-danger @enderror" name="message" id="message" cols="30" rows="9" placeholder='{{ __('Soy todo oídos...') }}'>{{ old('message') }}</textarea>
                                @error('message')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button role="button" type="submit" class="btn btn_3 button-contactForm">{{ __('Enviar') }}</button>
                    </div>
                </form>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="media contact-info">
                    <span class="contact-info__icon">
                        <i class="ti-home"></i>
                    </span>
                    <div class="media-body">
                        <h3>Mason Ohio, Estados Unidos</h3>
                    </div>
                </div>
                <div class="media contact-info">
                    <span class="contact-info__icon">
                        <i class="ti-email"></i>
                    </span>
                    <div class="media-body">
                        <h3>
                            <a href="mailto:paola_raya@outlook.com" class="callPixelFacebook">
                                paola_raya@outlook.com
                            </a>
                        </h3>
                        <p>{{ __('!escríbeme en cualquier momento!') }}</p>
                    </div>
                </div>
                <a href="https://m.me/547530305729014" target="blank" class="callPixelFacebook">
                    <div class="media contact-info">

                        <span class="contact-info__icon">
                            <i class="fab fa-facebook-messenger"></i>
                        </span>

                        <div class="media-body">
                            <h3>Escríbeme en Facebook Messenger</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection