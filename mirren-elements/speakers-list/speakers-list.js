/*
name,
image,
company
speaker_title,
speaker_company,
*/


var hideIfClickedOffElement;

$(document).ready(function(e){

	$(document).on('click','.speakers-list-tile',function(e){
		e.preventDefault();
		
		show('#speaker-detail');
		hide_if_clicked_off('speaker-detail');	
			
			var id = get_attr(this,'data-id');
	
			console.log('Id: '+id);
			console.log(speakersByName);
			console.log('test');
	
			if(typeof speakersByName[id]!= "undefined"){
				replace_html('#speaker-detail-company',speakersByName[id]['speaker_company']);
				replace_html('#speaker-detail-name',speakersByName[id]['name']);
				replace_html('#speaker-detail-title',speakersByName[id]['speaker_title']);
				replace_html('#speaker-detail-description',speakersByName[id]['speaker_bio']);
				replace_html('#speaker-detail-image','<img src="'+speakersByName[id]['image']+'" />');
			}
			
			var sessionsOutput = "";
			if(typeof speakerSessions[id] != "undefined"){
					
					for (i=0;i<speakerSessions[id].length;i++){
						let key = speakerSessions[id][i];
						sessionsOutput += "<div class='speaker-detail-session-tile'>";
						sessionsOutput += "<h4>"+sessions[key]['session_title']+"</h4>";
						sessionsOutput += "<div>"+sessions[key]['session_datetime_nice']+" ET</div>";
						sessionsOutput += "<div class='speaker-detail-session-description'>"+sessions[key]['session_description']+"</div>";
						sessionsOutput += "</div>";
					}

			}
				
			replace_html('#speaker-detail-sessions',sessionsOutput);
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







/*
document.addEventListener( 'DOMContentLoaded', function(e) {
   add_event('.speakers-list-tile','click',speaker_detail_click);
});


function speaker_detail_click(e){
	e.preventDefault();
	
	hide_if_clicked_off('#speaker-detail');

	console.log('Showing Speaker Detail');
	show('#speaker-detail');

	var id = get_attr(this,'data-id');
	
	replace_html('#speaker-detail-company',speakersByName[id]['speaker_company']);
	replace_html('#speaker-detail-name',speakersByName[id]['name']);
	replace_html('#speaker-detail-title',speakersByName[id]['speaker_title']);
	replace_html('#speaker-detail-description',speakersByName[id]['speaker_bio']);
	replace_html('#speaker-detail-image','<img src="'+speakersByName[id]['image']+'" />');
	
	var sessionsOutput = "";
	for (i=0;i<speakerSessions[id].length;i++){
		let key = speakerSessions[id][i];
		sessionsOutput += "<div class='speaker-detail-session-tile'>";
		sessionsOutput += "<h4>"+sessions[key]['session_title']+"</h4>";
		sessionsOutput += "<div>"+sessions[key]['session_datetime_nice']+" CT</div>";
		sessionsOutput += "<div class='speaker-detail-session-description'>"+sessions[key]['session_description']+"</div>";
		sessionsOutput += "</div>";
	}
	replace_html('#speaker-detail-sessions',sessionsOutput);
	
}

*/

