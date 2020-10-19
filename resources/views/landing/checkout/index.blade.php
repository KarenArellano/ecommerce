@extends('layouts.landing.app')

@section('title', __('Carrito'))

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
                                {{ __('Carrito') }}
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
<section class="checkout_area mt-5">
    <div class="container">
        <div class="wrapper wrapper-content animated fadeInRight">
            @if ($products->count())
            <div class="row">
                <div class="col-12">
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
                <div class="offset-md-1 col-md-10">
                    <form action="{{ route('landing.order.store') }}" method="POST" role="form" autocomplete="off" id="payment-form">
                        @csrf
                        <input type="hidden" name="method" id="method" value="{{ request()->query('method') }}">
                        <div class="card mt-5">
                            <div class="card-body">
                                <h5 class="text-uppercase">{{ __('Total del carrito') }}</h5>
                                <span>{{ __('Subtotal') }} {{ format_price($products->sum('total'), 'USD*') }} </span>
                                @if ($coupon)
                                <span> - {{ __('Descuento') }} {{ $coupon->percent . "%" }}</span>
                                <input type="hidden" name="percent" value="{{ $coupon->percent }}">
                                @endif
                                
                                <input type="hidden" name="percent" value="0">

                                <hr style="margin-top: 5px;">
                                <div class="row">
                                    <div class="col-8">

                                        @forelse($request->rates as $key => $rate)
                                        @if ($rate["name"] == 'usps_priority')

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="rate" name="_rate" value="0.00|{{ $rate['name'] }}" checked>
                                            <label class="form-check-label" for="rate">

                                                Envio gratis 
                                                <span style="color: #28a745;">
                                                  {{ $rate['provider'] ? $rate['provider'] : 'no data' }}, servicio: {{ $rate['name_radable'] }}
                                                </span> : {{ $rate['duration_terms'] }}

                                            </label>
                                        </div>
                                        <br>
                                        @else

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="_rate" id="rate" value="{{ $rate['price'] }}|{{ $rate['name'] }}">
                                            <label class="form-check-label" for="rate">

                                                Envio Express
                                                <span style="color: #007bff;">
                                                {{ $rate['provider'] ? $rate['provider'] : 'no data' }}, servicio: {{ $rate['name_radable'] }}
                                                </span> : {{ $rate["price"] . " " . $rate["currency"] }}, {{ $rate['duration_terms'] }}

                                            </label>
                                        </div>
                                        <br>
                                        @endif

                                        @empty
                                        <h3>{{__('Sin paqueterias')}}</h3>
                                        @endforelse

                                    </div>
                                </div>

                                <hr style="margin-top: 5px;">

                                <input type="number" name="_subtotal" value="{{ $products->sum('total') }}" hidden>

                                <span>{{ __('Total') }} <label for="" name="_final_price">{{ $products->sum('total') }}</label> USD*</span>
                                <hr style="margin-top: 5px;">
                            </div>
                        </div>
                        <div class="card mt-5">
                            <div class="card-body">
                                <h5 class="text-uppercase">{{ __('forma de pago') }}</h5>
                                <span>{{ __('Todas las transacciones son seguras y están encriptadas.') }}</span>
                                <hr style="margin-top: 5px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="method" id="method" value="paypal" checked>
                                                <img alt="PayPal" class="img-responsive logo-card" src="{{ asset('images/cards/paypal.png') }}">
                                            </label>
                                        </div>
                                        <div class="jumbotron text-center">
                                            <span class="cart-pyapal-blank-state">
                                                <img src="{{ asset('images/cards/blank-state.svg') }}" class="img-responsive" style="width: 160px;height:81px;">
                                            </span>
                                            <br><br>
                                            <span>
                                                {!! __('Después de hacer clic en "Completar pedido".<br>Se te redirigirá a PayPal para que completes tu compra de forma segura.') !!}
                                            </span>
                                            @if (session('status.error'))
                                            <div class="alert alert-danger" role="alert">
                                                {{ session('status.error') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if($request->rates)
                                    <div class="col-md-6">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="method" id="method" value="stripe">
                                                <img alt="stripe" class="img-responsive logo-card" src="{{ asset('images/cards/stripe_logo.png') }}">
                                            </label>
                                        </div>
                                        <div class="jumbotron text-center">
                                            <span class="cart-pyapal-blank-state">
                                                <!-- <i class="far fa-credit-card"></i> -->
                                                <img src="{{ asset('images/cards/blank-state.svg') }}" class="img-responsive" style="width: 160px;height:81px;">
                                            </span>
                                            <br><br>

                                            <div class="alert alert-danger msg-error-stripe" role="alert" style="display: none;">
                                                <!-- this contain some errors stripe -->
                                            </div>
                                            <input type="hidden" name="response_stripe">
                                            <input type="hidden" name="user_name" value="{{ $request['first_name'] . ' '. $request['last_name'] }}">
                                            <h5>{{ __('Datos de tarjeta')}}</h5>

                                            <div id="card-element" style="background-color: #fff;">
                                                <!-- Elements will create input elements here -->
                                            </div>

                                            <!-- We'll put the error messages in this element -->
                                            <div id="card-errors" role="alert"></div>

                                            <!-- <button id="submit">Pay</button> -->

                                            @if (session('status.error'))
                                            <div class="alert alert-danger" role="alert">
                                                {{ session('status.error') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="pull-left" role="group">
                                    <a class="btn btn-link btn-lg" title="{{ __('Cancelar Orden') }}" onclick="window.location='{{ route('landing.products.index') }}';">
                                        <i class="fas fa-chevron-left"></i>
                                        {{ __('Explorar') }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if($request->rates)
                                <div class="pull-right" role="group">
                                    @guest
                                    <!-- <label for=""> Más gastos de envio personalizados</label> -->
                                    <button type="submit" name="complete_paypment" class="btn_3" title="{{ __('Completar Pedido') }}" style="cursor: pointer;">

                                        {{ __('Completar Pedido') }}
                                    </button>
                                    @else
                                    @if (auth()->user()->is_customer)
                                    <!-- <label for=""> Más gastos de envio personalizados</label> -->
                                    <button type="submit" name="complete_paypment" class="btn_3" title="{{ __('Completar Pedido') }}" style="cursor: pointer;">
                                        {{ __('Completar Pedido') }}
                                    </button>
                                    @endif
                                    @endguest
                                </div>
                                @else
                                <div class="alert alert-block alert-danger">
                                    {{__('Ocurrio un error intente a vovler al carrito')}}
                                </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @elseif(session('status.order.success'))
            @include('landing.orders.complete', ['order' => session('status.order.success')])

            @else
            <div class="jumbotron">
                <div class="container text-center">
                    <h4>{!! __('Tu carrito está actualmente vacío.<br>Explora y selecciona los productos disponibles en nuestro catalogo.') !!}</h4>
                    <p>
                        <a href="{{ route('landing.products.index') }}" class="btn text-active btn-lg">
                            {{ __('Explorar Productos') }}
                        </a>
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
<hr>

<div class="modal fade" id="progressbar-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel6" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content tx-14">
			<div class="modal-body">
				<h4 class="text-center text-uppercase">
					{{ __('Cargando, no cierre su nagegador...') }} <br>
					<div class="spinner-border mt-1" role="status">
						<span class="sr-only">{{ __('Cargando...') }}</span>
					</div>
				</h4>
			</div>
		</div>
	</div>
</div>
@endsection
