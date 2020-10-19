@extends('layouts.dashboard.app')

@section('title', __('Nuevo Producto'))

@section('breadcrumb')
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.products.index') }}" title="{{ __('Productos') }}">{{ __('Productos') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('Nuevo Producto') }}
            </li>
        </ol>
    </nav>
    <h4 class="mg-b-0 tx-spacing--1">
        {{ __('Nuevo Producto') }}
    </h4>
</div>
<div>
    <a href="{{ route('dashboard.products.index') }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5">
        <i data-feather="x" class="wd-10 mg-r-5"></i> {{ __('Cancelar') }}
    </a>
    <button type="submit" class="btn btn-sm pd-x-15 btn-success btn-uppercase mg-l-5" id="products-create-form-submit-button"
    data-content-before-submit='<i data-feather="save" class="wd-10 mg-r-5"></i> {{ __('Guardar') }}'
    data-content-after-submit='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __('Cargando...') }}'>
    <i data-feather="save" class="wd-10 mg-r-5"></i> {{ __('Guardar') }}
</button>
</div>
@endsection

@section('content')
<form id="products-create-form" action="{{ route('dashboard.products.store') }}" method="POST" role="form" autocomplete="off" enctype='multipart/form-data'>
    @csrf
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
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Nombre comercial del producto') }}" value="{{ old('name') }}" autofocus>
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
                                        <input type="text" id="unit-price" name="unit_price" class="form-control @error('unit_price') is-invalid @enderror" placeholder="{{ format_price(1234567.89, '', '') }}" data-mask-price="true" value="{{ old('unit_price') }}" required>
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
                                        <input type="text" id="price" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="{{ format_price(1234567.89, '', '') }}" data-mask-price="true" value="{{ old('price') }}" required>
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
                                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="6" placeholder="Textarea">{{ old('description') }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="form-row">
                                        <div class="form-group col-6">
                                            @inject('products', 'App\Models\Product')
                                            <label class="d-block" for="related">
                                                {{ __('Productos Relacionados') }}
                                                <i class="wd-15" data-feather="help-circle" data-toggle="tooltip" data-placement="top" title="{{ __('Blah') }}"></i>
                                            </label>
                                            <select class="form-control select2" id="related" name="related[]" multiple data-placeholder="{{ __('Seleccionar uno o varios productos') }}">
                                                @foreach ($products->all() as $product)
                                                <option value="{{ $product->id }}" {{ collect(old('related'))->contains($product->id) ? 'selected' : '' }}>{{ $product->name }}</option>
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
                                                            <input type="checkbox" class="custom-control-input" id="track-stock" name="track_stock" value="{{ true }}" {{ old('track_stock', false) ? 'checked' : '' }} onclick="this.checked ? document.getElementById('stock').removeAttribute('disabled') : document.getElementById('stock').setAttribute('disabled', true);document.getElementById('stock').value=''">
                                                            <label class="custom-control-label" for="track-stock"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" data-mask-price="true" placeholder="{{ __('Cantidad de productos disponibles') }}" value="{{ old('stock') }}" min="1">
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
                <div class="row d-flex justify-content-center mt-4">
                    <div class="col-md-6">
                        <div class="alert alert-info text-center" role="alert">
                            {{ __('Para agregar imagenes al producto, es necesario guardar para continuar') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@if ($errors->any())
@push('js')
<script type="text/javascript">
    $('#unit-price').trigger('input');

    $('#price').trigger('input');

</script>
@endpush
@endif
