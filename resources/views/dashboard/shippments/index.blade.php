@extends('layouts.dashboard.app')

@section('title', __('Envíos'))

@section('breadcrumb')
<div>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb breadcrumb-style1 mg-b-10">
			<li class="breadcrumb-item">
				<a href="javascript:;">Dashboard</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">
				{{ __('Envíos') }}
			</li>
		</ol>
	</nav>
	<h4 class="mg-b-0 tx-spacing--1">
		{{ __('Envíos') }}
	</h4>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
	<div class="col-12">

		<!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item" role="presentation">
				<a class="nav-link active" data-toggle="tab" href="#UNKNOWN" role="tab"aria-selected="true">DESCONOCIDOS</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" data-toggle="tab" href="#PRE_TRANSIT" role="tab" aria-selected="false">PRE TRANSITO</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" data-toggle="tab" href="#TRANSIT" role="tab" aria-selected="false">EN TRANSITO</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" data-toggle="tab" href="#DELIVERED" role="tab" aria-selected="false">DELIVERED</a>
			</li>
			
			<li class="nav-item" role="presentation">
				<a class="nav-link" data-toggle="tab" href="#RETURNED" role="tab" aria-selected="false">RETURNED</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" data-toggle="tab" href="#FAILURE" role="tab" aria-selected="false">FAILURE</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="UNKNOWN" role="tabpanel" aria-labelledby="home-tab"><h1>UNKNOWN</h1></div>
			<div class="tab-pane" id="PRE_TRANSIT" role="tabpanel" aria-labelledby="profile-tab"><h2>PRE_TRANSIT</h2></div>
			<div class="tab-pane" id="TRANSIT" role="tabpanel" aria-labelledby="profile-tab"><h2>TRANSIT</h2></div>
			<div class="tab-pane" id="DELIVERED" role="tabpanel" aria-labelledby="profile-tab"><h2>DELIVERED</h2></div>
			<div class="tab-pane" id="FAILURE" role="tabpanel" aria-labelledby="profile-tab"><h2>FAILURE</h2></div>
		</div> -->

		<div class="card">
			<div class="card-body">
				<table id="shippments-table" class="table table-hover" table-layout="fixed">
					<thead>
						<tr>
							<th class="wd-15p">{{ __('Referencia Pedido') }}</th>

							<th class="wd-15p">{{ __('Cliente') }}</th>
							<th class="wd-15p">{{ __('Total') }}</th>
							<th class="wd-15p">{{ __('Comprado') }}</th>
							<th class="wd-15p">{{ __('Opciones') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($orders as $order)
						<tr>
							<td>
								{{ $order->transaction_id }}
							</td>

							<td>
								<span class="text-capitalize">{{ $order->user->name }}</span> <br>
								<a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a>
							</td>

							<td>
								{{ format_price($order->total, 'USD') }}
							</td>

							<td>
								{{ $order->paid_at->isoFormat('LLL') }}
							</td>

							<td>
								<nav class="nav d-flex justify-content-center">
									<a class="nav-link tx-bold text-muted" href="#" data-toggle="dropdown">
										<span class="d-none d-sm-block d-md-none d-block">
											Opciónes <i data-feather="chevron-down"></i>
										</span>
										<i data-feather="more-horizontal" class="d-sm-none d-md-block"></i>
									</a>
									<div class="dropdown-menu tx-13 tx-bold">
									
										<a href="{{ $order->shipment->label_url }}" target="blank" class="dropdown-item text-primary">
											<i data-feather="file-text" class="wd-15 ht-15"></i>
											{{__('Guia de envio')}}
										</a>
										<a href="{{ $order->shipment->tracking_url_provider }}" target="blank" class="dropdown-item text-primary">
											<i data-feather="truck" class="wd-15 ht-15"></i>
											{{__('Estado de seguimiento')}}
										</a>
									</div>

								</nav>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection