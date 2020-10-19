const imageExtensions = require('image-extensions');

var tags = new Bloodhound({
    initialize: false,
    local: $('[data-role="tagsinput"]').data('tags'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    datumTokenizer: Bloodhound.tokenizers.whitespace
});

tags.initialize();

$('[data-role="tagsinput"]').tagsinput({
    typeaheadjs: {
        source: tags.ttAdapter()
    }
});

$('#galleries-create-form-submit-button').click(function (event) {
    event.preventDefault();

    let submitButton = $(this);

    $('#galleries-create-form').validate({
        rules: {
            title: {
                required: true,
                maxlength: 255,
            },
            image_file: {
                extension: imageExtensions.join('|'),
            },
        },
        submitHandler: function (form) {
            event.preventDefault();

            $(form).disableSubmitButton();

            $(form).valid() ? form.submit() : $(form).enableSubmitButton();
        }
    });

    $('form#galleries-create-form').submit();
});