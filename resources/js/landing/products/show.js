$('[data-light-slider="true"]').each((_, element) => {
    $(element).lightSlider({
        gallery: true,
        item: 1,
        vertical: true,
        verticalHeight: 450,
        thumbItem: 3,
        slideMargin: 0,
        speed: 600,
        autoplay: true,
        responsive: [{
            breakpoint: 991,
            settings: {
                item: 1
            }
        }, {
            breakpoint: 576,
            settings: {
                item: 1,
                slideMove: 1,
                verticalHeight: 350
            }
        }]
    });
});

inputNumber($(".input-number"));

$('#carouselExampleIndicators').click( function()
{
    let element = $('#carouselExampleIndicators .carousel-item.active video').first();

    var video = element.get(0);

     if(video.paused)
     {
        video.play();
     }
     else
     {
        video.pause();
     }
})

$('#carouselExampleIndicators').bind('slide.bs.carousel', function (e) {
    //pauses when leaves video

    console.log("slide.bs.carousel", e)

    let elemento = $('#carouselExampleIndicators .carousel-item.active video').first();

    elemento.get(0).pause();
});

$("#carouselExampleIndicators").carousel({ interval: false }); // this prevents the auto-loop

var videos = document.querySelectorAll("video.d-block");

videos.forEach(function (e) {

    e.addEventListener('ended', nextHandler, false); 
});

function nextHandler(e) {
    
    console.log("on handler show product")

    $(this).fadeOut('2000', function () {

        // $('a').css('opacity', 1);
        $("#carouselExampleIndicators").carousel('next');

    });
}