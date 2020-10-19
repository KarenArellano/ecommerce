@extends('layouts.landing.app')

@section('title', __('Galería'))

@section('breadcrumb')
<section class="breadcrumb-area bg-img bg-overlay" style="background-image: url({{ asset('images/index-banner.png') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h2 class="page-title">{{ __('Galería') }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">
                                    <i class="icon_house_alt"></i> {{ __('Inicio') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('Galería') }}
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

@inject('gallery', 'App\Models\Gallery')

<!-- Gallery Area Start -->
<div class="alime-portfolio-area section-padding-80 clearfix">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Projects Menu -->
                <div class="alime-projects-menu wow fadeInUp" data-wow-delay="100ms">
                    <div class="portfolio-menu text-center">
                        <button class="btn active" data-filter="*">{{ __('Todo') }}</button>
                        @foreach ($gallery->pluck('tags')->collapse()->unique() as $tag)
                        <button class="btn" data-filter=".{{ Str::slug($tag) }}">{{ $tag }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row alime-portfolio">
            <!-- Single Gallery Item -->
            @foreach ($gallery->latest()->get() as $gallery)
            <div class="col-12 col-sm-6 col-lg-3 single_gallery_item mb-30 wow fadeInUp {{ $gallery->slugify_tags->implode(' ') }}" data-wow-delay="100ms">
                <div class="single-portfolio-content">
                    <img src="{{ $gallery->image->public_url }}" alt="{{ $gallery->name }}" title="{{ $gallery->title }}">
                    <div class="hover-content">
                        <a href="{{ $gallery->image->public_url }}" class="portfolio-img" title="{{ $gallery->title }}">+</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- <div class="row">
            <div class="col-12 text-center wow fadeInUp" data-wow-delay="800ms">
                <a href="#" class="btn alime-btn btn-2 mt-15">{{ __('Ver Más') }}</a>
            </div>
        </div> --}}
    </div>
</div>
<!-- Gallery Area End -->
@endsection
