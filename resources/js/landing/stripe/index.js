// Set your publishable key: remember to change this to your live publishable key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
var publicableKeyStripe = $('meta[name="stripe-token"]').attr('content')

var stripe = Stripe(publicableKeyStripe);
var elements = stripe.elements();

console.log('stripe mode change by app debug') // Dont forget to change the status environment

// Set up Stripe.js and Elements to use in checkout form
var style = {
    base: {
        color: "#32325d",
    }
};
var card = null;
var form = null;

$("span#cart-pyapal-blank-state").ready(function(){

    card = elements.create("card", { style: style });

    console.log("ready cart-pyapal-blank-state", window.location.pathname)

    if(window.location.pathname == "/checkout")
    {
        card.mount("#card-element");

        form = document.getElementById('payment-form');
    
        form.addEventListener('submit', function (ev) {
    
            ev.preventDefault();
    
            if ($('input[name=method]:checked').val() !== 'stripe') {
                form.submit();
                console.log("submit")
                return
            }
    
            $('#progressbar-modal').modal('toggle')
    
            getClientSecret()
        });
    }
})

$('#card-element').on('change', function (event) {
    var displayError = document.getElementById('card-errors');

    console.log('changed stripe card')

    // $('input[name=method]').val('stripe');
    $('input:radio[name=method][value=stripe]').click();

    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});



function confirmPaymentStripe(clientSecret) {
    var nameUser = $('input[name=user_name]').val()

    $('button[name=complete_paypment]').attr('disabled', 'disabled');

    stripe.confirmCardPayment(clientSecret, {
        payment_method: {
            card: card,
            billing_details: {
                name: nameUser
            }
        }
    }).then(function (result) {

        $('button[name=complete_paypment]').removeAttr('disabled');

        console.log(result)

        if (result.error) {
            // Show error to your customer (e.g., insufficient funds)
            console.log(result.error.message);

            showError(result.error.message)

        } else {
            // The payment has been processed!
            if (result.paymentIntent.status === 'succeeded') {
                // Show a success message to your customer
                // There's a risk of the customer closing the window before callback
                // execution. Set up a webhook or plugin to listen for the
                // payment_intent.succeeded event that handles any business critical
                // post-payment actions.

                console.log(result)

                $('input[name=response_stripe]').val(JSON.stringify(result))

                var form = document.getElementById('payment-form');

                form.submit();
            }
        }
    });
}

function getClientSecret() {
    var _rate = $('input[name=_rate]:checked').val()

    var formData = new FormData(document.getElementById("payment-form"));

    formData.append('_rate', _rate)

    $.ajax({
        url: '/getIntent',
        type: 'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        processData: false,
        contentType: false

    }).done(function (response) {

        // console.log(response)

        if (response.error) {
            showError(response.error)
        }
        else {
            confirmPaymentStripe(response.client_secret)
        }


    })
        .fail(function (error) {

            // console.log(error, "Error")

            // showError(error.responseJSON.errors)

            $('#progressbar-modal').modal('toggle')
        })
        .always(function () {

        });
}

function showError(text) {

    $('#progressbar-modal').modal('toggle')

    $('div.msg-error-stripe').html(text)

    $("div.msg-error-stripe").css('display', 'block');

    $("div.msg-error-stripe").delay(10000).fadeOut()
}