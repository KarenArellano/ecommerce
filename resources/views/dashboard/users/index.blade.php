@extends('layouts.dashboard.app')

@section('title', __('Usuarios'))

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
		{{ __('Usuarios') }}
	</h4>
</div>

@endsection

@section('content')
<div class="row justify-content-center">
	<div class="col-12">

		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item" role="presentation">
				<a class="nav-link active" data-toggle="tab" href="#USERS" role="tab" aria-selected="true">USUARIOS</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" data-toggle="tab" href="#USERS_ORDER" role="tab" aria-selected="false">USUARIOS CON COMPRAS</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="USERS" role="tabpanel" aria-labelledby="home-tab">
				<!-- <h3>TODOS LOS USUARIOS</h3> -->
				<div class="row paddings">
					<div class="col-lg-7 col-md-6 col-sm-0"></div>
					<div class="col-lg-2 col-md-3 col-sm-12">
						<!-- <button class="btn btn-sm pd-x-15 btn-success send-emails-users btn-uppercase mg-l-5">Enviar correos</button> -->
						<a href="javascript:;" data-toggle="modal" data-target="#email-modal" class="btn btn-sm pd-x-15 btn-success send-emails-users btn-uppercase mg-l-5">
							{{ __('Enviar correos') }}
						</a>
						@push('modals') @include('dashboard.users.modal') @endpush
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12">
						<a href="{{ url('dashboard/download/users') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
							<i data-feather="download" class="wd-10 mg-r-5"></i>
							{{ __('Exportar usuarios') }}
						</a>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<table id="users-table" class="table table-hover users-table" table-layout="fixed">
							<thead>
								<tr>
									<th class="wd-15p">{{ __('Nombres') }}</th>
									<th class="wd-15p">{{ __('Correo') }}</th>
									<th class="wd-15p">{{ __('Teléfono') }}</th>
									<th class="wd-15p">{{ __('Enviar correo') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($users as $user)
								<tr>
									<td>
										{{ $user->name }}
										<input type="hidden" name="_userid" value="{{ $user->id }}">
									</td>

									<td id="">
										<a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
									</td>

									<td>
										{{ $user->phone }}
									</td>

									<td>
										<input type="checkbox" class="checkbox_check">
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="USERS_ORDER" role="tabpanel" aria-labelledby="profile-tab">
				<!-- <h2>USUARIOS CON COMPRAS REALIZAAS</h2> -->
				<div class="row paddings">
					<div class="col-3 offset-9">
						<a href="{{ url('dashboard/dowload/users/order') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
							<i data-feather="download" class="wd-10 mg-r-5"></i>
							{{ __('Exportar usuarios') }}
						</a>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<table id="users-order-table" class="table table-hover" table-layout="fixed">
							<thead>
								<tr>
									<th class="wd-15p">{{ __('Nombres') }}</th>
									<th class="wd-15p">{{ __('Correo') }}</th>
									<th class="wd-15p">{{ __('Teléfono') }}</th>

									<th class="wd-15p">{{ __('Referencia') }}</th>
									<th class="wd-15p">{{ __('Total') }}</th>
									<th class="wd-15p">{{ __('Fecha de pago') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($user_orders as $user_order)
								<tr>
									<td>
										{{ $user_order->name }}
									</td>

									<td>
										<a href="mailto:{{ $user_order->email }}">{{ $user_order->email }}</a>
									</td>

									<td>
										{{ $user_order->phone }}
									</td>
									<td>
										{{ $user_order->transaction_id}}
									</td>
									<td>
										{{ format_price($user_order->total, 'USD') }}
									</td>
									<td>
										{{
											\Carbon\Carbon::createFromTimeStamp(strtotime($user_order->paid_at))->diffForHumans()
										}}
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

@endsection