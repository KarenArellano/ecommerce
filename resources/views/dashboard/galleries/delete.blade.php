<form id="galleries-delete-{{ $gallery->id }}-form" action="{{ route('dashboard.galleries.destroy', $gallery) }}" method="post" role="form" autocomplete="off">
    @csrf @method('DELETE')
    <div class="modal fade" id="galleries-delete-{{ $gallery->id }}-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content tx-14">
                <div class="modal-header d-flex align-items-center">
                    <h6 class="modal-title text-uppercase" id="exampleModalLabel5">{{ __('Eliminar Publicación') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        <strong>
                            {{ __('¿Está seguro que quiere eliminar la publicación :name?', ['name' => $gallery->title]) }}
                        </strong>
                    </p>
                    <p>
                        {{ __('Al eliminar la publicación, todos sus recursos relacionados serán eliminados también, esta acción puede desecadenar errores y/o complicaciones en el uso de la plataforma.') }}
                    </p>
                    <p class="mb-0">
                        {{ __('Ésta acción no podrá ser revertida.') }}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">{{ __('Cancelar') }}</button>
                    <button type="submit" class="btn btn-danger tx-13 btn-delete-resource"
                    data-form-to-submit='galleries-delete-{{ $gallery->id }}-form'
                    data-content-before-submit='<i data-feather="trash" class="wd-10 mg-r-5"></i> {{ __('Eliminar') }}'
                    data-content-after-submit='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __('Eliminando...') }}'>
                    <i data-feather="trash" class="wd-10 mg-r-5"></i> {{ __('Eliminar') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>
