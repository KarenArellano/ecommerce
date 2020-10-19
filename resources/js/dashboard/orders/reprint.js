$("#orders-reprint-label-modal").on("show.bs.modal", function (event) {

    var order = $(event.relatedTarget).data("order");

    let modal = $(this);

    console.log(order)

    $(".modal-footer a.reprint").remove()

    var urlEdit = window.location.origin + `/dashboard/address/${order.id}/edit?orderId=${order.id}`

    $(".modal-footer").append(`<a href=${urlEdit} class="btn tx-13 btn-info reprint">
    <i data-feather="tag" class="wd-15 ht-15"></i>
        aceptar
    </a>`);
});


