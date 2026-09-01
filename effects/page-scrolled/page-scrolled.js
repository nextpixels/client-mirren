$(window).scroll(function() {    
    var scroll = $(window).scrollTop();

    if (scroll >= 550) {
        $("body").addClass("page-scrolled-500");
    }
	if (scroll < 400){
		  $("body").removeClass("page-scrolled-500");
	}
	
	if (scroll >= 100) {
        $("body").addClass("page-scrolled-100");
    }
	if (scroll < 100){
		  $("body").removeClass("page-scrolled-100");
	}
	
	if (scroll >= 50) {
        $("body").addClass("page-scrolled-50");
    }
	if (scroll < 50){
		  $("body").removeClass("page-scrolled-50");
	}
	
});