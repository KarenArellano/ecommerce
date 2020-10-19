@extends('layouts.dashboard.app')

@section('title', __('Ordenes Registradas'))

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
		{{ __('Ordenes Registradas') }}
	</h4>
</div>
@endsection

@section('content')
<div class="row justify-content-center">

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
	<div class="col-12">

		<!-- MENU OPTIONS -->
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item" role="presentation">
				<a class="nav-link active" data-toggle="tab" href="#ORDER_NOSHIPPED" role="tab" aria-selected="true">ORDENES NO ENVIADAS</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" data-toggle="tab" href="#ORDER_SHIPPED" role="tab" aria-selected="false">ORDENES ENVIADAS</a>
			</li>
		</ul>
		<!-- END MENU OPTIONS -->

		<div class="tab-content">
			<div class="tab-pane active" id="ORDER_NOSHIPPED" role="tabpanel" aria-labelledby="home-tab">
				@include('dashboard.orders.paid')
			</div>

			<div class="tab-pane" id="ORDER_SHIPPED" role="tabpanel" aria-labelledby="profile-tab">
				@include('dashboard.orders.shipped-order')
			</div>
		</div>
	</div>
	@endsection

	@push('modals') @include('dashboard.orders.products') @endpush

	@push('modals') @include('dashboard.orders.reprint') @endpush