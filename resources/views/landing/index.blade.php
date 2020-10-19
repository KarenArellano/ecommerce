@extends('layouts.landing.app')

@section('title', __('Inicio'))

@section('content')
<!-- Welcome Area Start -->
<section class="welcome-area">
    <div class="welcome-slides owl-carousel">
        <!-- Single Slide -->
        <div class="single-welcome-slide bg-img bg-overlay" >
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <!-- Welcome Text -->
                    <div class="col-12 col-lg-8 col-xl-6">
                        <div class="welcome-text">
                            <h2 data-animation="bounceInDown" data-delay="900ms" class="text-uppercas">
                                Lady <br> Records
                            </h2>
                            <!-- <p data-animation="bounceInDown" data-delay="500ms" style="font-size: x-large;">
                                {{ __('Muralista, pintor y monero; pero sobre todo apasionado del Rock') }}
                            </p> -->
                            <div class="hero-btn-group" data-animation="bounceInDown" data-delay="100ms">
                                <!-- <a href="#" class="btn alime-btn mb-3 mb-sm-0 mr-4">{{ __('Mis Trabajos') }}</a> -->
                                <a class="hero-mail-contact" href="mailto:paola_raya@outlook.com">paola_raya@outlook.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Welcome Area End -->

<!-- Gallery Area Start -->

<!-- Gallery Area End -->

<!-- Products Area Start -->
<div class="alime-portfolio-area product_list section-padding-80 clearfix">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="section_tittle text-center d-flex align-items-center">
                    <h2>A la venta</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="product_list_slider owl-carousel" data-owl-carousel="true">
                    <div class="single_product_list_slider">
                        <div class="row align-items-center justify-content-between">
                            @inject('products', 'App\Models\Product')
                            @foreach ($products->latest()->take(4)->get() as $product)
                            <div class="col-lg-3 col-sm-6 col-6">
                                <div class="single_product_item">
                                    <a href="{{ route('landing.products.show', $product) }}">
                                        <img src="{{ $product->cover->public_url }}" class="resizeImg" alt="{{ $product->name }}">
                                    </a>
                                    <div class="single_product_text">
                                        <h4>{{ $product->name }}</h4>
                                        <h3>{{ format_price($product->price, '') }}</h3>
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('landing.products.show', $product) }}" class="add_cart">
                                                {{ __('+ Ver Producto') }}
                                            </a>
                                            <form id="cart-form-{{ $product->id }}" action="{{ route('landing.cart.store') }}" method="POST" role="form" autocomplete="off">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <a href="javascript:;" title="{{ __('Agregar a mi carrito') }}" onclick="event.preventDefault();document.getElementById('cart-form-{{ $product->id }}').submit();">
                                                    <i class="ti-shopping-cart-full" style="font-size: x-large;"></i>
                                                </a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Products Area End -->


<!-- Blog Area Start -->

<!-- Blog Area End -->
@endsection
