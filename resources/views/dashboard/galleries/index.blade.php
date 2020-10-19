@extends('layouts.dashboard.app')

@section('title', __('Publicaciones - Galería'))

@section('breadcrumb')
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.galleries.index') }}">{{ __('Publicaciones') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('Galería') }}
            </li>
        </ol>
    </nav>
    <h4 class="mg-b-0 tx-spacing--1">
        {{ __('Galería Disponible') }}
    </h4>
</div>
<div class="d-md-block">
    <a href="{{ route('dashboard.galleries.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
        <i data-feather="plus" class="wd-10 mg-r-5"></i> {{ __('Nueva Imagen') }}
    </a>
</div>
@endsection

@section('content')
<div class="row row-xs">
    <div class="col-sm-12 col-lg-12">
        <div class="card card-body">
            <table id="galleries-table" class="table table-hover">
                <thead>
                    <tr>
                        <th class="wd-10p"></th>
                        <th class="wd-15p">{{ __('Titulo') }}</th>
                        <th class="wd-15p">{{ __('Descripción') }}</th>
                        <th class="wd-5p"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($galleries as $gallery)
                    <tr>
                        <td width="5%" class="text-capitalize">
                            <li class="d-flex align-items-center">
                                <a href="{{ asset($gallery->image->public_url) }}" title="{{ __('Ver imagen') }}" target="_blank">
                                    <img src="{{ asset($gallery->image->public_url) }}" class="wd-100p mg-r-15" alt="{{ $gallery->image->public_url }}">
                                </a>
                            </li>
                        </td>
                        <td width="20%">
                            {{ $gallery->title }}
                        </td>
                        <td width="20%">
                            {{ Str::limit($gallery->description, 50) }}
                        </td>
                        <td width="5%">
                            <nav class="nav d-flex justify-content-center">
                                <a class="nav-link tx-bold text-muted"  href="#" data-toggle="dropdown">
                                    <span class="d-none d-sm-block d-md-none d-block">
                                        Opciónes <i data-feather="chevron-down"></i>
                                    </span>
                                    <i data-feather="more-horizontal" class="d-sm-none d-md-block"></i>
                                </a>
                                <div class="dropdown-menu tx-13 tx-bold">
                                    <a href="{{ route('dashboard.galleries.edit', $gallery) }}" class="dropdown-item text-primary">
                                        <i data-feather="edit" class="wd-15 ht-15"></i>
                                        {{ __('Editar') }}
                                    </a>
                                    <a href="#galleries-delete-{{ $gallery->id }}-modal" data-toggle="modal" data-animation="effect-scale" class="dropdown-item text-danger">
                                        <i data-feather="trash" class="wd-15 ht-15"></i>
                                        {{ __('Eliminar') }}
                                    </a>
                                </div>
                            </nav>
                        </td>
                    </tr>
                    @push('modals') @include('dashboard.galleries.delete', compact('gallery')) @endpush
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
