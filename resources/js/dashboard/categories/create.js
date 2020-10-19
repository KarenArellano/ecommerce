$('#categories-create-form-submit-button').click(function (event) {
    event.preventDefault();

    let submitButton = $(this);

    $('form#categories-create-form').validate({
        rules: {
            name: {
                required: true,
                maxlength: 255,
            },
        },
        submitHandler: function (form) {
            event.preventDefault();

            submitButton.disableSubmitButton();

            $(form).valid() ? form.submit() : submitButton.disableSubmitButton(false);
        }
    });

    $('form#categories-create-form').submit();
});