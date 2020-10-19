@extends('layouts.dashboard.app')
@section('title', __('Nuevo Producto'))

@section('breadcrumb')
<div>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb breadcrumb-style1 mg-b-10">
			<li class="breadcrumb-item">
				<a href="javascript:;">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="{{ route('dashboard.products.index') }}" title="{{ __('Productos') }}">{{ __('Productos') }}</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">
				{{ $product->name }}
			</li>
		</ol>
	</nav>
	<h4 class="mg-b-0 tx-spacing--1">
		{{ __('Editar Producto') }}
	</h4>
</div>
<div>
	<a href="{{ route('dashboard.products.index') }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
		<i data-feather="x" class="wd-10 mg-r-5"></i> {{ __('Cancelar') }}
	</a>
	<button type="submit" class="btn btn-sm pd-x-15 btn-info btn-uppercase mg-l-5" id="products-update-form-submit-button" data-content-before-submit='<i data-feather="refresh-cw" class="wd-10 mg-r-5"></i> {{ __('Guardar Cambios') }}' data-content-after-submit='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __('Cargando...') }}'>
		<i data-feather="refresh-cw" class="wd-10 mg-r-5"></i> {{ __('Guardar Cambios') }}
	</button>
</div>
@endsection

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif

<form id="products-update-form" action="{{ route('dashboard.products.update', compact('product')) }}" method="POST" role="form" autocomplete="off" enctype='multipart/form-data'>
	@csrf @method('PUT')
	<div class="row row-xs">
		<div class="col-sm-12 col-lg-12">
			<div class="card card-body">
				<div class="row">
					<div class="col-md-12">
						<fieldset class="form-fieldset">
							<legend>Información General</legend>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label class="d-block" for="name">{{ __('Nombre del producto') }}</label>
									<input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Nombre comercial del producto') }}" value="{{ old('name', $product->name) }}" autofocus>
									@error('name')
									<span class="invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
								<div class="form-group col-md-2">
									<label class="d-block" for="unit-price">{{ __('Costo adquisición') }}</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">{{ __('$') }}</span>
										</div>
										<input type="text" id="unit-price" name="unit_price" class="form-control @error('unit_price') is-invalid @enderror" placeholder="{{ format_price(1234567.89, '', '') }}" data-mask-price="true" value="{{ old('unit_price', $product->unit_price) }}" required>
										@error('unit_price')
										<span class="invalid-feedback">{{ $message }}</span>
										@enderror
									</div>
								</div>

								<div class="form-group col-md-2">
									<label class="d-block" for="price">{{ __('Precio de venta') }}</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">{{ __('$') }}</span>
										</div>
										<input type="text" id="price" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="{{ format_price(1234567.89, '', '') }}" data-mask-price="true" value="{{ old('price', $product->price) }}" required>
										@error('price')
										<span class="invalid-feedback">{{ $message }}</span>
										@enderror
									</div>
								</div>

								<div class="form-group col-md-2">
									<label class="d-block">{{ __('% De Ganancia') }}</label>
									<div class="input-group">
										<input type="text" id="gain-percentage" class="form-control" disabled>
										<div class="input-group-append">
											<span class="input-group-text">%</span>
										</div>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label class="d-block" for="description">{{ __('Descripción') }}</label>
									<textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="6" placeholder="Textarea">{{ old('description', $product->description) }}</textarea>
									@error('description')
									<span class="invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
								<div class="form-group col-md-6">
									<div class="form-row">
										<div class="form-group col-6">
											@inject('relatedProducts', 'App\Models\Product')

											<label class="d-block" for="related">
												{{ __('Productos Relacionados') }}
												<i class="wd-15" data-feather="help-circle" data-toggle="tooltip" data-placement="top" title="{{ __('Blah') }}"></i>
											</label>
											<select class="form-control select2" id="related" name="related[]" multiple data-placeholder="{{ __('Seleccionar uno o varios productos') }}">
												@foreach ($relatedProducts->all() as $key => $relatedProduct)
												<option value="{{ $relatedProduct->id }}" {{ collect(old('related'))->contains($product->related) ? 'selected' : '' }}>{{ $relatedProduct->name }}</option>
												@endforeach
											</select>
										</div>

										<div class="form-group col-6">
											<label class="d-block" for="categories_id">
												{{ __('Categorias') }}
											</label>
											<select class="form-control select2" id="categories_id" name="categories_id[]" multiple data-placeholder="{{ __('Seleccionar uno o varias categorias') }}">
												@foreach ($categories as $category)
												<option value="{{ $category->id }}" {{ collect(old('categories_id'))->contains($category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-6">
											<label class="d-block" for="related">
												{{ __('Rastrear cantidad') }}
												<i class="wd-15" data-feather="help-circle" data-toggle="tooltip" data-placement="top" title="{{ __('Al rastrear la cantidad, cada vez que un cliente adquiera un producto, automaticamente se disminuira esta cantidad hasta que el producto este agotado.') }}"></i>
											</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<div class="custom-control custom-checkbox pd-l-15">
															<input type="checkbox" class="custom-control-input" id="track-stock" name="track_stock" value="{{ true }}" {{ old('track_stock', $product->track_stock) ? 'checked' : '' }} onclick="this.checked ? document.getElementById('stock').removeAttribute('disabled') : document.getElementById('stock').setAttribute('disabled', true);document.getElementById('stock').value=''">
															<label class="custom-control-label" for="track-stock"></label>
														</div>
													</div>
												</div>
												<input type="text" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" data-mask-price="true" placeholder="{{ __('Cantidad de productos disponibles') }}" value="{{ old('stock', $product->stock) }}" min="1">
												@error('stock')
												<span class="invalid-feedback">{{ $message }}</span>
												@enderror
											</div>
										</div>

										<div class="form-group col-6">
											<label class="d-block" for="cover-image">{{ __('Portada') }}</label>
											<div class="custom-file">
												<input type="file" class="custom-file-input @error('cover_image') is-invalid @enderror" id="cover-image" name="cover_image" accept="image/*">
												<label class="custom-file-label" for="cover-image">{{ __('Seleccionar imagen') }}</label>
												<small id="passwordHelpBlock" class="form-text text-muted">
													{{ __('El peso de la imagen, debe de ser inferior a: 5 MB') }}
												</small>
												@error('cover_image')
												<span class="invalid-feedback">{{ $message }}</span>
												@enderror
											</div>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<fieldset class="form-fieldset">
							<legend>Información del producto</legend>
							<div class="form-row">
								<div class="form-group col-md-2">
									<label class="d-block">{{ __('Unidad de medida') }}</label>
									<div class="input-group">
										<input type="text" value="In" class="form-control" disabled>
									</div>
								</div>
								<div class="form-group col-md-2">
									<label class="d-block" for="unit-price">{{ __('Longitud') }}</label>
									<div class="input-group">
										<div class="input-group-prepend">
										</div>
										<input type="number" name="length" class="form-control @error('length') is-invalid @enderror" placeholder="12.00" data-mask-price="true" value="{{ old('length', $product->length) }}" required>
										@error('length')
										<span class="invalid-feedback">{{ $message }}</span>
										@enderror
									</div>
								</div>

								<div class="form-group col-md-2">
									<label class="d-block" for="unit-price">{{ __('Ancho') }}</label>
									<div class="input-group">
										<div class="input-group-prepend">
										</div>
										<input type="number" name="width" class="form-control @error('width') is-invalid @enderror" placeholder="12.00" data-mask-price="true" value="{{ old('width', $product->width) }}" required>
										@error('width')
										<span class="invalid-feedback">{{ $message }}</span>
										@enderror
									</div>
								</div>

								<div class="form-group col-md-2">
									<label class="d-block" for="unit-price">{{ __('Altura') }}</label>
									<div class="input-group">
										<div class="input-group-prepend">
										</div>
										<input type="number" name="height" class="form-control @error('height') is-invalid @enderror" placeholder="12.00" data-mask-price="true" value="{{ old('height', $product->height) }}" required>
										@error('height')
										<span class="invalid-feedback">{{ $message }}</span>
										@enderror
									</div>
								</div>
							</div>
							<div class="form-row">

								<div class="form-group col-md-2">
									<label class="d-block">{{ __('Unidad de peso') }}</label>
									<div class="input-group">
										<input type="text" value="Kg" class="form-control" disabled>
									</div>
								</div>
								<div class="form-group col-md-2">
									<label class="d-block" for="unit-price">{{ __('Peso') }}</label>
									<div class="input-group">
										<div class="input-group-prepend">
										</div>
										<input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror" placeholder="12.00" data-mask-price="true" value="{{ old('weight', $product->weight) }}" required>
										@error('weight')
										<span class="invalid-feedback">{{ $message }}</span>
										@enderror
									</div>
								</div>
								<div>
						</fieldset>
					</div>
				</div>
				<hr>
				<div class="row" id="product-gallery">
					<div class="col-md-12">
						<fieldset class="form-fieldset">
							<legend>{{ __('Imagenes comerciales del producto') }}</legend>
							<div class="form-row d-flex justify-content-end">
								<div class="form-group col-md-4">
									<div class="custom-file">
										<input type="file" multiple class="custom-file-input" id="gallery" accept="image/*">
										<label class="custom-file-label" for="gallery" data-browse="{{ __('Buscar') }}">{{ __('Seleccionar imagen(es)') }}</label>
										<small id="passwordHelpBlock" class="form-text text-muted">
											{{ __('El peso de la imagen, debe de ser inferior a: 5 MB') }}
										</small>
									</div>
								</div>
							</div>
							<div class="form-row" id="gallery-container">
								@foreach ($product->gallery as $image)
								@unless ($image->id === $product->cover->id)
								<figure class="pos-relative mb-5 mt-4 wd-lg-15p col-xl-3 col-lg-3 col-md-4 col-xs-6" data-id="{{ $image->id }}">
									<img src="{{ $image->public_url }}" class="img-fit-cover img-thumbnail" style="cursor: move;cursor: -webkit-grabbing;object-fit: contain;">
									<figcaption class="mt-1 d-flex justify-content-center">
										<div class="btn-group">
											<a href="{{ $image->public_url }}" download="{{ $image->public_url }}" class="btn btn-dark btn-icon">
												<i data-feather="download"></i>
											</a>
											<a href="{{ route('dashboard.products.update', compact('product')) }}" class="btn btn-dark btn-icon" data-delete-image="{{ $image->id }}">
												<i data-feather="trash-2"></i>
											</a>
										</div>
									</figcaption>
								</figure>
								@endunless
								@endforeach
							</div>
						</fieldset>
					</div>
				</div>
				<div class="row" id="product-gallery">
					<div class="col-md-12">
						<fieldset class="form-fieldset">
							<legend>{{ __('Videos comerciales del producto') }}</legend>
							<div class="form-row d-flex justify-content-end">
								<div class="form-group col-md-4">
									<div class="custom-file">
										<input type="file" multiple class="custom-file-input" id="gallery-videos" accept="video/*">
										<label class="custom-file-label" for="gallery" data-browse="{{ __('Buscar') }}">{{ __('Seleccionar video(s)') }}</label>
									</div>
								</div>
							</div>
							<div class="form-row" id="gallery-container">
								@foreach ($product->gallery as $file)
								@unless ($file->id === $product->cover->id)
								@if($file->mimetype == 'video')
								<figure class="pos-relative mb-5 mt-4 wd-lg-15p col-xl-3 col-lg-3 col-md-4 col-xs-6" data-id="{{ $file->id }}">
									<!-- <img src="{{ $file->public_url }}" class="img-fit-cover img-thumbnail" style="cursor: move;cursor: -webkit-grabbing;object-fit: contain;"> -->
									<video controls class=" img-thumbnail" style="cursor: move;cursor: -webkit-grabbing;object-fit: scale-down;width: 400px;height: 200px;">
										<source src="{{ $file->public_url }}" >
										Your browser does not support the video tag.
									</video>
									<figcaption class="mt-1 d-flex justify-content-center">
										<div class="btn-group">
											<a href="{{ $file->public_url }}" download="{{ $file->public_url }}" class="btn btn-dark btn-icon">
												<i data-feather="download"></i>
											</a>
											<a href="{{ route('dashboard.products.update', compact('product')) }}" class="btn btn-dark btn-icon" data-delete-image="{{ $file->id }}">
												<i data-feather="trash-2"></i>
											</a>
										</div>
									</figcaption>
								</figure>
								@endif
								@endunless
								@endforeach
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

@push('modals')
<div class="modal fade" id="progressbar-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel6" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content tx-14">
			<div class="modal-body">
				<h4 class="text-center text-uppercase">
					{{ __('Cargando Archivos...') }} <br>
					<div class="spinner-border mt-1" role="status">
						<span class="sr-only">{{ __('Cargando Archivos...') }}</span>
					</div>
				</h4>
			</div>
		</div>
	</div>
</div>
@endpush
@endsection

@push('js')
<script type="text/javascript">
	$('#unit-price').trigger('input');

	$('#price').trigger('input');
</script>
@endpush