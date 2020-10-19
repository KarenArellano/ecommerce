<div class="panel panel-default">
    <div class="panel-body">
        <div class="text-center">
            <i class="far fa-check-circle fa-7x text-success" style="margin-bottom: 10px;"></i>
            <h2 style="margin-bottom: 10px;">{{ __('¡Gracias :name!', ['name' => $order->user->first_name]) }}</h2>
            <h3 class="lead" style="line-height: 2rem;">
                {{ __('Tu compra fue realizada con exito.') }} <br>
                {!! __('En breve recibiras una notificación al correo electrónico:<br><u>:email</u><br>Con todos los detalles de tu compra.', ['email' => $order->user->email,]) !!}
            </h3>
            <hr>
            <p>
                <button type="button" class="btn btn-link" onclick="window.location = '{{ url('/') }}'">
                    <i class="fas fa-home"></i>
                    {{ __('Ir a al inicio') }}
                </button>
                <button type="button" class="btn btn-link" onclick="window.location = '{{ route('landing.products.index') }}'">
                    {{ __('Seguir explorando') }}
                    <i class="fas fa-chevron-right"></i>
                </button>
            </p>
        </div>
    </div>
</div>
