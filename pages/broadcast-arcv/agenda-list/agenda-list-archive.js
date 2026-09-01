document.addEventListener( 'DOMContentLoaded', function(e) {
	open_default_tab(default_tab);
	add_event('.day-navigation-link','click',day_navigation_click);
	//add_event('.session-detail-link','click',session_detail_click);
});


function open_default_tab(selectedDate){
	remove_class('.day-navigation-link','current');
	$('.tab-'+selectedDate).addClass('current');				//TODO: jQuery
	show('#day-'+selectedDate);
}


function day_navigation_click(e){
	e.preventDefault();
	var selectedDate = get_attr(this,'data-date');
	
	remove_class('.day-navigation-link','current');
	$('.tab-'+selectedDate).addClass('current');				//TODO: jQuery
	
	hide('.day-content');
	show('#day-'+selectedDate);
	
	//$( "#agenda-listing-grid" ).scroll();
	document.getElementById("agenda-listing-grid").scrollIntoView();

}

/*
function session_detail_click(e){
	e.preventDefault();
	
	hide_if_clicked_off('#session-detail');
	show('#session-detail');
	var id = get_attr(this,'data-id');
	replace_html('#session-detail-title',agenda_data[id]['title']);
	replace_html('#session-detail-description',agenda_data[id]['description']);	
}
*/
/*	
function session_detail_close_click(e){
	e.preventDefault();
	hide('#session-detail');
}
*/


$(document).ready(function(e){
	
	$(document).on('click','.session-detail-link',function(e){
		e.preventDefault();
		show('#session-detail');
		hide_if_clicked_off('session-detail');
		
		var id = get_attr(this,'data-id');
		replace_html('#session-detail-title',agenda_data[id]['title']);
		replace_html('#session-detail-description',agenda_data[id]['description']);	
	});
	
});




$(document).ready(function(e){
	
	$(document).on('click','.js-speakers-list-tile',function(e){
		e.preventDefault();
		$('#speaker-detail').show();
		hide_if_clicked_off('speaker-detail');
		
			var id = get_attr(this,'data-id');
			
			replace_html('#speaker-detail-company',speakersByName[id]['speaker_company']);
			replace_html('#speaker-detail-name',speakersByName[id]['name']);
			replace_html('#speaker-detail-title',speakersByName[id]['speaker_title']);
			replace_html('#speaker-detail-description',speakersByName[id]['speaker_bio']);
			replace_html('#speaker-detail-image','<img src="'+speakersByName[id]['image']+'" />');
	});
	
});



/* -------------- */
//document.addEventListener( 'DOMContentLoaded', function(e) {
 //  add_event('.js-speakers-list-tile','click',speaker_detail_click);
//});
/*
$(document).ready(function(e){

	$(document).on('click','.js-speakers-list-tile',function(e){
		e.preventDefault();
	
		show('#speaker-detail');
		hide_if_clicked_off('speaker-detail');	
		
	}

});
*/
/*
function speaker_detail_click(e){
	e.preventDefault();
	
	//Is there a speaker detail open that we need to take care of?
	//hide('#speaker-detail');
	//this.removeEventListener('click', arguments.callee);

	
	//hide_if_clicked_off('#speaker-detail');
	//hide_if_clicked_off('speaker-detail');
	//hide_if_clicked_off('box');
	
	show('#speaker-detail');
	hide_if_clicked_off('speaker-detail');	
	
	

	var id = get_attr(this,'data-id');
	
	console.log('Id: '+id);
		
	replace_html('#speaker-detail-company',speakersByName[id]['speaker_company']);
	replace_html('#speaker-detail-name',speakersByName[id]['name']);
	replace_html('#speaker-detail-title',speakersByName[id]['speaker_title']);
	replace_html('#speaker-detail-description',speakersByName[id]['speaker_bio']);
	replace_html('#speaker-detail-image','<img src="'+speakersByName[id]['image']+'" />');
	

}


	function hide_if_clicked_off(element){
		console.log('showing: '+element);
		
		document.removeEventListener('click', handleClickOutsideBox);
		document.addEventListener('click', handleClickOutsideBox);
	}
	
	function handleClickOutsideBox(e) {
		  console.log('user clicked: ', e.target);

		  const box = document.getElementById('speaker-detail');

	
		if ($(e.target).hasClass('hide-click-off-link')){			//TODO: REMOVE THIS BIT OF JQUERY
				e.preventDefault();
				document.removeEventListener('click', handleClickOutsideBox);
				box.style.display = 'none';
			}

		  if (!box.contains(e.target)) {
			box.style.display = 'none';
			document.removeEventListener('click', handleClickOutsideBox);
		  }
		  
		  
		}
*/