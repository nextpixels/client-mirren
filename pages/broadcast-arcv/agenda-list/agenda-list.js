document.addEventListener( 'DOMContentLoaded', function(e) {
	open_default_tab(default_tab);
	add_event('.day-navigation-link','click',day_navigation_click);
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
	
	document.getElementById("agenda-listing-grid").scrollIntoView();

}





$(document).ready(function(e){
	
	$(document).on('click','.session-detail-link',function(e){
		e.preventDefault();
		$('.right-panel').hide();
		show('#session-detail');
		hide_if_clicked_off('session-detail');
		
		var id = get_attr(this,'data-id');
		replace_html('#session-detail-title',agenda_data[id]['title']);
		console.log(agenda_data[id]['description']);
		replace_html('#session-detail-description',agenda_data[id]['description']);	
	});
	
});




$(document).ready(function(e){
	
	$(document).on('click','.js-speakers-list-tile',function(e){
		e.preventDefault();
		$('.right-panel').hide();
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




function hide_if_clicked_off(element){
		hideIfClickedOffElement = element;

		document.removeEventListener('click', handleClickOutsideBox);
		document.addEventListener('click', handleClickOutsideBox);
	}
	
function handleClickOutsideBox(e) {

	  const box = document.getElementById(hideIfClickedOffElement);

	if ($(e.target).hasClass('hide-click-off-link')){			
		e.preventDefault();
		console.log('closing from link');
		document.removeEventListener('click', handleClickOutsideBox);
		box.style.display = 'none';
	}
	

  if (!box.contains(e.target)) {
	box.style.display = 'none';
	document.removeEventListener('click', handleClickOutsideBox);
  }
}