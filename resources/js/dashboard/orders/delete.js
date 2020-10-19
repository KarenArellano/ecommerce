$("form[id^='orders-delete']").each(function (key, form) {
    $(`#${form.id}`).validate({
        submitHandler: function (form) {
            event.preventDefault();

            let submitButton = $(form).find(':submit');

            submitButton.disableSubmitButton();

            form.submit();
        }
    });
});