@extends('layouts.dashboard.app')

@section('title', __('Cupón Registrados'))

@section('breadcrumb')
<div>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb breadcrumb-style1 mg-b-10">
			<li class="breadcrumb-item">
				<a href="javascript:;">Dashboard</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">
				{{ __('Cupónes') }}
			</li>
		</ol>
	</nav>
	<h4 class="mg-b-0 tx-spacing--1">
		{{ __('Cupónes Registrados') }}
	</h4>
</div>
<a href="{{ route('dashboard.coupons.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
	<i data-feather="plus" class="wd-10 mg-r-5"></i>
	{{ __('Nuevo cupón') }}
</a>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<table id="discounts-table" class="table table-hover">
					<thead>
						<tr>
							<th class="wd-15p">{{ __('Nombre') }}</th>
							<th class="wd-15p">{{ __('Imagen') }}</th>
							<th class="wd-15p">{{ __('Porcentaje') }}</th>
							<th class="wd-15p">{{ __('Creado') }}</th>
							<th class="wd-15p">{{ __('Fecha inicio') }}</th>
							<th class="wd-15p">{{ __('Fecha fin') }}</th>
							<th class="wd-15p">{{ __('Activo') }}</th>
							<th class="wd-5p"></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($coupons as $coupon)
						<tr class="text-capitalize">
							<td width="10%">
								{{ $coupon->name ?? 'Sin nombre' }}
							</td>
							<td>

								@if($coupon->cover)
								<li class="d-flex align-items-center">
									<a href="{{ asset($coupon->cover->public_url) }}" title="{{ __('Ver imagen') }}" target="_blank">
										<img src="{{ asset($coupon->cover->public_url) }}" class="wd-40 mg-r-15" alt="{{ $coupon->name }}">
									</a>
								</li>
								@else
									{{ __('Sin imagen')}}
								@endif
							</td>
							<td>
								{{ format_price($coupon->percent, '%', '') }}
							</td>


							<td>
								{{ $coupon->created_at->isoFormat('LLL') }}
							</td>

							<td width="20%">
								{{ $coupon->start_date ? $coupon->start_date->isoFormat('LLL') : 'Sin limite' }}
							</td>

							<td width="20%">
								{{ $coupon->end_date ? $coupon->end_date->isoFormat('LLL') : 'Sin limite' }}
							</td>

							<td>
								<span style="color: {{ $coupon->is_active ? 'green' : 'brown' }};"> {{ $coupon->is_active ? 'SI' : 'NO' }} </span>
							</td>

							<td width="5%">
								<nav class="nav d-flex justify-content-center">
									<a class="nav-link tx-bold text-muted" href="#" data-toggle="dropdown">
										<span class="d-none d-sm-block d-md-none d-block">
											Opciónes <i data-feather="chevron-down"></i>
										</span>
										<i data-feather="more-horizontal" class="d-sm-none d-md-block"></i>
									</a>
									<div class="dropdown-menu tx-13 tx-bold">

										<a href="{{ route('dashboard.coupons.edit', $coupon) }}" class="dropdown-item text-primary">
											<i data-feather="edit" class="wd-15 ht-15"></i>
											{{ __('Editar') }}
										</a>
										<a href="#coupon-delete-{{ $coupon->id }}-modal" data-toggle="modal" data-animation="effect-scale" class="dropdown-item text-danger">
											<i data-feather="trash" class="wd-15 ht-15"></i>
											{{ __('Eliminar') }}
										</a>
									</div>
								</nav>
							</td>
						</tr>
						@push('modals') @include('dashboard.coupons.delete', compact('coupon')) @endpush
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection