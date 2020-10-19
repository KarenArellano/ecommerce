const imageExtensions = require('image-extensions');

$('#gallery').on('change', function (event) {
    const requestOfImages = new FormData();

    for (var i = 0; i < this.files.length; i++) {
        requestOfImages.append('images[]', this.files[i], this.files[i].name);
    }

    requestOfImages.append('_method', 'PUT');

    $('#progressbar-modal').modal('show');

    axios.post(window.location.href.replace('/edit', ''), requestOfImages, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
        })
        .then(function (response) {
            window.location.reload();
        })
        .catch(function (error) {
            console.log('error', error)
        })
});


$('#gallery-videos').on('change', function (event) {

    const requestOfImages = new FormData();
    console.log("change videos input")

    for (var i = 0; i < this.files.length; i++) {
        requestOfImages.append('videos[]', this.files[i], this.files[i].name);
    }

    requestOfImages.append('_method', 'PUT');

    $('#progressbar-modal').modal('show');

    axios.post(window.location.href.replace('/edit', ''), requestOfImages, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
        })
        .then(function (response) {
            window.location.reload();
        })
        .catch(function (error) {
            console.log('error', error)
        })

        $(this).value(null)
});

$('[data-delete-image]').on('click', function (event) {
    event.preventDefault();

    $('#progressbar-modal').modal('show');

    axios.post($(this).attr('href'), {
        image: $(this).data('deleteImage'),
        _method: 'DELETE',
    }).then(function (response) {
        window.location.reload();
    });
});

$('#products-update-form-submit-button').click(function (event) {
    event.preventDefault();

    let submitButton = $(this);

    $('form#products-update-form').validate({
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

    $('form#products-update-form').submit();
});