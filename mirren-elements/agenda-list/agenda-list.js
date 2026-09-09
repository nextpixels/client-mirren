document.addEventListener( 'DOMContentLoaded', function(e) {
	open_default_tab(default_tab);
	add_event('.day-navigation-link','click',day_navigation_click);

	//Associate the already-loaded URL with its tab, so navigating back to it later (via the
	//browser's back/forward buttons) reports the right value through popstate below:
	history.replaceState({tab: default_tab},'',window.location.href);

	//Keep the visible tab in sync when using the browser's back/forward buttons, since clicking a
	//tab now pushes a new history entry (see day_navigation_click below):
	window.addEventListener('popstate',function(e){
		if (e.state && e.state.tab){
			show_tab(e.state.tab);
		}
	});
});


function open_default_tab(selectedDate){
	show_tab(selectedDate);
}


function day_navigation_click(e){
	e.preventDefault();

	var selectedDate = get_attr(this,'data-date');

	show_tab(selectedDate);

	//Update the URL to a pretty "/tab-value/" path (e.g. /agenda/day-1/) rather than a query
	//string, so it can be bookmarked or shared -- this matches mirren_agenda_list_pretty_tab_url()
	//in functions.php, which makes that path actually resolve. Built from the page's own clean
	//permalink (agenda_page_base_url, printed above) rather than the current address bar, since
	//that may already carry a previous tab's suffix or the old ?tab= form:
		var newUrl = agenda_page_base_url+'/'+encodeURIComponent(selectedDate)+'/';
		history.pushState({tab: selectedDate},'',newUrl);

	document.getElementById("agenda-listing-grid").scrollIntoView();

}


//Shows the given day's tab/content. Shared by the initial page load, tab clicks, and browser
//back/forward navigation, so all three stay in sync with each other.
function show_tab(selectedDate){
	remove_class('.day-navigation-link','current');
	$('.tab-'+selectedDate).addClass('current');				//TODO: jQuery

	hide('.day-content');
	show('#day-'+selectedDate);
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