<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>{{ __('Fecha de ingreso') }}</th>
                <th>{{ __('Hora de ingreso') }}</th>
                <th>{{ __('Dirección IP') }}</th>
                <th width="400">{{ __('Dispositivo') }}</th>
                <th>{{ __('Sesión') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user->loginSessions as $session)
            <tr>
                <td class="text-capitalize">{{ $session->at->isoFormat('D MMMM YYYY') }}</td>
                <td class="text-capitalize">{{ $session->at->isoFormat('h:m:s a') }}</td>
                <td>
                    <a href="{{ $session->ip }}" title="{{ $session->ip }}" target="_blank">{{ $session->ip }}</a>
                </td>
                <td>{{ $session->user_agent }}</td>
                <td>
                    @if ($session->ip == request()->ip())
                    <span class="badge badge-success">{{ __('Activa') }}</span>
                    @else
                    <span class="badge badge-secondary">{{ __('Inactiva') }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="clearfix"><hr></div>

    <div class="row">
        <div class="col-12">
            <div class="form-group text-right">
                <button class="btn btn-danger" data-toggle="modal" data-target="#delete-account-modal">
                    {{ __('Eliminar Cuenta') }}
                </button>
            </div>
        </div>
    </div>
</div>
