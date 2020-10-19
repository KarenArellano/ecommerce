@extends('layouts.dashboard.app')

@section('title', __('Reimprimir etiqueta'))

@section('breadcrumb')
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item">
                <a href="javascript:;">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('Ordenes') }}
            </li>
        </ol>
    </nav>
    <h4 class="mg-b-0 tx-spacing--1">
        {{ __('Reimprimir etiqueta') }}
    </h4>
</div>
@endsection
@section('content')
<form action="{{ route('dashboard.shippments.store') }}" method="POST" role="form" autocomplete="off">
    @csrf

    @if($errors->any())
    <div class="alert alert-block alert-danger">
        {{$errors->first()}}
    </div>
    @endif

    <div class="row">
        <div class="col-8">
            <input type="hidden" name="orderId" value="{{ $orderId }}">
            @forelse($rates as $key => $rate)
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
 
    <button type="submit" class="btn btn-sm pd-x-15 btn-success btn-uppercase mg-l-5">
        {{ __('Cambiar') }}
    </button>
</form>
@endsection