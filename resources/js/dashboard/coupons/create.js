$('#cupons-create-form-submit-button').click(function (event) {

    event.preventDefault();

    let submitButton = $(this);

    $('form#cupons-update-form-submit-button').validate({
        rules: {
            percent: {
                required: true,
                number: true,
            },
            name: {
                maxlength: 255,
            },
        },
        submitHandler: function (form) {
            event.preventDefault();

            submitButton.disableSubmitButton();

            $(form).valid() ? form.submit() : submitButton.disableSubmitButton(false);
        }
    });

    $('form#cupons-create-form-submit-button').submit();
});

console.log("hols")