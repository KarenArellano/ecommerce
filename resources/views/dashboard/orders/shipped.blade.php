<form id="orders-update-{{ $order->id }}-form" action="{{ route('dashboard.orders.update', $order) }}" method="POST" role="form" autocomplete="off">
    @csrf 
    @method('PUT')
    {{ method_field('PUT') }}
    <div class="modal fade" id="orders-update-{{ $order->id }}-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content tx-14">
                <div class="modal-header d-flex align-items-center">
                    <h6 class="modal-title text-uppercase" id="exampleModalLabel5">{{ __('Cambiar estatus a enviando orden') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        <strong>
                            {{ __('¿Está seguro que quiere cambiar el estatus de la orden :reference?', ['reference' => $order->reference]) }}
                        </strong>
                    </p>
                    <!-- <p>
                        {{ __('Al cancelar la orden, todos sus recursos relacionados serán eliminados también, esta acción puede desecadenar errores y/o complicaciones en el uso de la plataforma.') }}
                    </p> -->
                    <!-- <p class="mb-0">
                        {{ __('Ésta acción no podrá ser revertida.') }}
                    </p> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn tx-13 btn-outline-light" data-dismiss="modal">{{ __('Cancelar') }}</button>
                    <button type="submit" class="btn btn btn-danger" data-dismiss="modal" onclick="this.form.submit()">{{ __('Cambiar') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>