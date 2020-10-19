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

<!-- Coupon Modal Start -->
@include('layouts.landing.partials.coupon-modal', compact('first_coupon')) 
<!-- Coupon Modal End -->

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
                    <div class="card mt-5">
                        <div class="card-body">
                            <div class="text-uppercase">
                                <h5>
                                    {{ __('resumen de la orden') }}
                                    <span class="pull-right text-muted">
                                        <strong>{{ $products->count() }}</strong>
                                        {{
                                            __(':label', [
                                                'label' => $products->count() >1 ? 'productos' : 'producto'
                                            ])
                                        }}
                                    </span>
                                </h5>
                            </div>
                            <hr style="margin-top: 5px;">
                            @foreach ($products as $item)
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table class="table shoping-cart-table">
                                        <tbody>
                                            <tr>
                                                <td width="100">
                                                    <a href="{{ route('landing.products.show', $item['product']['id']) }}" title="{{ $item['product']['name'] }}">
                                                        <img src="{{ asset($item['product']['cover']['public_url']) }}" class="img-responsive" alt="{{ $item['product']['name'] }}">
                                                    </a>
                                                </td>
                                                <td class="desc">
                                                    <h3>
                                                        <a href="{{ route('landing.products.show', $item['product']['id']) }}" class="text-navy text-capitalize">
                                                            {{ Str::limit($item['product']['name'], 50) }}
                                                        </a>
                                                    </h3>
                                                    <p>{{ Str::limit($item['product']['description'], 100) }}</p>
                                                    <div class="m-t-sm">
                                                        <form action="{{ route('landing.cart.destroy', $item['product']['id']) }}" method="POST" role="form" autocomplete="off">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-xs text-danger">
                                                                <small>
                                                                    <i class="fas fa-times"></i>
                                                                    {{ __('Eliminar producto') }}
                                                                </small>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td class="text-left">
                                                    <h4>{{ format_price($item['price'], '') }}</h4>
                                                </td>
                                                <td width="110">
                                                    <form action="{{ route('landing.cart.update', $item['product']['id']) }}" method="POST" role="form" autocomplete="off">
                                                        @csrf @method('PUT')
                                                        <div class="input-group">
                                                            <input type="number" class="form-control input-sm text-center" placeholder="Cant." name="quantity" value="{{ $item['quantity'] }}" placeholder="Cant." min="1" oninput="validity.valid || (value = '');" required>
                                                            <button type="submit" class="btn btn-light btn-sm w-100" title="{{ __('Actualizar cantidad') }}">
                                                                <i class="fas fa-sync-alt text-info"></i>
                                                                <label for="">Actualizar</label>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td>
                                                    <h4>{{ format_price($item['total'], '') }}</h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endforeach
                            <div class="ibox-content">
                                <div class="pull-right text-right">
                                    <h5 class="text-uppercase">{{ __('Subtotal de la orden') }}</h5>
                                    <hr style="margin-top: 5px;margin-bottom: 5px;">
                                    <h2 class="font-bold">
                                        {{ format_price($products->sum('total'), 'USD*') }}
                                    </h2>
                                    <small class="text-muted">
                                        *{{ __('Montos en dólar') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('landing.checkout.index') }}" method="GET" role="form" autocomplete="off">
                        @csrf
                        <input type="hidden" name="method" id="method" value="{{ request()->query('method') }}">
                        <div class="card mt-5">
                  
                            <div class="card-body">
                                <div class="text-uppercase">
                                    <h5>{{ __('informacion de contacto y envío') }}
                                    </h5>
                                    @if(Auth::check())
                                    <p>Si desea cambiar su información vaya al perfil *</p>
                                    @endif
                                </div>
                                <hr style="margin-top: 5px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group col-md-6 @error('first_name') has-error @enderror">
                                                <label for="first-name">
                                                    {{ __('Nombre(s)') }}<sup class="text-danger">*</sup>
                                                </label>

                                                @if (Auth::check())
                                                <input type="text" class="form-control input-lg" id="first-name" name="first_name" placeholder="{{ __('Nombre(s)') }}" value="{{ auth()->user()->first_name }}" disabled>
                                                @else
                                                <input type="text" class="form-control input-lg" id="first-name" name="first_name" placeholder="{{ __('Nombre(s)') }}" value="{{ old('first_name') }}" required>
                                                @endif
                                                @error('first_name')
                                                <span class="help-block">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6 @error('last_name') has-error @enderror">
                                                <label for="last-name">
                                                    {{ __('Apellido(s)') }}<sup class="text-danger">*</sup>
                                                </label>
                                                @if (Auth::check())
                                                <input type="text" class="form-control input-lg" id="last-name" name="last_name" placeholder="{{ __('Apellido(s)') }}" value="{{ auth()->user()->last_name }}" disabled>
                                                @else
                                                <input type="text" class="form-control input-lg" id="last-name" name="last_name" placeholder="{{ __('Apellido(s)') }}" value="{{ old('last_name') }}" required>
                                                
                                                @endif
                                                @error('last_name')
                                                <span class="help-block">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6 @error('email') has-error @enderror">
                                                <label for="email">
                                                    {{ __('Correo electrónico') }}<sup class="text-danger">*</sup>
                                                </label>
                                                @if (Auth::check())
                                                <input type="email" class="form-control input-lg" id="email" name="email" placeholder="{{ __('Correo electrónico') }}" value="{{ auth()->user()->email }}" disabled>
                                                @else
                                                <input type="email" class="form-control input-lg" id="email" name="email" placeholder="{{ __('Correo electrónico') }}" value="{{ old('email') }}" required>
                                                @endif

                                                @error('email')
                                                <span class="help-block">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6 col-lg-6 col-6 @error('phone') has-error @enderror">
                                                <label for="phone">
                                                    {{ __('Télefono') }}<sup class="text-danger">*</sup>
                                                </label>

                                                <input type="text" class="form-control input-lg" id="phone" name="phone" maxlength="14" placeholder="{{ __('Télefono') }}" value="{{ old('phone') }}" required>

                                                @error('phone')
                                                <span class="help-block">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- <div class="row">
                                            <div class="form-group col-md-6  @error('alias') has-error @enderror">
                                                <label for="alias">
                                                    {{ __('Alias Dirección') }}
                                                </label>
                                                <input type="text" class="form-control input-lg" 
                                                id="alias" name="alias" 
                                                placeholder="{{ __('Alias dirección') }}" 
                                                value="{{ old('alias') }}">

                                                @error('alias')
                                                <span class="help-block">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div> -->
                                        @if(Auth::check())
                                        @include('landing.cart.address-list')
                                        @else
                                        <div class="row">
                                            <div class="form-group col-md-8 @error('line') has-error @enderror">
                                                <label for="line">
                                                    {{ __('Dirección') }}<sup class="text-danger">*</sup>
                                                </label>

                                                <input type="text" class="form-control input-lg" id="line" name="line" placeholder="{{ __('Calle(s), número, colonia, avenida, bulevar, etc.') }}" value="{{ old('line') }}" required>

                                                @error('line')
                                                <span class="help-block">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4 @error('secondary_line') has-error @enderror">
                                                <label for="secondary-line" style="visibility: hidden;">{{ __('Dirección complementaria') }}</label>

                                                <input type="text" class="form-control input-lg" id="secondary-line" name="secondary_line" placeholder="{{ __('Apartamento, edificio, oficina, etc.') }}" value="{{ old('secondary_line') }}">

                                                @error('secondary_line')
                                                <span class="help-block">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4 @error('zipcode') has-error @enderror">
                                                <label for="zipcode">
                                                    {{ __('Código Postal (zip code)') }}<sup class="text-danger">*</sup>
                                                </label>

                                                <input type="text" class="form-control input-lg" id="zipcode" name="zipcode" placeholder="{{ __('Código Postal (zip code)') }}" value="{{ old('zipcode') }}" required>

                                                <!-- Gets the name country hidden -->
                                                <input type="hidden" value="United States" name="country">

                                                @error('zipcode')
                                                <span class="help-block">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4 @error('city') has-error @enderror">
                                                <label for="city">
                                                    {{ __('Ciudad') }}<sup class="text-danger">*</sup>
                                                </label>

                                                <input type="text" class="form-control input-lg" id="city" name="city" placeholder="{{ __('Ciudad') }}" value="{{ old('city') }}" required>

                                                @error('city')
                                                <span class="help-block">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4 @error('state') has-error @enderror">
                                                <label for="state">
                                                    {{ __('Estado') }}<sup class="text-danger">*</sup>
                                                </label>
                                                <select name="state" id="state" class="form-control input-lg" required>
                                                    <option value="" disabled selected>{{ __('Seleccionar estado...') }}</option>
                                                    @foreach (config('shipping.states') as $key => $state)
                                                    <option value="{{ $key }}">{{ $state }}</option>
                                                    @endforeach
                                                </select>

                                                @error('state')
                                                <span class="help-block">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @guest
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="checkbox" style="margin-top: 0px;margin-bottom: 0px;">
                                                <label> <input type="checkbox" style="position: inherit;" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    {{ __('Guardar mi información para compras más rápidas.') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endguest
                            </div>

                            <div class="card-body">
                            
                                <div class="form-group col-md-6 @error('code_coupon') has-error @enderror">
                                    <label for="first-name">
                                        {{ __('Codigo cupón de descuento') }}<sup class="text-danger">*</sup>
                                    </label>

                                    <input type="text" class="form-control input-lg" id="first-name" name="code_coupon" placeholder="{{ __('ingrese codigo de descuento, si es posible') }}">

                                    @error('code_coupon')
                                    <span class="help-block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="pull-left" role="group">
                                    <a class="btn btn-link btn-lg" title="{{ __('Cancelar Orden') }}" onclick="window.location='{{ route('landing.products.index') }}';">
                                        <i class="fas fa-chevron-left"></i>
                                        {{ __('Seguir comprando') }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="pull-right" role="group">
                                    @guest
                                    <!-- <label for=""> Más gastos de envio personalizados</label> -->
                                    <button type="submit" class="btn_3" title="{{ __('ir a checkout') }}" style="cursor: pointer;">

                                        {{ __('ir a checkout') }}
                                    </button>
                                    @else
                                    @if (auth()->user()->is_customer)
                                    <!-- <label for=""> Más gastos de envio personalizados</label> -->
                                    <button type="submit" class="btn_3" title="{{ __('ir a checkout') }}" style="cursor: pointer;">
                                        {{ __('ir a checkout') }}
                                    </button>
                                    @endif
                                    @endguest
                                </div>
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
@endsection