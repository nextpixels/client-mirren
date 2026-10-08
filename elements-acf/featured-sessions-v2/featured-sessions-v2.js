document.addEventListener( 'DOMContentLoaded', function(e) {
	add_event('.featured-sessions-tab-link','click',featured_sessions_tab_click);
});


function featured_sessions_tab_click(e){
	e.preventDefault();

	var tabTarget = get_attr(this,'data-target');

	remove_class('.featured-sessions-tab-link','current');
	add_class(this,'current');

	remove_class('.featured-sessions-tab-content','current');
	add_class('#featured-sessions-tab-content-'+tabTarget,'current');
}

