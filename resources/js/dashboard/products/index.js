require('./create');

require('./edit');

require('./delete');

$(document.body).on('input', '#price', function (event) {
    event.preventDefault();
    
    displayGainPercentage();
}).on('input', '#unit-price', function (event) {
    event.preventDefault();

    displayGainPercentage();
});

function displayGainPercentage() {
    let unitPrice = Number($('#unit-price').val().split(',').join(''));

    let price = Number($('#price').val().split(',').join(''));

    let difference = Number(price - unitPrice);

    let percentage = (((difference || 1) / (unitPrice || 1)) * 100) || 0

    $('#gain-percentage').val(Number.parseFloat(percentage).toFixed(2));
}

