@extends('layouts.landing.app')

@section('title', __('Noticias | :title', ['title' => $post->title]))

@section('breadcrumb')
<section class="breadcrumb-area bg-img bg-overlay" style="background-image: url({{ asset('images/index-banner.png') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h2 class="page-title">{{ __('Noticias') }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">
                                    <i class="icon_house_alt"></i> {{ __('Inicio') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('landing.posts.index') }}">
                                    {{ __('Noticias') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $post->title }}
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
<section class="blog_area padding_top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 posts-list">
                <div class="single-post">
                    <div class="feature-img">
                        <img class="img-fluid" src="{{ $post->cover_url }}" alt="{{ $post->title }}">
                    </div>
                    <div class="blog_details">
                        <h2>{{ $post->title }}</h2>
                        <ul class="blog-info-link mt-3 mb-4">
                            <li>
                                <i class="fas fa-tags"></i>
                                @foreach ($post->tags as $value)
                                <a href="{{ request()->fullUrlWithQuery(['tag' => Str::slug($value)]) }}">
                                    {{
                                        __(':value:comma', [
                                            'value' => $value,
                                            'comma' => $loop->last ? '' : ', ',
                                        ])
                                    }}
                                </a>
                                @endforeach
                            </li>
                            <li>
                                <a href="#">
                                    <i class="far fa-user"></i>
                                    {{ optional($post->user)->first_name ?? 'Jorge Manjarrez' }}
                                </a>
                            </li>
                        </ul>
                        <p class="excert">
                            {!! $post->renderContentAsHtml() !!}
                        </p>
                    </div>
                </div>
                <div class="navigation-top">
                    <div class="navigation-area">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12 nav-left flex-row d-flex justify-content-start align-items-center">
                                @isset ($previous)
                                <div class="thumb">
                                    <a href="{{ route('landing.posts.show', $previous->slug) }}">
                                        <img class="img-fluid" src="{{ $previous->cover_url }}" alt="{{ $previous->title }}" style="width: 60px;">
                                    </a>
                                </div>
                                <div class="arrow">
                                    <a href="{{ route('landing.posts.show', $previous->slug) }}">
                                        <span class="lnr text-white ti-arrow-left"></span>
                                    </a>
                                </div>
                                <div class="detials">
                                    <p>{{ __('Anterior') }}</p>
                                    <a href="{{ route('landing.posts.show', $previous->slug) }}">
                                        <h4>{{ Str::limit($previous->title, 25) }}</h4>
                                    </a>
                                </div>
                                @endisset
                            </div>

                            <div class="col-lg-6 col-md-6 col-12 nav-right flex-row d-flex justify-content-end align-items-center mt-5 mb-5">
                                @isset ($next)
                                <div class="detials">
                                    <p>{{ __('Siguiente') }}</p>
                                    <a href="{{ route('landing.posts.show', $next->slug) }}">
                                        <h4>{{ Str::limit($next->title, 25) }}</h4>
                                    </a>
                                </div>
                                <div class="arrow">
                                    <a href="{{ route('landing.posts.show', $next->slug) }}">
                                        <span class="lnr text-white ti-arrow-right"></span>
                                    </a>
                                </div>
                                <div class="thumb">
                                    <a href="{{ route('landing.posts.show', $next->slug) }}">
                                        <img class="img-fluid" src="{{ $next->cover_url }}" alt="{{ $next->title }}" style="width: 60px;">
                                    </a>
                                </div>
                                @endisset
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
