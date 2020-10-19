$("#products-detail-modal").on("show.bs.modal", function (event) {

    var products = $(event.relatedTarget).data("order");

    let modal = $(this);

    // $(".modal-title").html(`<strong>Datos de paqueteria</strong> <br>Folio de orden: ${order.order_id}`);

    console.log(products)

    $("tr#content-products").remove()

    $.each(products, function (index, product) {
        console.log(index, product);

        var content = "<tr id='content-products'>"

        content += '<td>' + product.name + '</td>';
        content += '<td>' + "$" + product.price + 'USD' + '</td>';
        // content += '<tr><td>' +  "<img class='singleProduct' src='{{ $product.gallery[0].public_url }}' alt=''>" + '</td></tr>';
        content += '<td>' + product.pivot.quantity + '</td>';

        console.log(content)

        content += "</td>"

        $("table.container-products").append(content);
    });
});