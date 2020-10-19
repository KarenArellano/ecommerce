<!-- Modal -->
@if($first_coupon)

<!-- Button trigger modal -->

<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coupon-modal">
  Launch demo modal
</button> -->

<div class="modal fade" id="coupon-modal" tabindex="-1" role="dialog" aria-labelledby="coupon-modal" aria-hidden="true" data-keyboard="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="coupon-modal">Hola.. Tenemos un coupon de descuento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <h4>{{ __('Codigo ') ."(". $first_coupon->name .")". ' con un '. $first_coupon->percent. '% de descuento, sobre el total de tu compra'  }}</h4>

                @if($first_coupon->cover)

                 <img class="productSize resizeImg" src="{{ $first_coupon->cover->public_url }}" alt="{{ $first_coupon->name }}">
                                
                @endif

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar') }}</button>
                <!-- <button type="button" class="btn btn-primary"></button> -->
            </div>
        </div>
    </div>
</div>
@endif
<!-- End Modal Coupon -->