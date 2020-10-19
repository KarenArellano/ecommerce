@extends('layouts.dashboard.app')

@section('title', __('Productos Registrados'))

@section('breadcrumb')
<div>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb breadcrumb-style1 mg-b-10">
				<li class="breadcrumb-item">
					<a href="javascript:;">Dashboard</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">
					{{ __('Productos') }}
				</li>
			</ol>
	</nav>
	<h4 class="mg-b-0 tx-spacing--1">
		{{ __('Productos Registrados') }}
	</h4>
</div>
<a href="{{ route('dashboard.products.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
	<i data-feather="plus" class="wd-10 mg-r-5"></i>
	{{ __('Nuevo Producto') }}
</a>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<table id="products-table" class="table table-hover">
					<thead>
						<tr>
							<th class="wd-15p">{{ __('Nombre') }}</th>
							<th class="wd-15p">{{ __('Costo adquisición') }}</th>
							<th class="wd-15p">{{ __('Precio de venta') }}</th>
							<th class="wd-15p">{{ __('% De Ganancia') }}</th>
							<th class="wd-15p">{{ __('Ganancias Netas') }}</th>
							<th class="wd-15p">{{ __('Ventas') }}</th>
							<th class="wd-15p">{{ __('Existencias') }}</th>
							<th class="wd-5p"></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($products as $product)
						<tr class="text-capitalize">
							<td width="20%">
								<li class="d-flex align-items-center">
									<a href="{{ asset($product->cover->public_url) }}" title="{{ __('Ver imagen') }}" target="_blank">
										<img src="{{ asset($product->cover->public_url) }}" class="wd-40 mg-r-15" alt="{{ $product->name }}">
									</a>
									<div>
										<a href="{{ route('landing.products.show', $product) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Ver producto en la tienda') }}" target="_blank">
											{{ $product->name }}
										</a>
									</div>
								</li>
							</td>
							<td width="10%">
								{{ format_price($product->unit_price, 'USD') }}
							</td>
							<td width="10%">
								{{ format_price($product->price, 'USD') }}
							</td>
							<td width="10%">
								{{ format_price($product->gain_percentage, '%', '') }}
							</td>
							<td width="10%">
								{{ format_price($product->orders->sum('pivot.total'), 'USD') }}
							</td>
							<td width="10%">
								<span class="badge badge-{{ $product->orders->count() ? 'primary' : 'secondary' }} tx-14">
									{{
										trans_choice(
											'{0} Sin ventas|[1] :count Producto vendido|[2,*] :count Productos vendidos',
											$product->orders->count(),
											['count' => $product->orders->count()]
										)
									}}
								</span>
							</td>
							<td width="5%">
								@if ($product->track_stock)
								@if ($product->stock === 0)
								<span class="badge badge-danger tx-14">{{ __('Agotado') }}</span>
								@else
								<span class="badge badge-{{ $product->stock <=5 ? 'warning' : 'dark' }} tx-14">{{ __(':count restantes', ['count' => $product->stock]) }}</span>
								@endif
								@else
								<span class="badge badge-light tx-14">{{ __('Ilimitada') }}</span>
								@endif
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
										<a href="{{ route('dashboard.products.edit', $product) }}" class="dropdown-item text-primary">
											<i data-feather="edit" class="wd-15 ht-15"></i>
											{{ __('Editar') }}
										</a>
										<a href="#products-delete-{{ $product->id }}-modal" data-toggle="modal" data-animation="effect-scale" class="dropdown-item text-danger">
											<i data-feather="trash" class="wd-15 ht-15"></i>
											{{ __('Eliminar') }}
										</a>
									</div>
								</nav>
							</td>
						</tr>
						@push('modals') @include('dashboard.products.delete', compact('product')) @endpush
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection