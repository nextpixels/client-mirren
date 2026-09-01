$(function() {

//Switch the order of the last name/email boxes on the attendee info page
  var CONTROL_INTERVAL = setInterval(function(){
    // Check if element exist
    if($('.tribe-tickets__form-field-input-wrapper').length > 0){
        // Since element is created, no need to check anymore

        $(".tribe-tickets__attendee-tickets-item").each(function (i) {
			var jobtitle = $(this).find('.tribe-tickets__form-field:nth-child(5)').detach();
			var lastname = $(this).find('.tribe-tickets__form-field:nth-child(4)').detach();
			var email = $(this).find('.tribe-tickets__form-field:nth-child(3)');
			
			lastname.insertBefore(email);
			jobtitle.insertBefore(email);

        });
		
		$("#tribe-tickets_179_last-name_1").attr("placeholder", "Optional");
		$("#tribe-tickets_179_job-title_1").attr("placeholder", "Optional");
		
        clearInterval(CONTROL_INTERVAL);
    }
  }, 5); // check for every 100ms

});