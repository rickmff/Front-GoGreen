$(function() {
	
    $(window).scroll(function(){

		var wScreen = $(window).width();

		if ($(this).scrollTop() > 160) {
				$('.gotop').addClass("show");
			} else {
				$('.gotop').removeClass("show");
		}	
    });

    $('.gotop').click(function() {
        $('body,html').animate({scrollTop:0},1000);
    });
});

$(function(){
    $(window).resize(function(){
        if($(this).width() >= 992){
			$('.top-menu').scrollToFixed();
         } else {
             $('.top-menu').unbind('scrollToFixed');

         }
    })
    .resize();//trigger resize on page load
});

function getLoading(){
    var montaLoader = '<div id="elm_loading"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i><span class="sr-only">Carregando...</span></div>';
    $('body').prepend(montaLoader).fadeIn();
}

function delLoading(){
    $('#elm_loading').remove();
}