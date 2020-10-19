<form id="orders-delete-{{ $order->id }}-form" action="{{ route('dashboard.orders.destroy', $order) }}" method="POST" role="form" autocomplete="off">
    @csrf @method('DELETE')
    <div class="modal fade" id="orders-delete-{{ $order->id }}-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content tx-14">
                <div class="modal-header d-flex align-items-center">
                    <h6 class="modal-title text-uppercase" id="exampleModalLabel5">{{ __('Cancelar Producto') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        <strong>
                            {{ __('¿Está seguro que quiere cancelar la order :reference?', ['reference' => $order->reference]) }}
                        </strong>
                    </p>
                    <p>
                        {{ __('Al cancelar la orden, todos sus recursos relacionados serán eliminados también, esta acción puede desecadenar errores y/o complicaciones en el uso de la plataforma.') }}
                    </p>
                    <p class="mb-0">
                        {{ __('Ésta acción no podrá ser revertida.') }}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">{{ __('Cancelar') }}</button>
                    <button type="submit" class="btn btn-danger tx-13 btn-delete-resource"
                    data-form-to-submit='orders-delete-{{ $order->id }}-form'
                    data-content-before-submit='<i data-feather="trash" class="wd-10 mg-r-5"></i> {{ __('Cancelar') }}'
                    data-content-after-submit='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __('Cancelando...') }}'>
                    <i data-feather="trash" class="wd-10 mg-r-5"></i> {{ __('Cancelar') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>
