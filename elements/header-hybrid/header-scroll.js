$(window).scroll(function() {    
    var scroll = $(window).scrollTop();

    if (scroll >= 20) {
        $("#masthead").addClass("header-scrolled");
    }
	if (scroll < 20) {
        $("#masthead").removeClass("header-scrolled");
    }
}); 