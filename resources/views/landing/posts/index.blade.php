@extends('layouts.landing.app')

@section('title', __('Noticias'))

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
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('Noticias') }}
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
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="blog_left_sidebar">
                    @forelse ($posts as $post)
                    <a href="{{ route('landing.posts.show', $post->slug) }}">
                        <article class="blog_item">
                            <div class="blog_item_img">
                                <img class="card-img rounded-0" src="{{ $post->cover_url }}" alt="{{ $post->title }}">
                                <a href="{{ route('landing.posts.show', $post->slug) }}" class="blog_item_date text-capitalize text-center">
                                    <h3>{{ $post->published_at->isoFormat('D') }}</h3>
                                    <p>{{ $post->published_at->isoFormat('MMM') }}</p>
                                </a>
                            </div>
                            <div class="blog_details">
                                <a class="d-inline-block" href="{{ route('landing.posts.show', $post->slug) }}">
                                    <h2>{{ $post->title }}</h2>
                                </a>
                                <p>{{ $post->excerpt }}</p>
                                <ul class="blog-info-link">
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
                            </div>
                        </article>
                    </a>
                    @empty
                    @endforelse
                    <div class="col-lg-12">
                        <div class="pageination">
                            {{ $posts->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog_right_sidebar">
                    <aside class="single_sidebar_widget search_widget">
                        <form action="{{ request()->fullUrlWithQuery([]) }}" method="get" autocomplete="off">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="search" class="form-control" name="buscar" id="buscar" placeholder="{{ __('Buscar en las noticias...') }}" value="{{ request()->query('buscar') }}">
                                    <div class="input-group-append">
                                        <button class="btn" type="button">
                                            <i class="ti-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button class="button rounded-0 primary-bg text-white w-100 btn_1" type="submit">
                                {{ __('Buscar') }}
                            </button>
                        </form>
                    </aside>

                    @if ($latestFourPosts = $latestPosts->take(4))
                    <aside class="single_sidebar_widget popular_post_widget">
                        <h3 class="widget_title">{{ __('Publicaciones Recientes') }}</h3>
                        @foreach ($latestFourPosts as $latestPost)
                        <div class="media post_item">
                            <a href="{{ route('landing.posts.show', $latestPost->slug) }}">
                                <img src="{{  $latestPost->cover_url }}" alt="{{  $latestPost->title }}" style="width: 80px;height: 80px;">
                            </a>
                            <div class="media-body">
                                <a href="{{ route('landing.posts.show', $latestPost->slug) }}">
                                    <h3>{{  $latestPost->title }}</h3>
                                </a>
                                <p class="text-capitalize">{{  $latestPost->published_at->isoFormat('MMMM D[,] YYYY') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </aside>
                    @endif

                    @if ($tags = $latestPosts->pluck('tags')->collapse()->unique()->values())
                    @if ($tags->count())
                    <aside class="single_sidebar_widget tag_cloud_widget">
                        <h4 class="widget_title">{{ __('Tags') }}</h4>
                        <ul class="list">
                            @foreach ($tags as $tag)
                            <li class="text-capitalize">
                                <a href="{{ request()->fullUrlWithQuery(['tag' => Str::slug($tag)]) }}">{{ $tag }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </aside>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
