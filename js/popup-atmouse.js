/* At mouse popup */
jQuery(document).ready(function(){
	jQuery(document).on('click','.popup-close-link',atmousepopup_close_fromlink);
});

jQuery(document).on('click','.atmousepopup-link',function(e){
	e.preventDefault();
	var target = '#'+jQuery(this).attr('data-target');
	var dataPositionX=jQuery(this).attr('data-position-x');	//"left" data-position-y="middle"
	var dataPositionY=jQuery(this).attr('data-position-y');	//"left" data-position-y="middle"
	
		popupOptions = {
			'position-x':  dataPositionX,
			'position-y':  dataPositionY,
			'positioning': 'page'
		};
	
	atmousepopup_open(e,target,popupOptions);
});

function atmousepopup_close_fromlink(e){
	e.preventDefault();
	
	var target = jQuery(this).attr('data-target');
	
	if (target.charAt(0) != "#"){
		target = "#"+target;
	}
	
	if (target){
		atmousepopup_close(target);
	}
	else{
		console.log('Error: No target popup given');
	}
}

function atmousepopup_close(target){
	jQuery('.popup-screen').hide();
	jQuery(target).hide();
}

function atmousepopup_open(e,target,popupOptions=""){
	console.log('Opening Wndow');
	
	/*
	popupOptions = {
		'position-x': "left",
		'position-y': "middle"
	};
	*/
    /*    
    popupOptions.ignorePageScrollPosition -- won't add the current page scroll position when calculating top of popup box. Handy for a fixed position sidebar.
    */

	var popupOptions = popupOptions || {};
	var options = popupOptions || {};
	var bottomBuffer;
	
	//popupOptions['position-x'] = "center";
	
	if (options.bottomBuffer){	//Use this if there is a fixed footer at the bottom of the page, since the popup could be hidden under it.
		bottomBuffer = options.bottomBuffer;
	}
	else{
		var bottomBuffer = 0;		
	}
	
	var 
		currEl								= jQuery(target),
		popupLeft, 
		popupTop, 
		popupWidth 				= currEl.width() + parseInt(currEl.css('padding-left'))+ parseInt(currEl.css('padding-right')),
		popupHeight 				= currEl.height(),
		popupMarginTop		= parseInt(currEl.css('marginTop')),
		windowWidth 				= jQuery(window).width(),
		windowHeight				= jQuery(window).height(),
		scrollTop						= jQuery(document).scrollTop();
	
		
	if (popupOptions['positioning'] ==  'atmouse'){
		
			//Left Position.  Prefer centered, unless on the edges of the screen:
				if (popupOptions['position-x']  == "center"){
					popupLeft = e.clientX - (popupWidth/2);
				}
				else{
					console.log('not centered');
					popupLeft = e.clientX + 10;
				}
				
				//If it will spill off the right margin:
					if (popupLeft + popupWidth > windowWidth){
						popupLeft = windowWidth - (popupWidth);
					}		
					
				//If it will spill of the left margin:
					if (popupLeft < 0){
						popupLeft = e.clientX;
					}
					
				//If it's still going to spill over the right margin and we're using the mouse as the left position, just make it full width:	
					if (popupLeft + popupWidth > windowWidth){
						popupLeft = 10;
						popupWidth = windowWidth - 20;
					}

			//Top Position:	
				//if (popupOptions.ignorePageScrollPosition == true){
				if (popupOptions['position-y'] == "top"){
					popupTop = e.clientY;
				}
				else if(popupOptions['position-y'] == "bottom"){
					popupTop = e.clientY - popupHeight;
				}
				else{
					popupTop = e.clientY - (popupHeight/2);
				}
				
				//If it will spill of the bottom of the page:
					var popupBottom 	= popupTop + (popupHeight/2);
					var windowBottom 	= windowHeight;
					
					var tmp = scrollTop + windowHeight - popupTop + popupHeight;
					
					if (popupBottom > (windowHeight)){
						//popupTop = popupTop - popupHeight;
						popupTop = e.clientY - popupHeight;
					}
					
				//If it will spill off the top of the page:
					if ((popupTop + popupMarginTop) < 0){
						popupTop = 30;
						popupMarginTop = 0;
					}
				
			if (popupOptions && popupOptions.useScreen == true){
				jQuery('.popup-screen').show();
			}	
			
			jQuery(target).css({'left':popupLeft,'top':popupTop,'marginTop':popupMarginTop,'marginLeft':'0','width':popupWidth}).show();
		}
	else{
		jQuery(target).show();
	}
}