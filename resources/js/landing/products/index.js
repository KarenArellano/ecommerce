require('./show');

$(document).ready(function () {
    if ($.fn.owlCarousel) {
        $('[data-owl-carousel="true"]').each((_, el) => {
            let owl = $(el).owlCarousel({
                loop: true,
                dots: false,
                autoplay: true,
                autoplayHoverPause: true,
                autoplayTimeout: 5000,
                smartSpeed: 1000,
                responsive: {
                    0: {
                        margin: 15,
                        items: 1
                    },
                    600: {
                        margin: 15,
                        items: 1,
                    },
                    768: {
                        margin: 30,
                        items: 1
                    }
                }
            });
        });
    }

    $('[data-nice-select="true"]').each(function (_, select) {
        $(select).niceSelect();
    });

    // this code clear all filters on products view landing page 

    $("#clear").click(function () {

        var clean_uri = location.protocol + "//" + location.host + location.pathname;

        window.history.replaceState({}, document.title, clean_uri);

        location.reload();
    })

    $("input[name='phone']").focusout(function () {

        console.log("typing")

        $(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d{4})+$/, "($1) $2-$3"));

    });
});