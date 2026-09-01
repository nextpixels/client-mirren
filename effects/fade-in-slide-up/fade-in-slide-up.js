
$(window).on("load",function() {

	$('.fade-in-slide-up').addClass('off');

  $(window).scroll(function() {
		var windowBottom = $(this).scrollTop() + $(this).innerHeight();
		$(".fade-in-slide-up").each(function() {
		
		//Check the location of each desired element 
		var objectBottom = $(this).offset().top + $(this).outerHeight() -150;
      
		// If the element is completely within bounds of the window, fade it in 
		if (objectBottom < windowBottom) { //object comes into view (scrolling down)
			$(this).addClass('on');
			//if ($(this).css("opacity")==0) {$(this).fadeTo(500,1);}
		} 
		else{ //object goes out of view (scrolling up)
			// if ($(this).css("opacity")==1) {$(this).fadeTo(500,0);}
		}
    });
  }).scroll(); //invoke scroll-handler on page-load
});
