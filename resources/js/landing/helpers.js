window.inputNumber = function (el) {
    var min = el.attr("min") || false;
    var max = el.attr("max") || false;
    var els = {};
    els.dec = el.prev();
    els.inc = el.next();
    el.each(function () {
        init($(this));
    });

    function init(el) {
        els.dec.on("click", decrement);
        els.inc.on("click", increment);

        function decrement() {
            var value = el[0].value;
            value--;
            if (!min || value >= min) {
                el[0].value = value;
            }
        }

        function increment() {
            var value = el[0].value;
            value++;
            if (!max || value <= max) {
                el[0].value = value++;
            }
        }
    }
};

$('input[name=_rate]').ready(function () {
    calculate(this)
})

$('input[name=_rate]').change(function () {

    calculate(this)
});

function calculate(element) {
    // console.log($(this).val())

    var percentDiscount = Number(0)

    if ($("input[name=percent]") != 'undefined') {
        // console.log($("input[name=percent]"))

        percentDiscount = Number($("input[name=percent]").val())

        // console.log(percentDiscount, "percent")
    }

    var shippingPrice = Number($(element).val().split("|")[0])

    // console.log(shippingPrice,"Shipping price")

    var subtotal = Number($('input[name=_subtotal]').val())

    // console.log(subtotal, "Subtotal")

    var subtotal_ = Number(shippingPrice + subtotal)

    // console.log(subtotal_, "Subtotal with shipping")

    var discount = Number((subtotal_ * percentDiscount) / 100)

    // console.log(discount, "total discount")

    var total = subtotal_ - discount

    // console.log(total)

    $('label[name=_final_price]').text(total.toFixed(2));
}
