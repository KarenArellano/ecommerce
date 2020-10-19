@extends('layouts.landing.app')

@section('title', __('Tienda'))

@section('breadcrumb')

<div class="row" style="background-image: url({{ asset('images/portada-lisa-principal.jpg') }});">
    <div class="col-12">
        <img src="{{ asset('images/logo-portada.png') }}" class="imglogo" alt="">
    </div>
    <div class="col-12">
        <p class="DISCOS_DUROS_PARA_DJ_S">{{ __("DISCOS DUROS PARA DJ'S") }}</p>
    </div>
</div>

@endsection

@section('content')

<!-- Coupon Modal Start -->
@include('layouts.landing.partials.coupon-modal', compact('first_coupon')) 
<!-- Coupon Modal End -->

<section class="cat_product_area section_padding newPadding">
    <div class="container">
        <div class="row">

            <div class="col-lg-12">
                <form action="{{ request()->fullUrlWithQuery([]) }}" method="get" autocomplete="off" id="filterForm">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="product_top_bar d-flex justify-content-between align-items-center">

                                <div class="single_product_menu">
                                    <button type="button" class="btn btn-outline-secondary" id="clear">
                                        Borrar filtros
                                        <i class="fas fa-sync-alt text-secondary"></i>
                                    </button>
                                </div>

                                @if ($categories->count())
                                <div class="single_product_menu d-flex">
                                    <h5>{{ __('Categorías:') }}</h5>
                                    <select name="categoria" id="category" data-nice-select="true" onchange="this.form.submit()">

                                        <option value="">Todas</option>

                                        @foreach ($categories as $category)

                                        <option value="{{ $category->name }}" {{ request()->query('categoria')  == $category->name ? 'selected' : '' }}> {{ $category->name }} {{ $category->products->count() }}</option>

                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                <div class="single_product_menu d-flex">
                                    <h5>{{ __('Ordenar por:') }}</h5>
                                    <select name="order" data-nice-select="true" id="order" onchange="this.form.submit()">

                                        <option value="latest" {{ request()->query('order')  == 'latest' ? 'selected' : '' }}>{{ __('Recientes') }}</option>
                                        <option value="asc" {{ request()->query('order')  == 'asc' ? 'selected' : '' }}>{{ __('Menor Precio') }}</option>
                                        <option value="desc" {{ request()->query('order')  == 'desc' ? 'selected' : '' }}>{{ __('Mayor Precio') }}</option>
                                        <!-- <option value="popular">{{ __('Mas Vendidos') }}</option> -->
                                    </select>
                                </div>
                                <div class="single_product_menu d-flex">
                                    <h5>{{ __('Mostrar:') }}</h5>
                                    <select name="slice" data-nice-select="true" onchange="this.form.submit()">
                                        <option value="8" {{ request()->query('slice')  == '8' ? 'selected' : '' }}>8</option>
                                        <option value="16" {{ request()->query('slice')  == '16' ? 'selected' : '' }}>16</option>
                                        <option value="32" {{ request()->query('slice')  == '32' ? 'selected' : '' }}>32</option>
                                        <option value="40" {{ request()->query('slice')  == '40' ? 'selected' : '' }}>40</option>
                                        <option value="48" {{ request()->query('slice')  == '48' ? 'selected' : '' }}>48</option>
                                    </select>
                                </div>
                                <div class="single_product_menu d-flex">
                                    <div class="input-group">
                                        <input type="search" class="form-control" name="buscar" value="{{ request()->query('buscar') }}" placeholder="Buscar productos..." maxlength="255">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupPrepend">
                                                <i class="ti-search"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row align-items-center latest_product_inner">
                    @forelse ($products as $product)
                    <div class="col-lg-3 col-sm-3 col-6">
                        <div class="single_product_item">
                            <a href="{{ route('landing.products.show', $product) }}">
                                <img class="productSize resizeImg" src="{{ $product->cover->public_url ? $product->cover->public_url : asset('images/lowres-lady-records-logo-horizontal.png') }}" alt="{{ $product->name }}">
                                <!-- <div class=".img" style="background-image: url('{{ $product->cover->public_url }}');" alt="{{ $product->name }}"></div> -->
                            </a>

                            <!-- style="background-image: url({{ $product->cover->public_url }});" -->
                            <div class="single_product_text">
                                <h4>{{ Str::limit($product->name, 400) }}</h4>
                                <h3>{{ format_price($product->price, 'usd') }}</h3>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('landing.products.show', $product) }}" class="add_cart">
                                        {{ __('+ Ver Producto') }}
                                    </a>
                                    <strong>
                                        {{
                                            __(':availibility', [
                                                'availibility' => $product->track_stock && $product->stock >= 1 ? 'En Stock' : 'Agotado'
                                            ])
                                        }}
                                    </strong>
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
                    @empty
                    <div class="col-12">
                        <div class="jumbotron">
                            <div class="container text-center">
                                <h2 class="text-uppercase">
                                    <i class="fas fa-box-open"></i>
                                    {{ __('Sin productos disponibles') }}
                                </h2>
                                <p>
                                    {{ __('Estamos poniendo en stock nuestros productos, por favor, vuelve mas tarde') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforelse

                    <div class="col-lg-12">
                        <div class="pagination justify-content-center">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Area Start -->
<section class="why-choose-us-area bg-gray section-padding-80-0 clearfix">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading text-center wow fadeInUp" data-wow-delay="100ms">
                    <h2>Hecho con amor</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Single Why Choose Area -->
            <div class="col-md-6 col-lg-4">
                <div class="why-choose-us-content text-center mb-80 wow fadeInUp resizeMade" data-wow-delay="100ms">
                    <div class="chosse-us-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <!-- <h4>High Quality Images</h4> -->
                    <p>{{ __('Cada disco duro es llenado con un amplio cuidado y revisión minuciosa para que el contenido no este repetido.')}}</p>
                </div>
            </div>

            <!-- Single Why Choose Area -->
            <div class="col-md-6 col-lg-4">
                <div class="why-choose-us-content text-center mb-80 wow fadeInUp resizeMade" data-wow-delay="300ms">
                    <div class="chosse-us-icon">
                        <i class="fas fa-quidditch"></i>
                    </div>
                    <!-- <h4>Abundant Experience</h4> -->
                    <p>{{ __('Listo para usarse libre de sellos, logos, comerciales y publicidad.') }}</p>
                </div>
            </div>

            <!-- Single Why Choose Area -->
            <div class="col-md-6 col-lg-4">
                <div class="why-choose-us-content text-center mb-80 wow fadeInUp resizeMade" data-wow-delay="500ms">
                    <div class="chosse-us-icon">
                        <i class="fas fa-music"></i>
                    </div>
                    <!-- <h4>Modern Equipments</h4> -->
                    <p>{{ __('Para todos gustos en completo orden por géneros y contamos con gran variedad en los géneros que más te gustan.') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Why Choose  us Area End -->

@endsection