@extends('layouts.dashboard.app')

@section('title', __('Publicaciones'))

@section('breadcrumb')
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('Publicaciones') }}
            </li>
        </ol>
    </nav>
    <h4 class="mg-b-0 tx-spacing--1">
        {{ __('Publicaciones Registradas') }}
    </h4>
</div>
<div class="d-md-block">
    <a href="{{ route('dashboard.posts.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5">
        <i data-feather="plus" class="wd-10 mg-r-5"></i> {{ __('Nueva Publicacion') }}
    </a>
</div>
@endsection

@section('content')
<div class="row row-xs">
    <div class="col-sm-12 col-lg-12">
        <div class="card card-body">
            <table id="posts-table" class="table table-hover">
                <thead>
                    <tr>
                        <th class="wd-15p">{{ __('Titulo') }}</th>
                        <th class="wd-15p">{{ __('Extracto') }}</th>
                        <th class="wd-15p">{{ __('Autor') }}</th>
                        <th class="wd-15p">{{ __('Publicación') }}</th>
                        <th class="wd-15p">{{ __('Actividad') }}</th>
                        <th class="wd-15p">{{ __('Edición') }}</th>
                        <th class="wd-5p"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                    <tr>
                        <td width="20%" class="text-capitalize">
                            <li class="d-flex align-items-center">
                                @if ($post->cover_url)
                                <a href="{{ asset($post->cover_url) }}" title="{{ __('Ver imagen') }}" target="_blank">
                                    <img src="{{ asset($post->cover_url) }}" class="wd-60 mg-r-15" alt="{{ $post->title }}">
                                </a>
                                @endif
                                <div>
                                    <a href="#" target="_blank">
                                        {{ $post->title }}
                                    </a>
                                </div>
                            </li>
                        </td>
                        <td width="20%">
                            {{ $post->excerpt }}
                        </td>
                        <td width="10%">
                            <span class="badge badge-{{ $post->user ? 'dark' : 'secondary' }} tx-14">
                                {{ $post->user ? $post->user->first_name : 'Sistema' }}
                            </span>
                        </td>
                        <td width="10%">
                            {{ $post->published_at ? $post->published_at->isoFormat('lll') : '' }}
                        </td>
                        <td width="5%">
                            <span class="badge badge-{{ $post->is_published ? 'success' : 'warning' }} tx-14">
                                {{ $post->is_published ? 'Publicada' : 'Borrador' }}
                            </span>
                        </td>
                        <td width="5%">
                            <span class="badge badge-light tx-14">
                                {{ $post->updated_at->diffForHumans() }}
                            </span>
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
                                    <a href="{{ route('dashboard.posts.edit', $post) }}" class="dropdown-item text-primary">
                                        <i data-feather="edit" class="wd-15 ht-15"></i>
                                        {{ __('Editar') }}
                                    </a>
                                    <a href="#posts-delete-{{ $post->id }}-modal" data-toggle="modal" data-animation="effect-scale" class="dropdown-item text-danger">
                                        <i data-feather="trash" class="wd-15 ht-15"></i>
                                        {{ __('Eliminar') }}
                                    </a>
                                </div>
                            </nav>
                        </td>
                    </tr>
                    @push('modals') @include('dashboard.posts.delete', compact('post')) @endpush
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
