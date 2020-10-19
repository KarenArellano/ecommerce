var citynames = new Bloodhound({
    initialize: false,
    local: $('[data-role="tagsinput"]').data('tags'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    datumTokenizer: Bloodhound.tokenizers.whitespace
});

citynames.initialize();

$('[data-role="tagsinput"]').tagsinput({
    typeaheadjs: {
        source: citynames.ttAdapter()
    }
});

$('#posts-update-form-submit-button').click(function (event) {
    event.preventDefault();

    let submitButton = $(this);

    $('#posts-update-form').validate({
        ignore: "#content-editor *",
        rules: {
            title: {
                required: true,
                maxlength: 255,
            },
            excerpt: {
                required: true,
                maxlength: 255,
            },
        },
        submitHandler: function (form) {
            event.preventDefault();

            $(form).disableSubmitButton();

            $(form).valid() ? form.submit() : $(form).enableSubmitButton();
        }
    });

    $('form#posts-update-form').submit();
});