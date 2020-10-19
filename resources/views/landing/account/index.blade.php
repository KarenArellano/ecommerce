@extends('layouts.landing.app')

@section('title', __('Mi cuenta - :user', ['user' => $user->first_name]))

@section('breadcrumb')
<section class="breadcrumb-area bg-img bg-overlay" style="background-image: url({{ asset('images/secciones-banners.jpg') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h2 class="page-title">{{ __('Mi Cuenta') }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">
                                    <i class="icon_house_alt"></i> {{ __('Inicio') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $user->first_name }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container-fluid pt-5">
    <div class="offset-md-2 col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">
                                {{ __('Mis Datos') }}
                            </a>
                            <a class="nav-link" id="v-pills-addresses-tab" data-toggle="pill" href="#v-pills-addresses" role="tab" aria-controls="v-pills-addresses" aria-selected="false">
                                {{ __('Direcciones') }}
                            </a>
                            <a class="nav-link" id="v-pills-orders-tab" data-toggle="pill" href="#v-pills-orders" role="tab" aria-controls="v-pills-orders" aria-selected="false">
                                {{ __('Ordenes') }}
                            </a>
                            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                                {{ __('Seguridad') }}
                            </a>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                @include('landing.account.components.user')
                            </div>
                            <div class="tab-pane fade" id="v-pills-addresses" role="tabpanel" aria-labelledby="v-pills-addresses-tab">
                                @include('landing.account.components.addresses')
                            </div>
                            <div class="tab-pane fade" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                                @include('landing.account.components.orders')
                            </div>
                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                @include('landing.account.components.security')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
<form action="{{ route('landing.account.destroy') }}" method="POST" autocomplete="off">
    @csrf  @method('DELETE')
    <div class="modal fade" id="delete-account-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title">{{ __('¿Estás seguro que quieres eliminar tu cuenta?') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        <strong class="text-uppercase">{{ __('Advertencia') }}</strong> <br>
                        {{ __('Al eliminar tu cuenta, perderás todo tipo de acceso a ella, para finalizar este proceso, ingresa tu contraseña para verificar tu identidad.') }}
                    </div>

                    <div class="form-group col-md-12 @if(session('status-danger-password')) text-danger @endif">
                        <input type="password" class="form-control @if(session('status-danger-password')) is-invalid @endif" name="password"  placeholder="{{ __('Password') }}" autofocus minlength="8" required>
                        @if(session('status-danger-password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ session('status-danger-password') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="alert alert-info" role="alert" style="padding: 20px;">
                        {{ __('Una vez que tu cuenta ha sido borrada, no podremos restaurar tu contenido.') }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">{{ __('Cancelar') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('Si, Eliminar cuenta') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endpush

@push('js')
@if(session('status-danger-password'))
<script type="text/javascript">
    $('#delete-account-modal').modal('toggle');
</script>
@endif
@endpush
