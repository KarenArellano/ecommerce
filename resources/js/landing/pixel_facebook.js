
$(".callPixelFacebook").click(function (){
    $.ajax({
        method: "POST",
        url: "contactpixel",
        headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
        }).done(function( msg ) {
            console.log(msg)
    });
})