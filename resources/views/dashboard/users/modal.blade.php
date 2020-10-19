<div class="modal fade" id="email-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Enviar correo') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12 col-lg-12 col-md-12">
                        <form id="email-form" method="POST" autocomplete="off" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="subject">{{__('Asunto')}}</label>
                                    <input class="form-control" id="subject" name="subject" type="text" placeholder='{{ __('Asunto') }}' value="{{ old('subject') }}" maxlength="255" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="message">{{ __('Mensaje') }}</label>
                                    <textarea cols="30" rows="10" class="form-control w-100" name="message" id="message" cols="30" rows="9" placeholder='{{ __('mensaje...') }}'></textarea>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <label><input type="checkbox" class="checkbox_check check_all"> Enviar a todos</label>
                            </div>
                            <br>
                            <div class="form-group col-12">
                                <label for="color">Fondo del email</label>
                                <input class="form-control" type="color" name="background_color" id="color">
                            </div>

                            <div class="form-group col-12">
                                <label for="upload_file">Archivo promocional</label>
                                <input required class="form-control" type="file" name="upload_file" id="upload_file" accept="mage/*">
                            </div>

                            <div class="col-5 offset-5">
                                <div class="spinner-border text-success loading_email" role="status" style="display: none">
                                    <span class="sr-only">{{ __('Cargando...') }}</span>
                                </div>
                            </div>

                            <div class="alert alert-danger print-error-msg" style="display:none">
                                <ul></ul>
                            </div>
                            <div class="alert alert-success print-success-msg" style="display:none">
                                <ul></ul>
                            </div>
                        <form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Cerrar')}}</button>
                <button type="button" class="btn btn-success send">{{ __('Enviar') }}</button>
            </div>
        </div>
    </div>
</div>