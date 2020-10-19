@extends('layouts.landing.app')

@section('title', __('Tienda | :name', ['name' => $product->name]))

@section('breadcrumb')
<section class="breadcrumb-area bg-img bg-overlay" style="background-image: url({{ asset('images/secciones-banners.jpg') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h2 class="page-title">{{ __('Tienda') }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">
                                    <i class="icon_house_alt"></i> {{ __('Inicio') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url()->previous() }}">
                                    {{ __('Tienda') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $product->name }}
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
<div class="product_image_area section_padding">
    <div class="container">
        <div class="row s_product_inner justify-content-between">
            <div class="col-lg-7 col-xl-7">
                <div class="product_slider_img">
                    <div id="vertical" data-light-slider="true">
                        @foreach ($product->gallery as $image)
                            @if($image->mimetype != 'video')
                            <div data-thumb="{{ $image->public_url }}" class="singleProduct">
                                <img src="{{ $image->public_url }}" class="singleProduct">
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-xl-4">
                <div class="s_product_text">
                    <h3>{{ $product->name }}</h3>
                    <h2>{{ format_price($product->price, 'usd') }}</h2>
                    <ul class="list">
                        <li>
                            <span>Categoria</span> : {{ $product->categories->first() ? $product->categories->first()->name : 'Sin categoria' }}</a>
                        </li>
                        <li>
                            <span>{{ __('Disponibilidad:') }}</span>
                            <strong>
                                {{
                                    __(':availibility', [
                                        'availibility' => $product->track_stock && $product->stock >= 1 ? 'En Stock' : 'Agotado'
                                    ])
                                }}
                            </strong>
                        </li>
                    </ul>
                    <p>{{ $product->description }}</p>
                    @if ($product->track_stock && $product->stock >= 1)
                    <form action="{{ route('landing.cart.store') }}" method="POST" role="form" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <div class="card_area d-flex justify-content-between align-items-center">
                            <div class="product_count">
                                <span class="inumber-decrement" style="cursor: pointer;">
                                    <i class="ti-minus"></i>
                                </span>
                                <input class="input-number" @if (Session::has('autofocus')) autofocus @endif type="text" id="quantity" name="quantity" value="1" min="1" max="10">
                                <span class="number-increment" style="cursor: pointer;">
                                    <i class="ti-plus"></i>
                                </span>
                            </div>
                            <button type="submit" class="btn_3" title="{{ __('Agregar a mi carrito') }}" style="cursor: pointer;">
                                {{ __('Añadir al carrito') }}
                                <i class="ti-shopping-cart" style="font-size: larger;"></i>
                            </button>
                        </div>
                    </form>
                    @endif

                    <div class="col-12" style="padding-top: 1rem;">

                        @if($errors->any())
                        <div class="alert alert-block alert-danger">
                            {{$errors->first()}}
                        </div>
                        @endif

                        @if(session()->has('statusSuccess'))
                        <div class="alert alert-block alert-success">
                            {{ session()->get('statusSuccess') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" >
                        <ol class="carousel-indicators" style="top: 40px">
                            @foreach ($videos as $key => $video)
                            @if($key == 0)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" class="active"></li>
                            @else
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}"></li>
                            @endif
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach ($videos as $key => $video)
                            @if($key == 0)
                            <div class="carousel-item active">
                                <video preload="yes" class="d-block w-100" playsinline controls style="height: 500px!important; width: 100%!important;z-index:1">
                                    <source src="{{ $video->public_url }}">
                                </video>
                            </div>
                            @else
                            <div class="carousel-item">
                                <video preload="yes" class="d-block w-100" playsinline controls style="height: 500px!important;width: 100%!important;z-index:1">
                                    <source src="{{ $video->public_url }}">
                                </video>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        <!-- <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a> -->
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection