@extends('layouts.dashboard.app')

@section('title', __('Categorias Registrados'))

@section('breadcrumb')
<div>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb breadcrumb-style1 mg-b-10">
			<li class="breadcrumb-item">
				<a href="javascript:;">Dashboard</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">
				{{ __('Categorias') }}
			</li>
		</ol>
	</nav>
	<h4 class="mg-b-0 tx-spacing--1">
		{{ __('Categorias Registrados') }}
	</h4>
</div>
<a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
	<i data-feather="plus" class="wd-10 mg-r-5"></i>
	{{ __('Nueva Categoria') }}
</a>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<table id="categories-table" class="table table-hover">
					<thead>
						<tr>
							<th class="wd-15p">{{ __('Nombre') }}</th>
							<th class="wd-15p">{{ __('Productos Asociados') }}</th>
							<th class="wd-5p"></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($categories as $category)
						<tr>
							<td class="text-capitalize">
								{{ $category->name }}
							</td>
							<td>
								{{ __(':count producto(s)', ['count' => $category->products->count()]) }}
							</td>
							<td>
								<nav class="nav d-flex justify-content-center">
									<a class="nav-link tx-bold text-muted"  href="#" data-toggle="dropdown">
										<span class="d-none d-sm-block d-md-none d-block">
											Opciónes <i data-feather="chevron-down"></i>
										</span>
										<i data-feather="more-horizontal" class="d-sm-none d-md-block"></i>
									</a>
									<div class="dropdown-menu tx-13 tx-bold">
										<a href="{{ route('dashboard.categories.edit', $category) }}" class="dropdown-item text-primary">
											<i data-feather="edit" class="wd-15 ht-15"></i>
											{{ __('Editar') }}
										</a>
										<a href="#categories-delete-{{ $category->id }}-modal" data-toggle="modal" data-animation="effect-scale" class="dropdown-item text-danger">
											<i data-feather="trash" class="wd-15 ht-15"></i>
											{{ __('Eliminar') }}
										</a>
									</div>
								</nav>
							</td>
						</tr>
						@push('modals') @include('dashboard.categories.delete', compact('category')) @endpush
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
