var currentTab = "in-person";

document.addEventListener( 'DOMContentLoaded', function(e) {
	add_event('.js-tab','click',tab_click);
	
	order_buttons_hide('uncategorized');
	order_buttons_hide('virtual');
	order_buttons_show('in-person');
		
});


function order_buttons_hide(type){
	var targetElements = get_elements('.product_cat-'+type);
	var windowWidth = get_window_width();
	for (i=0;i<targetElements.length;i++){
		if (windowWidth > 900){
			targetElements[i].style.opacity = 0;
			targetElements[i].style.zIndex = 0;
		}
	}
}

function order_buttons_show(type){
	var targetElements = get_elements('.product_cat-'+type);
	for (i=0;i<targetElements.length;i++){
		targetElements[i].style.opacity = 1;
		targetElements[i].style.zIndex = 1;
	}
}


function tab_click(e){
	e.preventDefault();
	
	var tabTarget = get_attr(this,'data-target');
	currentTab = tabTarget;

	//Update the Tabs:
		remove_class('.js-tab','current');
		add_class('#tab-'+tabTarget,'current');
	
	//hide('.tab-content');
	hide(get_elements('.tab-content'));
	//show('#tab-content-'+tabTarget);
	show(get_elements('#tab-content-'+tabTarget));
	
	
	if (tabTarget == "in-person"){
		order_buttons_hide('virtual');
		order_buttons_show('in-person');
		
		//Update footer tab buttons:
			//hide(get_elements('.js-footer-tab-in-person'));
			//show_inline_block(get_elements('.js-footer-tab-virtual'));
		
	}
	else{
		order_buttons_hide('in-person');
		order_buttons_show('virtual');
		
		//Update footer tab buttons:
			//hide(get_elements('.js-footer-tab-virtual'));
			//show_inline_block(get_elements('.js-footer-tab-in-person'));
	}
	
	if (tabTarget == 'virtual'){
		add_class('#pricing-wrap','pricing-virtual');
		remove_class('#pricing-wrap','pricing-in-person');
	}
	else{
		add_class('#pricing-wrap','pricing-in-person');
		remove_class('#pricing-wrap','pricing-virtual');
	}

}






$(document).ready(function(e){
	$(document).on('click','.register-details-link',function(e){
		e.preventDefault();
		
		show('#register-detail');
		hide_if_clicked_off('register-detail');	
		
		var id = get_attr(this,'data-id');
	
		replace_html('#registration-detail-title',productProperties[id]['Title']);
		replace_html('#registration-detail-content',productProperties[id]['Meta']['popup_text']);
	});
});



/*
function register_detail_click(e){
	e.preventDefault();
	hide_if_clicked_off('#register-detail');
	show('#register-detail');
	
	var id = get_attr(this,'data-id');
	
	replace_html('#registration-detail-title',productProperties[id]['Title']);
	replace_html('#registration-detail-content',productProperties[id]['Meta']['popup_text']);
}

function register_detail_close_click(e){
	e.preventDefault();
	hide('#register-detail');
}
*/



function hide_if_clicked_off(element){
		hideIfClickedOffElement = element;

		document.removeEventListener('click', handleClickOutsideBox);
		document.addEventListener('click', handleClickOutsideBox);
	}
	
	
function handleClickOutsideBox(e) {

	  const box = document.getElementById(hideIfClickedOffElement);

	if ($(e.target).hasClass('hide-click-off-link')){			
		e.preventDefault();
		
		document.removeEventListener('click', handleClickOutsideBox);
		box.style.display = 'none';
	}
	

  if (!box.contains(e.target)) {
	box.style.display = 'none';
	document.removeEventListener('click', handleClickOutsideBox);
  }
}


//If the user has resized the window, just show all of the quantity selectors:
let resizeTimer;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
        
		//If less than 900, show all register quantity buttons
			if (get_window_width() < 900){
				
				var targetElements = get_elements('.product_cat-in-person');
				for (i=0;i<targetElements.length;i++){
					targetElements[i].style.opacity = 1;
				}
				var targetElements = get_elements('.product_cat-virtual');
				for (i=0;i<targetElements.length;i++){
					targetElements[i].style.opacity = 1;
				}
				
			}
			else{
				if (currentTab == "in-person"){
					var targetElements = get_elements('.product_cat-in-person');
					for (i=0;i<targetElements.length;i++){
						targetElements[i].style.opacity = 1;
					}
					var targetElements = get_elements('.product_cat-virtual');
					for (i=0;i<targetElements.length;i++){
						targetElements[i].style.opacity = 0;
					}
					
				}
	
			}
		
    }, 250); // Adjust the debounce time as needed
});