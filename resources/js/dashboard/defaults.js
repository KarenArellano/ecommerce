$('table.table').DataTable({
    language: {
        url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json'
    },
    destroy: true,
    responsive: true,
    // "scrollY": 200,
    // "scrollX": true
    // "order": [[ 0, "desc" ]],

    bAutoWidth: false,
    drawCallback: settings => {
        feather.replace();

        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity
        });
    }
});

$('.modal').on('show.bs.modal', event => {
    let modal = $(event.relatedTarget);

    let animation = modal.data('animation');

    modal.addClass(animation || '');
}).on('hidden.bs.modal', event => {
    let modal = $(event.relatedTarget);

    modal.removeClass((_, className) => {
        return (className.match(/(^|\s)effect-\S+/g) || []).join(' ');
    });
});

$.validator.setDefaults({
    highlight: element => {
        $(element).closest(':input').addClass('is-invalid').removeClass('is-valid');
    },
    unhighlight: element => {
        $(element).closest(':input').addClass('is-valid').removeClass('is-invalid');
    },
    errorElement: 'span',
    errorClass: 'invalid-feedback tx-medium tx-12',
    validClass: 'valid-feedback tx-medium tx-12',
    errorPlacement: (error, element) => {
        // taken from: https://stackoverflow.com/a/48063602
        let parents = $(element).parents('.form-group');

        let currentErrorElement = parents.find(`#${error.attr('id')}`);

        currentErrorElement.length ? currentErrorElement.html(error) : parents.append(error);
    }
});

$.validator.addMethod("greaterThan", function (value, element, param) {
    return Number(value.split(',').join('')) > Number($(param).val().split(',').join(''));
}, 'El precio de venta, debe ser mayor el costo adquisición');

$('[data-mask-phone]').each(_, element => {
    new Cleave($(element), {
        phone: true,
        phoneRegionCode: 'MX'
    });
});

$('[data-mask-price]').each((_, element) => {
    new Cleave($(element), {
        numeral: true,
        numeralPositiveOnly: true,
        numeralThousandsGroupStyle: 'thousand'
    });
});

$('[data-mask-zipcode]').each(_, element => {
    new Cleave($(element), {
        blocks: [10],
        uppercase: true,
    });
});

$('textarea').each((_, element) => {
    element.setAttribute('style', `height:${(element.scrollHeight)}px;overflow-y:hidden;`);
}).on('input', element => {
    element.style.height = 'auto';
    element.style.height = `${(element.scrollHeight)}px`;
});

$.fn.startLoading = function (disabled = true) {
    let button = $(this);

    let before = button.data('beforeLoading');

    let after = button.data('afterLoading');

    button.prop('disabled', disabled);

    button.html(disabled ? after : before);

    feather.replace();
};

$.fn.stopLoading = function () {
    let button = $(this);

    button.startLoading(false);
};

$('.select2').each((_, element) => {
    $(element).select2({
        language: document.documentElement.lang
    });
});

$.fn.disableSubmitButton = function (isDisabled = true) {
    this.each(function () {
        switch ($(this).prop('tagName').toLowerCase()) {
        case 'button':
            let currentButton = $(this);
            currentButton.prop('disabled', isDisabled);
            currentButton.html(isDisabled ? currentButton.data('contentAfterSubmit') : currentButton.data('contentBeforeSubmit'))
            break;

        case 'form':
            let button = $(this).find(':submit').prop('disabled', isDisabled);
            break;

        default:
            return $(this);
            break;
        }
        feather.replace();
    });
};

$('.dropify').dropify({
    messages: {
        'default': 'Arrastra y suelta un archivo aquí o haz clic para seleccionar',
        'replace': 'Arrastra y suelta un archivo aquí o haz clic para remplazar',
        'remove': 'Eliminar',
        'error': 'Ooops, Algo paso.'
    },
    error: {
        'fileSize': 'El tamaño del archivo es demasiado grande (maximo {{ value }}).',
        'minWidth': 'El ancho de la imagen es demasiado pequeño (minimo {{ value }}}px).',
        'maxWidth': 'El ancho de la imagen es demasiado grande (maximo {{ value }}}px).',
        'minHeight': 'La altura de la imagen es demasiado pequeña (minimo {{ value }}}px).',
        'maxHeight': 'La altura de la imagen es demasiado grande (maximo {{ value }}px).',
        'imageFormat': 'El formato de la imagen no está permitido (solo {{ value }}).',
        'fileExtension': 'La extension de la imagen no está permitida (solo {{ value }}).',
    }
});