const imageExtensions = require('image-extensions');

$('#products-create-form-submit-button').click(function (event) {
    event.preventDefault();

    let submitButton = $(this);

    $('form#products-create-form').validate({
        rules: {
            name: {
                required: true,
                maxlength: 255,
            },
            description: {
                required: true,
            },
            unit_price: {
                required: true,
                number: true,
                min: 1
            },
            price: {
                required: true,
                number: true,
                min: 1,
                greaterThan: "#unit-price"
            },
            stock: {
                number: true,
                min: 1
            },
            cover_image: {
                extension: imageExtensions.join('|'),
            },
        },
        submitHandler: function (form) {
            event.preventDefault();

            submitButton.disableSubmitButton();

            $(form).valid() ? form.submit() : submitButton.disableSubmitButton(false);
        }
    });

    $('form#products-create-form').submit();
});